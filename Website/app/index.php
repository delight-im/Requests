<?php

/*
 * Requests (https://github.com/delight-im/Requests)
 * Copyright (c) delight.im (https://www.delight.im/)
 * Licensed under the MIT License (https://opensource.org/licenses/MIT)
 */

$app->setContentType('text');

$client = new \App\Client();
$server = new \App\Server();
$request = new \App\Request();
$referrer = new \App\Referrer();

$responseTemplate = $app->db()->selectRow(
	'SELECT id, content_type AS contentType, content_text AS contentText, redirect_url AS redirectUrl FROM response_templates WHERE (request_method IS NULL OR request_method = ?) AND (protocol IS NULL OR protocol = ?) AND (server_host IS NULL OR server_host = ?) AND (server_ip IS NULL OR server_ip = ?) AND (server_port IS NULL OR server_port = ?) AND (request_path IS NULL OR request_path = ?) AND (query_params IS NULL OR query_params = ?) AND (body_params IS NULL OR body_params = ?) AND (client_continent IS NULL OR client_continent = ?) AND (client_country IS NULL OR client_country = ?) AND (client_language IS NULL OR client_language = ?) AND (mobile IS NULL OR mobile = ?) AND (platform IS NULL OR platform = ?) AND (browser IS NULL OR browser = ?) AND (referrer_protocol IS NULL OR referrer_protocol = ?) AND (referrer_host IS NULL OR referrer_host = ?) AND (referrer_port IS NULL OR referrer_port = ?) AND (referrer_path IS NULL OR referrer_path = ?) AND (utm_source IS NULL OR utm_source = ?) AND (utm_medium IS NULL OR utm_medium = ?) AND (utm_campaign IS NULL OR utm_campaign = ?) ORDER BY priority DESC LIMIT 1 OFFSET 0',
	[
		$request->getMethod(),
		$request->getProtocol(),
		$server->getHostname(),
		$server->getIpAddress(),
		$server->getPort(),
		$request->getPath(),
		$request->getQueryParams(),
		$request->getBodyParams(),
		$client->getContinentCode(),
		$client->getCountryCode(),
		$client->getLanguageCode(),
		$client->isMobile() === null ? null : ($client->isMobile() ? 1 : 0),
		$client->getPlatform(),
		$client->getBrowser(),
		$referrer->getProtocol(),
		$referrer->getHost(),
		$referrer->getPort(),
		$referrer->getPath(),
		!empty($_GET[\App\Request::UTM_SOURCE]) ? $_GET[\App\Request::UTM_SOURCE] : null,
		!empty($_GET[\App\Request::UTM_MEDIUM]) ? $_GET[\App\Request::UTM_MEDIUM] : null,
		!empty($_GET[\App\Request::UTM_CAMPAIGN]) ? $_GET[\App\Request::UTM_CAMPAIGN] : null,
	]
);

if (!$client->isRobot()) {
	try {
		$app->db()->insert(
			'requests',
			[
				'response_template_id' => !empty($responseTemplate) && !empty($responseTemplate['id']) ? $responseTemplate['id'] : null,
				'request_method' => $request->getMethod(),
				'protocol' => $request->getProtocol(),
				'server_host' => $server->getHostname(),
				'server_ip' => $server->getIpAddress(),
				'server_port' => $server->getPort(),
				'request_path' => $request->getPath(),
				'query_params' => $request->getQueryParams(),
				'body_params' => $request->getBodyParams(),
				'client_continent' => $client->getContinentCode(),
				'client_country' => $client->getCountryCode(),
				'client_language' => $client->getLanguageCode(),
				'mobile' => $client->isMobile() === null ? null : ($client->isMobile() ? 1 : 0),
				'platform' => $client->getPlatform(),
				'browser' => $client->getBrowser(),
				'referrer_protocol' => $referrer->getProtocol(),
				'referrer_host' => $referrer->getHost(),
				'referrer_port' => $referrer->getPort(),
				'referrer_path' => $referrer->getPath(),
				'utm_source' => !empty($_GET[\App\Request::UTM_SOURCE]) ? $_GET[\App\Request::UTM_SOURCE] : null,
				'utm_medium' => !empty($_GET[\App\Request::UTM_MEDIUM]) ? $_GET[\App\Request::UTM_MEDIUM] : null,
				'utm_campaign' => !empty($_GET[\App\Request::UTM_CAMPAIGN]) ? $_GET[\App\Request::UTM_CAMPAIGN] : null,
				'received_at' => \time(),
			]
		);
	}
	catch (\Delight\Db\Throwable\IntegrityConstraintViolationException $ignored) {}
}

if (!empty($responseTemplate) && !empty($responseTemplate['contentType']) && !empty($responseTemplate['contentText'])) {
	\header('Content-Type: ' . $responseTemplate['contentType']);
	echo $responseTemplate['contentText'];
	exit;
}
elseif (!empty($responseTemplate) && !empty($responseTemplate['redirectUrl'])) {
	\header('Location: ' . $responseTemplate['redirectUrl']);
	exit;
}
else {
	$app->setStatus(404);
}

<?php

/*
 * Requests (https://github.com/delight-im/Requests)
 * Copyright (c) delight.im (https://www.delight.im/)
 * Licensed under the MIT License (https://opensource.org/licenses/MIT)
 */

namespace App;

final class Request {

	const UTM_SOURCE = 'utm_source';
	const UTM_MEDIUM = 'utm_medium';
	const UTM_CAMPAIGN = 'utm_campaign';

	private $method;
	private $protocol;
	private $path;
	private $queryParams;
	private $bodyParams;

	public function __construct($path = null) {
		if (empty($path)) {
			$path = !empty($_SERVER['REQUEST_URI']) ? \strtok($_SERVER['REQUEST_URI'], '?') : null;
		}

		$this->method = !empty($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : null;
		$this->protocol = !empty($_SERVER['REQUEST_SCHEME']) ? \strtoupper($_SERVER['REQUEST_SCHEME']) : null;
		$this->path = !empty($path) ? $path : null;

		if (!empty($_GET)) {
			$queryParams = $_GET;
			unset($queryParams[self::UTM_SOURCE]);
			unset($queryParams[self::UTM_MEDIUM]);
			unset($queryParams[self::UTM_CAMPAIGN]);
			$queryParams = \array_keys($queryParams);
			\sort($queryParams);

			$this->queryParams = \implode('&', $queryParams);
		}

		if (!empty($_POST)) {
			$bodyParams = \array_keys($_POST);
			\sort($bodyParams);

			$this->bodyParams = \implode('&', $bodyParams);
		}
	}

	public function getMethod() {
		return $this->method;
	}

	public function getProtocol() {
		return $this->protocol;
	}

	public function getPath() {
		return $this->path;
	}

	public function getQueryParams() {
		return $this->queryParams;
	}

	public function getBodyParams() {
		return $this->bodyParams;
	}

}

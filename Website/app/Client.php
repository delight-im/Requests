<?php

/*
 * Requests (https://github.com/delight-im/Requests)
 * Copyright (c) delight.im (https://www.delight.im/)
 * Licensed under the MIT License (https://opensource.org/licenses/MIT)
 */

namespace App;

use Jenssegers\Agent\Agent;

final class Client {

	private $continentCode;
	private $countryCode;
	private $languageCode;
	private $mobile;
	private $platform;
	private $browser;
	private $robot;

	public function __construct($ipAddress = null, $userAgentString = null) {
		if (empty($ipAddress)) {
			$ipAddress = !empty($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : null;
		}

		if (empty($userAgentString)) {
			$userAgentString = !empty($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : null;
		}

		$agent = new Agent();
		$agent->setUserAgent($userAgentString);

		if (\function_exists('geoip_continent_code_by_name')) {
			$continentCode = \geoip_continent_code_by_name($ipAddress);

			if (!empty($continentCode)) {
				$this->continentCode = \strtolower($continentCode);
			}
		}

		if (\function_exists('geoip_country_code_by_name')) {
			$countryCode = \geoip_country_code_by_name($ipAddress);

			if (!empty($countryCode)) {
				$this->countryCode = \strtolower($countryCode);
			}
		}

		if (!empty($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
			$languageCode = \Locale::acceptFromHttp($_SERVER['HTTP_ACCEPT_LANGUAGE']);

			if (!empty($languageCode)) {
				$this->languageCode = $languageCode;
			}
		}

		if ($agent->isDesktop() === true) {
			if ($agent->isMobile() === true) {
				$this->mobile = null;
			}
			else {
				$this->mobile = false;
			}
		}
		else {
			if ($agent->isMobile() === true) {
				$this->mobile = true;
			}
			else {
				$this->mobile = null;
			}
		}

		$platform = $agent->platform();

		if (!empty($platform)) {
			$this->platform = $platform;
		}

		$browser = $agent->browser();

		if (!empty($browser)) {
			$this->browser = $browser;
		}

		$this->robot = $agent->isRobot() === true;
	}

	public function getContinentCode() {
		return $this->continentCode;
	}

	public function getCountryCode() {
		return $this->countryCode;
	}

	public function getLanguageCode() {
		return $this->languageCode;
	}

	public function isMobile() {
		return $this->mobile;
	}

	public function getPlatform() {
		return $this->platform;
	}

	public function getBrowser() {
		return $this->browser;
	}

	public function isRobot() {
		return $this->robot;
	}

}

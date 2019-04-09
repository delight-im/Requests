<?php

/*
 * Requests (https://github.com/delight-im/Requests)
 * Copyright (c) delight.im (https://www.delight.im/)
 * Licensed under the MIT License (https://opensource.org/licenses/MIT)
 */

namespace App;

final class Referrer {

	private $protocol;
	private $host;
	private $port;
	private $path;

	public function __construct($refererHeader = null) {
		if (empty($refererHeader)) {
			$refererHeader = !empty($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null;
		}

		if (!empty($refererHeader)) {
			$referrerComponents = \parse_url($refererHeader);

			if (!empty($referrerComponents)) {
				$this->protocol = !empty($referrerComponents['scheme']) ? \strtoupper($referrerComponents['scheme']) : null;
				$this->host = !empty($referrerComponents['host']) ? $referrerComponents['host'] : null;
				$this->port = !empty($referrerComponents['port']) ? (int) $referrerComponents['port'] : null;
				$this->path = !empty($referrerComponents['path']) ? $referrerComponents['path'] : null;
			}
		}
	}

	public function getProtocol() {
		return $this->protocol;
	}

	public function getHost() {
		return $this->host;
	}

	public function getPort() {
		return $this->port;
	}

	public function getPath() {
		return $this->path;
	}

}

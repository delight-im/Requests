<?php

/*
 * Requests (https://github.com/delight-im/Requests)
 * Copyright (c) delight.im (https://www.delight.im/)
 * Licensed under the MIT License (https://opensource.org/licenses/MIT)
 */

namespace App;

final class Server {

	private $hostname;
	private $ipAddress;
	private $port;

	public function __construct($hostname = null) {
		if (empty($hostname)) {
			$hostname = !empty($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : null;
		}

		$this->hostname = !empty($hostname) ? $hostname : null;
		$this->ipAddress = !empty($_SERVER['SERVER_ADDR']) ? $_SERVER['SERVER_ADDR'] : null;
		$this->port = !empty($_SERVER['SERVER_PORT']) ? (int) $_SERVER['SERVER_PORT'] : null;
	}

	public function getHostname() {
		return $this->hostname;
	}

	public function getIpAddress() {
		return $this->ipAddress;
	}

	public function getPort() {
		return $this->port;
	}

}

-- Requests (https://github.com/delight-im/Requests)
-- Copyright (c) delight.im (https://www.delight.im/)
-- Licensed under the MIT License (https://opensource.org/licenses/MIT)

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE TABLE IF NOT EXISTS `requests` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `response_template_id` int(10) unsigned DEFAULT NULL,
  `request_method` enum('CONNECT','DELETE','GET','HEAD','OPTIONS','PATCH','POST','PUT','TRACE') NOT NULL,
  `protocol` enum('HTTP','HTTPS') NOT NULL,
  `server_host` varchar(249) NOT NULL,
  `server_ip` varchar(45) NOT NULL,
  `server_port` smallint(5) unsigned NOT NULL,
  `request_path` varchar(255) DEFAULT NULL,
  `query_params` varchar(255) DEFAULT NULL,
  `body_params` varchar(255) DEFAULT NULL,
  `client_continent` varchar(3) DEFAULT NULL,
  `client_country` varchar(3) DEFAULT NULL,
  `client_language` varchar(12) DEFAULT NULL,
  `mobile` tinyint(1) unsigned DEFAULT NULL,
  `platform` varchar(255) DEFAULT NULL,
  `browser` varchar(255) DEFAULT NULL,
  `referrer_protocol` enum('HTTP','HTTPS') DEFAULT NULL,
  `referrer_host` varchar(255) DEFAULT NULL,
  `referrer_port` smallint(5) unsigned DEFAULT NULL,
  `referrer_path` varchar(255) DEFAULT NULL,
  `utm_source` varchar(255) DEFAULT NULL,
  `utm_medium` varchar(255) DEFAULT NULL,
  `utm_campaign` varchar(255) DEFAULT NULL,
  `received_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `received_at_response_template_id` (`received_at`,`response_template_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `response_templates` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `content_type` varchar(255) DEFAULT NULL,
  `content_text` longtext,
  `redirect_url` text,
  `request_method` enum('CONNECT','DELETE','GET','HEAD','OPTIONS','PATCH','POST','PUT','TRACE') DEFAULT NULL,
  `protocol` enum('HTTP','HTTPS') DEFAULT NULL,
  `server_host` varchar(249) DEFAULT NULL,
  `server_ip` varchar(45) DEFAULT NULL,
  `server_port` smallint(5) unsigned DEFAULT NULL,
  `request_path` varchar(255) DEFAULT NULL,
  `query_params` varchar(255) DEFAULT NULL,
  `body_params` varchar(255) DEFAULT NULL,
  `client_continent` varchar(3) DEFAULT NULL,
  `client_country` varchar(3) DEFAULT NULL,
  `client_language` varchar(12) DEFAULT NULL,
  `mobile` tinyint(1) unsigned DEFAULT NULL,
  `platform` varchar(255) DEFAULT NULL,
  `browser` varchar(255) DEFAULT NULL,
  `referrer_protocol` enum('HTTP','HTTPS') DEFAULT NULL,
  `referrer_host` varchar(255) DEFAULT NULL,
  `referrer_port` smallint(5) unsigned DEFAULT NULL,
  `referrer_path` varchar(255) DEFAULT NULL,
  `utm_source` varchar(255) DEFAULT NULL,
  `utm_medium` varchar(255) DEFAULT NULL,
  `utm_campaign` varchar(255) DEFAULT NULL,
  `priority` smallint(5) unsigned NOT NULL DEFAULT '500',
  `created_at` int(10) unsigned NOT NULL,
  `updated_at` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

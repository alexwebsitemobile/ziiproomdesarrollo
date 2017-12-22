<?php

namespace jptt\core;

defined('ABSPATH') or die('No direct script access allowed');

class Schema {

	public static function create_termmeta_table() {
		global $wpdb;
		$wpdb instanceof wpdb;

		$charset = !empty($wpdb->charset) ?
						"DEFAULT CHARACTER SET {$wpdb->charset}" :
						'';

		$collate = !empty($wpdb->collate) ?
						"COLLATE {$wpdb->collate}" :
						'';

		$query = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}termmeta` ("
						. "`meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,"
						. "`term_id` bigint(20) unsigned NOT NULL DEFAULT '0',"
						. "`meta_key` varchar(255) DEFAULT NULL,"
						. "`meta_value` longtext,"
						. "PRIMARY KEY (`meta_id`)"
						. ") ENGINE=InnoDB {$charset} {$collate} AUTO_INCREMENT=1";
		$wpdb->query($query);
		$wpdb->termmeta = "{$wpdb->prefix}termmeta";
	}

}

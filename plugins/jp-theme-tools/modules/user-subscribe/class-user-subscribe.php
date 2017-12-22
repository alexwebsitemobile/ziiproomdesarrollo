<?php

namespace jptt\modules;

defined('ABSPATH') or die('No direct script access allowed');
require_once JPTT_BASEPATH . 'core/class-error.php';

/**
 * @since 0.9.0
 */
class User_subscribe {

	public function __construct() {
		global $wpdb;
		$wpdb instanceof wpdb;

		$charset = !empty($wpdb->charset) ?
						"DEFAULT CHARACTER SET {$wpdb->charset}" :
						'';

		$collate = !empty($wpdb->collate) ?
						"COLLATE {$wpdb->collate}" :
						'';

		$query = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}subscribers` ("
						. "`subscriber_id` int(11) NOT NULL AUTO_INCREMENT,"
						. "`subscriber_name` VARCHAR(255) NULL,"
						. "`subscriber_email` VARCHAR(255) NOT NULL,"
						. "`suscriber_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,"
						. "PRIMARY KEY (`subscriber_id`)"
						. ") ENGINE=InnoDB {$charset} {$collate} AUTO_INCREMENT=1";
		$wpdb->query($query);
	}

	public function is_subscribed($email) {

		if (is_email($email)) {
			global $wpdb;
			$wpdb instanceof \wpdb;

			$query = "SELECT * FROM `{$wpdb->prefix}subscribers` "
							. "WHERE `subscriber_email` = '{$email}'"
							. "LIMIT 1";

			$result = $wpdb->get_row($query);
			return !empty($result);
		} else {
			return new \jptt\core\Error('invalid_email', __('Invalid email', 'jptt'));
		}
	}

	public function add_subscriber($subscriber_email, $subscriber_name) {

		$is_subscribed = $this->is_subscribed($subscriber_email);

		if (is_wp_error($is_subscribed) || $is_subscribed === true) {
			return $is_subscribed;
		}

		global $wpdb;
		$wpdb instanceof \wpdb;

		$wpdb->insert("{$wpdb->prefix}subscribers", compact('subscriber_email', 'subscriber_name'));

		return TRUE;
	}

}

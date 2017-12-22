<?php

namespace jptt\modules;

defined('ABSPATH') or die('No direct script access allowed');

/**
 * @since 0.9.0
 */
class Post_vote {

	public function __construct() {
		global $wpdb;
		$wpdb instanceof wpdb;

		$charset = !empty($wpdb->charset) ?
						"DEFAULT CHARACTER SET {$wpdb->charset}" :
						'';

		$collate = !empty($wpdb->collate) ?
						"COLLATE {$wpdb->collate}" :
						'';

		$query = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}votes` ("
						. "`post_id` bigint(20) NOT NULL,"
						. "`user_id` bigint(20) NOT NULL,"
						. "`value` int(11) NOT NULL,"
						. "KEY `post_id` (`post_id`),"
						. "KEY `user_id` (`user_id`)"
						. ") ENGINE=InnoDB {$charset} {$collate} AUTO_INCREMENT=1";
		$wpdb->query($query);
	}

	public function add_post_vote($post_id, $value, $user_id = NULL) {
		if (!is_numeric($user_id) || $user_id == 0) {
			$user_id = get_current_user_id();
		}

		if ($user_id == 0) {
			return;
		}

		if (!$this->has_voted($post_id, $user_id)) {

			global $wpdb;
			$wpdb instanceof \wpdb;

			$value = (int) $value;

			$wpdb->insert("{$wpdb->prefix}votes", compact('post_id', 'user_id', $value));

			$post_meta = (array) unserialize(get_post_meta($post_id, 'post_vote', true));

			if (!empty($post_meta[$value])) {
				$post_meta[$value]++;
			} else {
				$post_meta[$value] = 1;
			}

			update_post_meta($post_id, 'post_vote',  serialize($post_meta));
		}
	}

	public function has_voted($post_id, $user_id = NULL) {
		if (!is_numeric($user_id) || $user_id == 0) {
			$user_id = get_current_user_id();
		}

		if ($user_id == 0) {
			return;
		}

		global $wpdb;
		$wpdb instanceof \wpdb;

		$query = "SELECT * FROM `{$wpdb->prefix}votes` "
						. "WHERE `post_id` = " . (int) $post_id . " "
						. "AND `user_id` = " . (int) $user_id . " "
						. "LIMIT 1";

		$result = $wpdb->get_row($query);
		return !empty($result);
	}

}

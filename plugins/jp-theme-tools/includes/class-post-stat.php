<?php

/** Block direct access */
defined( 'ABSPATH' ) || die( 'Go get a life script kiddies' );

/**
 *
 */
class Post_Stats {

	/**
	 * Creates stats table
	 * @global wpdb $wpdb
	 */
	public static function create_table() {
		global $wpdb;

		$charset = !empty( $wpdb->charset ) ?
						"DEFAULT CHARACTER SET {$wpdb->charset}" :
						'';
		$collate = !empty( $wpdb->collate ) ?
						"COLLATE {$wpdb->collate}" :
						'';

		$query = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}post_favorites` ("
						. "`favorite_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,"
						. "`post_id` bigint(20) unsigned NOT NULL,"
						. "`user_id` bigint(20) unsigned DEFAULT NULL,"
						. "`is_like` tinyint(1) DEFAULT NULL,"
						. "`is_favorite` tinyint(1) unsigned DEFAULT NULL,"
						. "PRIMARY KEY (`favorite_id`),"
						. "KEY `post_id` (`post_id`)"
						. ") ENGINE=InnoDB {$charset} {$collate} AUTO_INCREMENT=1";

		$wpdb->query( $query );
		$query = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}post_views` ("
						. "`view_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,"
						. "`post_id` bigint(20) unsigned NOT NULL,"
						. "`view_inet` int(10) unsigned DEFAULT NULL,"
						. "`view_date` timestamp NOT NULL ON UPDATE CURRENT_TIMESTAMP,"
						. "PRIMARY KEY (`favorite_id`),"
						. "KEY `post_id` (`post_id`)"
						. ") ENGINE=InnoDB {$charset} {$collate} AUTO_INCREMENT=1";

		$wpdb->query( $query );
	}

	public function toogle_favorite_post( $post_id, $user_id = null ) {

	}

	public function get_favorites_count( $post_id ) {

	}

	public function is_favorite_post( $post_id = null, $user_id = null ) {

	}

	public function set_post_like( $post_id = null, $user_id = null ) {

	}

	public function set_post_dislike( $post_id = null, $user_id = null ) {

	}

	public function remove_from_like( $post_id = null, $user_id = null ) {

	}

	public function get_likes_count( $post_id ) {

	}

	public function add_post_vote( $vote = 1, $post_id = null, $user_id = null ) {

	}

	public function get_votes_count( $post_id ) {

	}

	public function add_to_view( $post_id = null, $ip = null ) {

	}

	public function get_views_count( $post_id, $from_date = null, $to_date = null ) {

	}

}

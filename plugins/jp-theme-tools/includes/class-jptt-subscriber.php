<?php

/** Block direct access */
defined( 'ABSPATH' ) or die( 'No direct script access allowed' );

/**
 *
 * @since 1.0.0
 *
 */
class JPTT_Subscriber {

	/** Refers to a single instance of this class. */
	private static $instance = null;
	private static $table_exists = null;

	/**
	 * Creates or returns an instance of this class.
	 *
	 * @since 1.0.0
	 *
	 * @return JPTT_Subscriber A single instance of this class.
	 */
	public static function get_instance() {

		if ( self::$instance == null ) {
			self::$instance = new self;
		}

		if ( self::$table_exists == null ) {
			global $wpdb;
			self::$table_exists = (bool) $wpdb->get_row( "SHOW TABLES LIKE '{$wpdb->prefix}subscribers'" );
		}

		return self::$instance;
	}

	private function __construct() {

	}

	/**
	 * Creates subscriber table
	 *
	 * @since 1.0.0
	 *
	 * @global wpdb $wpdb
	 */
	public function create_table() {
		global $wpdb;
		$wpdb instanceof wpdb;
		$charset = $wpdb->charset ? "DEFAULT CHARACTER SET {$wpdb->charset}" : '';
		$collate = $wpdb->collate ? "COLLATE {$wpdb->collate}" : '';
		$query = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}subscribers` ("
						. "`subscriber_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT, "
						. "`subscriber_email` varchar(255) NULL, "
						. "`subscriber_field1` varchar(255) NULL, "
						. "`subscriber_field2` varchar(255) NULL, "
						. "`subscriber_field3` varchar(255) NULL, "
						. "`subscriber_field4` varchar(255) NULL, "
						. "`subscriber_timestamp` timestamp  NOT NULL DEFAULT CURRENT_TIMESTAMP, "
						. " PRIMARY KEY (`subscriber_id`) "
						. ") ENGINE=InnoDB {$charset} {$collate} AUTO_INCREMENT=1";
		$wpdb->query( $query );
	}

	/**
	 * The email exists in db?
	 *
	 * @since 1.0.0
	 *
	 * @global wpdb $wpdb
	 * @param string $email
	 * @return boolean
	 */
	public function email_exists( $email ) {
		if ( !is_email( $email ) ) {
			return false;
		}

		global $wpdb;
		$result = $wpdb->get_var( "SELECT count(subscriber_email) FROM {$wpdb->prefix}subscribers WHERE subscriber_email = '{$email}'" );

		return ($result > 0);
	}

	/**
	 * Add subscriber to db
	 *
	 * @since 1.0.0
	 *
	 * @param string $email
	 * @param string $field1 Optional. Field for custom values
	 * @param string $field2 Optional. Field for custom values
	 * @param string $field3 Optional. Field for custom values
	 * @param string $field4 Optional. Field for custom values
	 * @return boolean
	 */
	public function add_subscriber( $email, $field1 = null, $field2 = null, $field3 = null, $field4 = null ) {

		$subscriber_email = filter_var( trim( strtolower( $email ) ), FILTER_VALIDATE_EMAIL );

		if ( !$subscriber_email ) {
			return false;
		}
		$subscriber_field1 = filter_var( $field1, FILTER_SANITIZE_STRING );
		$subscriber_field2 = filter_var( $field2, FILTER_SANITIZE_STRING );
		$subscriber_field3 = filter_var( $field3, FILTER_SANITIZE_STRING );
		$subscriber_field4 = filter_var( $field4, FILTER_SANITIZE_STRING );
		$subscriber_source = filter_var( $source, FILTER_SANITIZE_STRING );

		$data = compact( 'subscriber_email', 'subscriber_field1', 'subscriber_field2', 'subscriber_field3', 'subscriber_field4' );

		if ( !$this->email_exists( $subscriber_email ) ) {
			$wpdb->insert( "{$wpdb->prefix}subscribers", $data );
		}

		return true;
	}

}

<?php

/** Block direct access */
defined( 'ABSPATH' ) or die( 'No direct script access allowed' );

/**
 *
 * @since 1.0.0
 *
 */
class JPTT {

	/** Refers to a single instance of this class. */
	private static $instance = null;

	/**
	 * Creates or returns an instance of this class.
	 * @return JPTT A single instance of this class.
	 */
	public static function get_instance() {

		if ( self::$instance == null ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	private function __construct() {

	}

	private $options;

	/**
	 * Wrapper that retrieve plugin option value based on name of option.
	 *
	 * @since 1.0.0
	 *
	 * @param string      $option   Name of option to retrieve. Expected to not be SQL-escaped.
	 * @param mixed       $value    Optional. Default value to return if the option does not exist.
	 * @return mixed Value set for the option.
	 */
	function get_option( $option, $default = false ) {
		$option = trim( $option );
		if ( empty( $option ) ) {
			return false;
		}

		if ( empty( $this->options ) ) {
			$this->options = get_option( 'jptt_options', array() );
		}

		$result = !empty( $this->options[$option] ) ? $this->options[$option] : $default;

		return $result;
	}

	/**
	 * Wrapper that update the value of an plugin option that was already added.
	 *
	 * If the option does not exist, then the option will be added with the option value
	 *
	 * @since 1.0.0
	 *
	 * @param string      $option   Option name. Expected to not be SQL-escaped.
	 * @param mixed       $value    Option value. Must be serializable if non-scalar. Expected to not be SQL-escaped.
	 * @return boolean
	 */
	function update_option( $option, $value ) {
		$option = trim( $option );
		if ( empty( $option ) ) {
			return false;
		}

		if ( empty( $this->options ) ) {
			$this->options = get_option( 'jptt_options', array() );
		}

		$this->options[$option] = $value;

		return update_option( 'jptt_options', $this->options );
	}

}

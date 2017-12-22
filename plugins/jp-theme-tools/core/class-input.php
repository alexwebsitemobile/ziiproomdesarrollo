<?php

namespace jptt\core;

defined( 'ABSPATH' ) or die( 'No direct script access allowed' );

/**
 * @since 0.9.0
 */
class Input {

	/**
	 * IP address of the current user
	 *
	 * @var	string
	 */
	protected $ip_address = FALSE;

	/**
	 *
	 * @var string
	 */
	public $request_method;

	/**
	 * Returns request method was used to access the page
	 * @return string
	 */
	public function get_method() {
		if ( empty( $this->request_method ) ) {
			return filter_var( $_SERVER['REQUEST_METHOD'] );
		} else {
			return $this->request_method;
		}
	}

	/**
	 * Set request method was used to access the page
	 * @param string $method
	 */
	public function set_method( $method = NULL ) {
		switch ( strtoupper( $method ) ) {
			case 'GET':
			case 'POST':
				$this->request_method = strtoupper( $method );
				break;
			default:
				$this->request_method = $this->get_method();
				break;
		}
	}

	private function _input( $field, $args = array() ) {
		$defaults = array(
				'filter' => FILTER_DEFAULT,
				'default' => FALSE,
				'method' => $this->get_method(),
				'options' => NULL
		);
		$options = wp_parse_args( $args, $defaults );

		switch ( strtoupper( $options['method'] ) ) {
			case 'GET':
				$type = INPUT_GET;
				break;

			case 'POST':
				$type = INPUT_POST;
				break;

			default:
				break;
		}

		$value = filter_input( $type, $field, $options['filter'], $options['options'] );
		return empty( $value ) ? $options['default'] : $value;
	}

	public function post( $field, $args = array() ) {
		$defaults = array(
				'filter' => FILTER_DEFAULT,
				'default' => false,
				'method' => 'POST',
				'options' => NULL
		);
		return $this->_input( $field, wp_parse_args( $args, $defaults ) );
	}

	public function get( $field, $args = array() ) {
		$defaults = array(
				'filter' => FILTER_DEFAULT,
				'default' => false,
				'method' => 'GET',
				'options' => NULL
		);
		return $this->_input( $field, wp_parse_args( $args, $defaults ) );
	}

	/**
	 * Get value of nonce field
	 * @param string $field
	 * @param string $method
	 * @return string
	 * @since 0.9.0
	 * @author jprieton
	 */
	public function get_wpnonce( $field = '_wpnonce', $method = 'POST' ) {

		$args = array(
				'filter' => FILTER_SANITIZE_STRIPPED,
				'default' => FALSE,
				'method' => $method,
				'options' => NULL
		);

		return $this->_input( $field, $args );
	}

	/**
	 * Wrapper to verify that correct nonce was used with time limit.
	 * @param string $action
	 * @param string $key
	 * @param string $method
	 * @return false|int
	 * @since 0.9.0
	 * @author jprieton
	 */
	public function verify_wpnonce( $action, $key = '_wpnonce', $method = 'POST' ) {
		$nonce = $this->get_wpnonce( $key, $method );
		return wp_verify_nonce( $nonce, $action );
	}

	/**
	 * Validate IP Address
	 *
	 * @param	string	$ip	IP address
	 * @param	string	$which	IP protocol: 'ipv4' or 'ipv6'
	 * @return	bool
	 * @since 0.12.2
	 * @author jprieton
	 */
	public function valid_ip( $ip, $which = '' ) {
		switch ( strtolower( $which ) ) {
			case 'ipv4':
				$which = FILTER_FLAG_IPV4;
				break;
			case 'ipv6':
				$which = FILTER_FLAG_IPV6;
				break;
			default:
				$which = NULL;
				break;
		}

		return (bool) filter_var( $ip, FILTER_VALIDATE_IP, $which );
	}

	/**
	 * Fetch the IP Address
	 *
	 * Determines and validates the visitor's IP address.
	 *
	 * @return	string	IP address
	 * @since 0.12.2
	 * @author jprieton
	 */
	public function ip_address() {
		if ( !empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
			$this->ip_address = $_SERVER['HTTP_CLIENT_IP'];
		} elseif ( !empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
			$this->ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$this->ip_address = $_SERVER['REMOTE_ADDR'];
		}

		if ( !$this->valid_ip( $this->ip_address ) ) {
			$this->ip_address = '0.0.0.0';
		} elseif ( $this->ip_address == '::1' ) {
			$this->ip_address = '127.0.0.1';
		}

		return $this->ip_address;
	}

}

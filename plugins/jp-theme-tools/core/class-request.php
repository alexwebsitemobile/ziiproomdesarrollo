<?php

namespace jptt\core;

defined( 'ABSPATH' ) or die( 'No direct script access allowed' );

/**
 * Class Request
 */
class Request {

	/**
	 * Get value of request
	 * @param string $field
	 * @param array $args
	 * @return string
	 * @since 0.12.2
	 * @author jprieton
	 */
	public function input( $field, $args = array() ) {
		$defaults = array(
				'filter' => FILTER_DEFAULT,
				'default' => FALSE,
				'method' => $this->method(),
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

	/**
	 * Get value of nonce field
	 * @param string $field
	 * @param array $args
	 * @return string
	 * @since 0.12.2
	 * @author jprieton
	 */
	public function wpnonce( $field = '_wpnonce', $args = array() ) {
		$defaults = array(
				'filter' => FILTER_SANITIZE_STRIPPED,
		);
		$options = wp_parse_args( $args, $defaults );

		$this->input( $field, $options );
	}

	/**
	 * Wrapper to verify that correct nonce was used with time limit.
	 * @param string $action
	 * @param string $key
	 * @param array $args
	 * @return false|int
	 * @since 0.12.2
	 * @author jprieton
	 */
	public function verify_wpnonce( $action, $key = '_wpnonce', $args = array() ) {
		$wpnonce = $this->wpnonce( $key, $args );
		return wp_verify_nonce( $wpnonce, $action );
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
	public function is_valid_ip( $ip, $which = '' ) {
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
	public function ip() {

		$http_client_ip = filter_input( INPUT_SERVER, 'HTTP_CLIENT_IP' );
		$http_x_fowarded_for = filter_input( INPUT_SERVER, 'HTTP_X_FORWARDED_FOR' );
		$remote_addr = filter_input( INPUT_SERVER, 'REMOTE_ADDR' );

		if ( !empty( $http_client_ip ) ) {
			$ip_address = $http_client_ip;
		} elseif ( !empty( $http_x_fowarded_for ) ) {
			$ip_address = $http_x_fowarded_for;
		} else {
			$ip_address = $remote_addr;
		}

		if ( !$this->valid_ip( $ip_address ) ) {
			$ip_address = '0.0.0.0';
		} elseif ( $ip_address == '::1' ) {
			$ip_address = '127.0.0.1';
		}

		return $ip_address;
	}

	/**
	 * Returns request method was used to access the page
	 * @return string
	 */
	public function method() {
		return filter_input( INPUT_SERVER, 'REQUEST_METHOD' );
	}

}

/**
 * @global Request $request
 */
global $request;
$request = new \jptt\core\Request();

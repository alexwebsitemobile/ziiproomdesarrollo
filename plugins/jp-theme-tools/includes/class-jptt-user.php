<?php

/** Block direct access */
defined( 'ABSPATH' ) or die( 'No direct script access allowed' );

/**
 *
 * @since 1.0.0
 *
 */
class JPTT_User {

	/** Refers to a single instance of this class. */
	private static $instance = null;

	/**
	 * Creates or returns an instance of this class.
	 *
	 * @since 1.0.0
	 *
	 * @return JPTT_User A single instance of this class.
	 */
	public static function get_instance() {

		if ( self::$instance == null ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	private function __construct() {

	}

	/**
	 * Insert a user into the database with minimun fields.
	 *
	 * @since 1.0.0
	 *
	 * @param string $user_email
	 * @param string $user_pass
	 * @return int|WP_Error The newly created user's ID or a WP_Error object if the user could not be created.
	 */
	public function user_register( $user_email, $user_pass ) {

		$user_email = strtolower( trim( $user_email ) );

		$user_login = $user_email = trim( $user_email );

		if ( !filter_var( $user_email, FILTER_VALIDATE_EMAIL ) ) {
			return new WP_Error( 'invalid_email', __( 'Invalid email' ) );
		}

		if ( empty( $user_email ) || empty( $user_pass ) ) {
			return new WP_Error( 'invalid_data', __( 'Empty request' ) );
		}

		$userdata = compact( 'user_login', 'user_email', 'user_pass' );
		$userdata = apply_filters( 'jptt_user_register', $userdata );

		if ( is_wp_error( $userdata ) ) {
			return $userdata;
		}

		$user_id = wp_insert_user( $userdata );

		return $user_id;
	}

	/**
	 *
	 * @param string $user_email
	 * @param string $user_pass
	 * @param bool $remember
	 * @return WP_User|WP_Error WP_User on success, WP_Error on failure.
	 */
	public function user_login( $user_login, $user_password, $remember = null ) {

		$user_login = strtolower( trim( $user_login ) );

		$credentials = compact( 'user_login', 'user_password', 'remember' );
		$user = wp_signon( $credentials, false );

		return $user;
	}

}

add_action( 'wp_ajax_nopriv_jptt_user_register', function() {
	$nonce = filter_input( INPUT_POST, '_wpnonce', FILTER_SANITIZE_STRING );
	$verify_nonce = (bool) wp_verify_nonce( $nonce, 'jptt_user_register' );

	if ( !$verify_nonce ) {
		$error = new WP_Error( 'action_disabled', __( 'Action disabled' ) );
		wp_send_json_error( $error );
	}

	$user_email = trim( filter_input( INPUT_POST, 'user_email', FILTER_SANITIZE_EMAIL ) );
	$user_pass = filter_input( INPUT_POST, 'user_password', FILTER_SANITIZE_STRING );

	$c_pass = filter_input( INPUT_POST, 'c_user_password' );
	if ( $user_pass != $c_pass ) {
		$error = new WP_Error( 'password_error', __( "Passwords don't match" ) );
		wp_send_json_error( $error );
	}

	do_action( 'pre_jptt_user_register', $user_email, $user_pass );

	$user = JPTT_User::get_instance();
	$user_id = $user->user_register( $user_email, $user_pass );

	do_action( 'post_jptt_user_register', $user_id );

	if ( is_wp_error( $user_id ) ) {
		wp_send_json_error( $user_id );
	} else {
		add_user_meta( $user_id, 'show_admin_bar_front', 'false' );
		$response = array(
				'code' => 'register_success',
				'message' => __( 'Register success' ),
		);
		wp_send_json_success( $response );
	}
} );

add_action( 'wp_ajax_nopriv_jptt_user_login', function() {
	$nonce = filter_input( INPUT_POST, '_wpnonce', FILTER_SANITIZE_STRING );
	$verify_nonce = (bool) wp_verify_nonce( $nonce, 'jptt_user_login' );

	if ( !$verify_nonce ) {
		$error = new WP_Error( 'action_disabled', __( 'Action disabled' ) );
		wp_send_json_error( $error );
	}

	$user_email = filter_input( INPUT_POST, 'user_email', FILTER_SANITIZE_EMAIL );
	$user_pass = filter_input( INPUT_POST, 'user_password', FILTER_SANITIZE_STRING );
	$remember = filter_input( INPUT_POST, 'user_password', FILTER_SANITIZE_STRING );

	do_action( 'pre_jptt_user_login', $user_email, $user_pass );

	$user = JPTT_User::get_instance();
	$userdata = $user->user_login( $user_email, $user_pass, (bool) $remember );

	do_action( 'post_jptt_user_login', $userdata );

	if ( is_wp_error( $userdata ) ) {
		wp_send_json_error( $userdata );
	} else {
		$response = array(
				'code' => 'login_success',
				'message' => __( 'Login success' ),
		);
		wp_send_json_success( $response );
	}
} );

<?php

defined('ABSPATH') or die('No direct script access allowed');

require_once JPTT_BASEPATH . 'core/class-input.php';
require_once JPTT_BASEPATH . 'core/class-user.php';
require_once JPTT_BASEPATH . 'core/class-error.php';

add_action('wp_ajax_nopriv_user_login', function () {

	$Input = new \jptt\core\Input();
	$Error = new \jptt\core\Error();

	$verify_nonce = (bool) $Input->verify_wpnonce('user_login');

	if (!$verify_nonce) {
		$Error->method_not_supported(__FUNCTION__);
		wp_send_json_error($Error);
	}

	$submit = array(
			'user_login'    => $Input->post('user_login'),
			'user_password' => $Input->post('user_password'),
			'remember'      => $Input->post('remember')
	);

	$User = new \jptt\core\Users();

	$response = $User->user_login($submit);

	if (is_wp_error($response)) {
		wp_send_json_error($response);
	} else {
		wp_send_json_success($response);
	}
}, 10);

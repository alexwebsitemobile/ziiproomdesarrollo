<?php

defined('ABSPATH') or die('No direct script access allowed');

require_once JPTT_BASEPATH . 'core/class-input.php';
require_once JPTT_BASEPATH . 'core/class-error.php';
require_once __DIR__ . '/class-user-subscribe.php';

add_action('wp_ajax_nopriv_add_subscriber', function() {

	$Input = new \jptt\core\Input();

	$verify_wpnonce = (bool) $Input->verify_wpnonce('add_subscriber');

	$Error = new \jptt\core\Error();

	if (!$verify_wpnonce) {
		$Error->method_not_supported(__FUNCTION__);
		wp_send_json_error($Error);
	}

	$args = array(
			'filter' => FILTER_SANITIZE_STRING
	);

	$subscriber_email = $Input->post('subscriber_email', $args);
	$subscriber_name = $Input->post('subscriber_email', $args);

	$User_subscribe = new \jptt\modules\User_subscribe();
	$result = $User_subscribe->add_subscriber($subscriber_email, $subscriber_name);

	if (is_wp_error($result)) {
		wp_send_json_error($result);
	} else {
		wp_send_json_success();
	}
});

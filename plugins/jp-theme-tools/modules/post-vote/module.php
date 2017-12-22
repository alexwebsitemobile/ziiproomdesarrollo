<?php

defined('ABSPATH') or die('No direct script access allowed');

require_once __DIR__ . '/class-post-vote.php';
require_once JPTT_BASEPATH . 'core/class-input.php';

add_action('wp_ajax_post_vote', function() {

	$Input = new \jptt\core\Input();
	$post_id = (int) $Input->get('post_id', array('filter' => FILTER_SANITIZE_NUMBER_INT));
	$value = (int) $Input->get('value', array('filter' => FILTER_SANITIZE_NUMBER_INT));

	if ($post_id == 0) {
		wp_send_json_error();
	}

	$Post_vote = new jptt\modules\Post_vote();

	$Post_vote->add_post_vote($post_id, $value);
	wp_send_json_success();
});

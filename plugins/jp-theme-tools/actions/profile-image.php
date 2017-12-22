<?php

defined('ABSPATH') or die("No script kiddies please!");

/**
 * Deletes image of current user
 */
add_action('wp_ajax_delete_profile_image', function() {
	$nonce = get_nonce_value();
	$verify_nonce = wp_verify_nonce($nonce, 'delete_profile_image');

	($verify_nonce || is_user_logged_in() || die(0));

	delete_profile_image(get_current_user_id());
	die(1);
});

/**
 * Add a profile image
 */
add_action('wp_ajax_update_profile_image', function() {
	$nonce = get_nonce_value();
	$verify_nonce = wp_verify_nonce($nonce, 'update_profile_image');

	($verify_nonce || is_user_logged_in() || die(0));

	$overrides = array(
			'test_form' => false,
			'mimes' => array('jpg' => 'image/jpg', 'jpeg' => 'image/jpeg', 'gif' => 'image/gif', 'png' => 'image/png')
	);
	$image_data = wp_handle_upload($_FILES['profile_image'], $overrides);

	$upload_dir = wp_upload_dir();

	$profile_dir = $upload_dir['basedir'] . '/profile-images';

	(isset($image_data['file']) || die(0));

	wp_mkdir_p($profile_dir);

	$ext = '.' . str_replace('image/', '', $image_data['type']);

	$filename = md5(date('Ymdhijs')) . $ext;

	while (file_exists($profile_dir . '/' . $filename)) {
		$filename = md5(date('Ymdhijs')) . $ext;
	}
	rename($image_data['file'], $profile_dir . '/' . $filename);
	add_profile_image(get_current_user_id(), $filename);
	die('1');
});

/**
 * Deletes image profile on delete user
 */
add_action('delete_user', function ($user_id) {
//	delete_profile_image((int) $user_id);
}, 1);

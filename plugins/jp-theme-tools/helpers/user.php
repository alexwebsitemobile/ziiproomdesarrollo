<?php

defined('ABSPATH') or die("No script kiddies please!");

/**
 * 
 * @param int $user_id
 * @param int $attachment_id
 */
function add_profile_attachment($user_id, $attachment_id) {
	$user = get_user_by('id', $user_id);
	if (is_a($user, 'WP_User')) {
		update_user_meta($user_id, 'profile_attachment', $attachment_id);
	}
}

/**
 * 
 * @param int $user_id
 */
function delete_profile_attachment($user_id) {
	$user = get_user_by('id', $user_id);
	if (is_a($user, 'WP_User')) {
		delete_user_meta($user_id, 'profile_attachment');
	}
}

/**
 * 
 * @param int $user_id
 * @param string $filename
 */
function add_profile_image($user_id, $filename) {
	$user = get_user_by('id', $user_id);

	if (is_a($user, 'WP_User')) {
		$upload_dir = wp_upload_dir();
		delete_profile_image($user_id);
		update_user_meta($user_id, 'profile_image_path', $upload_dir['basedir'] . '/profile-images/' . $filename);
		update_user_meta($user_id, 'profile_image_url', $upload_dir['baseurl'] . '/profile-images/' . $filename);
	}
}

/**
 * 
 * @param int $user_id
 */
function delete_profile_image($user_id) {
	$user = get_user_by('id', $user_id);
	if (is_a($user, 'WP_User')) {
		$old_image_path = get_user_meta($user_id, 'profile_image_path', true);
		if (!empty($old_image_path)) {
			unlink($old_image_path);
		}
		delete_user_meta($user_id, 'profile_image_path');
		delete_user_meta($user_id, 'profile_image_url');
	}
}

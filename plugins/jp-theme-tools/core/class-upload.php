<?php

namespace jptt\core;

defined('ABSPATH') or die('No direct script access allowed');

class Upload {

	/**
	 * Handle upload images
	 * @param string $field
	 * @return int|\WP_Error
	 */
	public function handle_upload_images($field = 'file') {
		$overrides = array(
				'test_form' => false,
				'mimes' => array(
						'jpg'  => 'image/jpg',
						'jpeg' => 'image/jpeg',
						'gif'  => 'image/gif',
						'png'  => 'image/png'
		));

		$image_data = wp_handle_upload($_FILES[$field], $overrides);

		if (isset($image_data['error']) || isset($image_data['upload_error_handler'])) {
			return new \jptt\core\Error('upload_error', $image_data['error']);
		}

		$post_title = preg_replace('/\.[^.]+$/', '', basename($image_data['file']));

		$pub_id = 1;
		$__type = explode('/', $image_data['type']);
		$_new_filename = 'pub' . $pub_id . '-' . substr(md5(date('dmYhis')), 0, 12) . '.' . end($__type);
		$__url = explode('/', $image_data['url']);
		$_old_filename = end($__url);

		rename($image_data['file'], str_replace($_old_filename, $_new_filename, $image_data['file']));
		$image_data['url'] = str_replace($_old_filename, $_new_filename, $image_data['url']);
		$image_data['file'] = str_replace($_old_filename, $_new_filename, $image_data['file']);

		$attachment = array(
				'post_mime_type' => $image_data['type'],
				'post_title'     => $post_title,
				'post_content'   => '',
				'post_status'    => 'inherit',
				'guid'           => $image_data['url']
		);

		if (!function_exists('wp_generate_attachment_metadata')) {
			require_once(ABSPATH . "wp-admin" . '/_includes/image.php');
			require_once(ABSPATH . "wp-admin" . '/_includes/file.php');
			require_once(ABSPATH . "wp-admin" . '/_includes/media.php');
		}
		$wp_upload_dir = wp_upload_dir();
		$filename = str_replace($wp_upload_dir['baseurl'] . '/', '', $image_data['url']);

		$attachment_id = wp_insert_attachment($attachment, $filename);
		$attach_data = wp_generate_attachment_metadata($attachment_id, $image_data['file']);
		wp_update_attachment_metadata($attachment_id, $attach_data);

		return $attachment_id;
	}

}

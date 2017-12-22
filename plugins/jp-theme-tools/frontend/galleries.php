<?php

defined('ABSPATH') or die('No direct script access allowed');

/**
 * @since v0.9.0
 * @author jprieton
 */
class Frontend_Galleries {

	public function __construct() {
		$this->error = new \jptt\core\Error();
	}

	/**
	 * @since v0.9.0
	 * @author jprieton
	 * @param int $post_id
	 * @return (array)
	 */
	public function get_gallery_meta($post_id = 0) {
		if ((int) $post_id == 0) {
			$post_id = get_the_ID();
		}
		return (array) get_post_meta((int) $post_id, 'post_gallery');
	}

	/**
	 *
	 * @since v0.9.0
	 * @author jprieton
	 * @param int $post_id
	 * @param array|string $args
	 * @return boolean|string
	 */
	public function get_gallery_meta_shorcode($post_id = 0, $args = NULL) {
		$gallery_meta = $this->get_gallery_meta($post_id);
		if (!empty($gallery_meta)) {
			return sprintf('[gallery ids="%s"]', implode(',', $gallery_meta));
		} else {
			return FALSE;
		}
	}

}

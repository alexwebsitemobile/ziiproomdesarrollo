<?php

/**
 * Extends WordPress Post Thumbnail Template Functions.
 *
 * Support for post thumbnails.
 * Theme's functions.php must call add_theme_support( 'post-thumbnails' ) to use these.
 *
 * @package WordPress
 * @subpackage Template
 */

/**
 * Retrieve Post Thumbnail src.
 *
 * @since 0.10.0
 *
 * @param int          $post_id       Optional. Post ID.
 * @param string|array $size          Optional. Registered image size to retrieve the source for or a flat
 *                                    array of height and width dimensions. Default 'thumbnail'.
 * @return bool|string
 */
function get_post_thumbnail_src($post_id = null, $size = 'thumbnail') {
	$post_id = ( null === $post_id ) ? get_the_ID() : $post_id;
	$attachment_id = get_post_meta($post_id, '_thumbnail_id', true);
	$thumb_url = wp_get_attachment_image_src($attachment_id, $size, true);
	return is_array($thumb_url) ? current($thumb_url) : (bool) $thumb_url;
}

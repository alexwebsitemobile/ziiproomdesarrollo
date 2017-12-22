<?php

/**
 * Extends WordPress Link Template Functions
 *
 * @package WordPress
 * @subpackage Template
 */

/**
 * Retrieve shortened google permalink for current post or post ID.
 *
 * @since 0.10.0
 *
 * @param int|WP_Post $id        Optional. Post ID or post object. Default current post.
 * @return string|bool The permalink URL or false if post does not exist.
 */
function get_google_short_permalink($post_id = null) {
	$post_id = ( null === $post_id ) ? get_the_ID() : $post_id;

	$short_permalink = get_post_meta($post_id, 'google_short_permalink', true);

	if (!$short_permalink) {
		$permalink = get_permalink($post_id);
		$short_permalink = generate_google_short_permalink($permalink);
		if (!empty($short_permalink)) {
			update_post_meta($post_id, 'google_short_permalink', $short_permalink);
		}
	}
}

/**
 * Retrieve shortened permalink from Google URL Shortener API.
 *
 * @since 0.7.0
 *
 * @see https://developers.google.com/url-shortener/
 *
 * @param string $permalink        Permalink URL.
 * @return string The shortened Google permalink URL.
 */
function generate_google_short_permalink($permalink = '') {

	if (empty($permalink)) return FALSE;

	$apiKey = get_option('google-url-shortener-api-key', '');

	$postData = array('longUrl' => $permalink, 'key' => $apiKey);
	$jsonData = json_encode($postData);

	$curlObj = curl_init();

	curl_setopt($curlObj, CURLOPT_URL, 'https://www.googleapis.com/urlshortener/v1/url');
	curl_setopt($curlObj, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curlObj, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($curlObj, CURLOPT_HEADER, 0);
	curl_setopt($curlObj, CURLOPT_HTTPHEADER, array('Content-type:application/json'));
	curl_setopt($curlObj, CURLOPT_POST, 1);
	curl_setopt($curlObj, CURLOPT_POSTFIELDS, $jsonData);

	$response = curl_exec($curlObj);

	// Change the response json string to object
	$json = json_decode($response);

	curl_close($curlObj);

	return $json->id;
}

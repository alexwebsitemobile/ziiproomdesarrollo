<?php

defined('ABSPATH') or die('No direct script access allowed');

global $wpdb;
$wpdb instanceof wpdb;
$wpdb->termmeta = "{$wpdb->prefix}termmeta";

if (!function_exists('add_term_meta')) {

	/**
	 * Add metadata for the specified object.
	 *
	 * @since 0.9.1
	 *
	 * @param int $term_id ID of the object metadata is for
	 * @param string $meta_key Metadata key
	 * @param mixed $meta_value Metadata value. Must be serializable if non-scalar.
	 * @param bool $unique Optional, default is false. Whether the specified metadata key should be
	 * 		unique for the object. If true, and the object already has a value for the specified
	 * 		metadata key, no change will be made
	 * @return int|bool The meta ID on success, false on failure.
	 */
	function add_term_meta($term_id, $meta_key, $meta_value, $unique = FALSE) {
		return add_metadata('term', $term_id, $meta_key, $meta_value, $unique);
	}

}

if (!function_exists('get_term_meta')) {

	/**
	 * Retrieve metadata for the specified object.
	 *
	 * @since 0.9.1
	 *
	 * @param int $term_id ID of the object metadata is for
	 * @param string $meta_key Metadata key
	 * @param string $meta_key Optional. Metadata key. If not specified, retrieve all metadata for
	 * 		the specified object.
	 * @param bool $single Optional, default is false. If true, return only the first value of the
	 * 		specified meta_key. This parameter has no effect if meta_key is not specified.
	 * @return mixed Single metadata value, or array of values
	 */
	function get_term_meta($term_id, $meta_key = '', $single = FALSE) {
		return get_metadata('term', $term_id, $meta_key, $single);
	}

}

if (!function_exists('delete_term_meta')) {

	/**
	 * Delete metadata for the specified object.
	 *
	 * @since 0.9.1
	 *
	 * @param int $term_id ID of the object metadata is for
	 * @param string $meta_key Metadata key
	 * @param mixed $meta_value Optional. Metadata value. Must be serializable if non-scalar. If specified, only delete metadata entries
	 * 		with this value. Otherwise, delete all entries with the specified meta_key.
	 * @param bool $delete_all Optional, default is false. If true, delete matching metadata entries
	 * 		for all objects, ignoring the specified object_id. Otherwise, only delete matching
	 * 		metadata entries for the specified object_id.
	 * @return bool True on successful delete, false on failure.
	 */
	function delete_term_meta($term_id, $meta_key, $meta_value = '', $delete_all = FALSE) {
		return delete_metadata('term', $term_id, $meta_key, $meta_value, $delete_all);
	}

}

if (!function_exists('update_term_meta')) {

	/**
	 * Update metadata for the specified object. If no value already exists for the specified object
	 * ID and metadata key, the metadata will be added.
	 *
	 * @since 0.9.1
	 *
	 * @param int $term_id ID of the object metadata is for
	 * @param string $meta_key Metadata key
	 * @param mixed $meta_value Metadata value. Must be serializable if non-scalar.
	 * @param mixed $prev_value Optional. If specified, only update existing metadata entries with
	 * 		the specified value. Otherwise, update all entries.
	 * @return int|bool Meta ID if the key didn't exist, true on successful update, false on failure.
	 */
	function update_term_meta($term_id, $meta_key, $meta_value, $prev_value = '') {
		return update_metadata('term', $term_id, $meta_key, $meta_value, $prev_value);
	}

}


if (!function_exists('has_term_thumbnail')) {

	/**
	 * Check if term has an image attached.
	 *
	 * @since 0.9.3
	 *
	 * @param int $term_id Optional. Post ID.
	 * @return bool Whether term has an image attached.
	 */
	function has_term_thumbnail($term_id) {
		return (bool) get_term_thumbnail_id((int) $term_id);
	}

}

if (!function_exists('get_term_thumbnail_id')) {

	/**
	 * Retrieve Term Thumbnail ID.
	 *
	 * @since 0.9.3
	 *
	 * @param int $term_id Optional. Term ID.
	 * @return int
	 */
	function get_term_thumbnail_id($term_id) {
		return get_term_meta((int) $term_id, '_thumbnail_id', true);
	}

}
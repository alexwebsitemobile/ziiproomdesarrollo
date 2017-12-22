<?php

/** Block direct access */
defined( 'ABSPATH' ) or die( 'No direct script access allowed' );

if ( !function_exists( 'is_featured' ) ) {

	/**
	 * Is featured post?
	 *
	 * @since 1.0.0
	 *
	 * @param int|WP_Post $post Optional. Post ID or WP_Post object. Default is global `$post`.
	 *
	 * @return boolean
	 */
	function is_featured( $post = null ) {
		$post = get_post( $post );
		if ( !$post ) {
			return false;
		}

		$featured = get_post_meta( $post->ID, '_featured', true );
		// 'yes' for WooCommerce support, '1' for legacy support
		return ( 'yes' == $featured || '1' == $featured);
	}

}

$featured_enabled = (bool) jptt_get_option( 'module_featured' );

/** If module is disabled or isn't admin area disable filter & actions */
if ( !$featured_enabled || !is_admin() ) {
	return;
}

/**
 * Add featured column to admin posts
 *
 * @since 1.0.0
 */
add_filter( 'manage_posts_columns', function( $posts_columns, $post_type = null) {

	$post_types_disabled = array();
	$post_types_disabled = (array) apply_filters( 'jptt_featured_post_types_disabled', $post_types_disabled, $post_type );

	if ( in_array( $post_type, $post_types_disabled ) ) {
		return $posts_columns;
	}

	$new = array(
			'cb' => $posts_columns['cb'],
			'featured' => '<span class="dashicons dashicons-star-filled" title="' . __( 'Featured', JPTT_TEXTDOMAIN ) . '"><span class="screen-reader-text">' . __( 'Featured', JPTT_TEXTDOMAIN ) . '</span></span>'
	);

	$posts_columns = array_merge( $new, $posts_columns );
	return $posts_columns;
}, 10, 2 );

/**
 * Add featured column to admin pages
 *
 * @since 1.0.0
 */
add_filter( 'manage_pages_columns', function( $posts_columns, $post_type = null) {

	$post_types_disabled = array();
	$post_types_disabled = (array) apply_filters( 'jptt_featured_post_types_disabled', $post_types_disabled, $post_type );

	if ( in_array( $post_type, $post_types_disabled ) ) {
		return $posts_columns;
	}

	$new = array(
			'cb' => $posts_columns['cb'],
			'featured' => '<span class="dashicons dashicons-star-filled" title="' . __( 'Featured', JPTT_TEXTDOMAIN ) . '"><span class="screen-reader-text">' . __( 'Featured', JPTT_TEXTDOMAIN ) . '</span></span>'
	);

	$posts_columns = array_merge( $new, $posts_columns );
	return $posts_columns;
}, 10, 2 );

/**
 * Show featured value to admin posts
 *
 * @since 1.0.0
 */
add_action( 'manage_posts_custom_column', function($column_name, $post_id) {
	if ( 'featured' != $column_name ) {
		return;
	}

	$post_types_disabled = array();
	$post_types_disabled = (array) apply_filters( 'jptt_featured_post_types_disabled', $post_types_disabled, null );

	if ( !empty( $post_types_disabled ) && in_array( get_post_type( $post_id ), $post_types_disabled ) ) {
		return;
	}

	$featured = get_post_meta( $post_id, '_featured', true );
	if ( in_array( $featured, array( 'yes', 1 ) ) ) {
		echo '<a href="#" class="dashicons dashicons-star-filled jptt-toggle-featured" data-id="' . $post_id . '"></a>';
	} else {
		echo '<a href="#" class="dashicons dashicons-star-empty jptt-toggle-featured" data-id="' . $post_id . '"></a>';
	}
}, 10, 2 );

/**
 * Show featured value to admin pages
 *
 * @since 1.0.0
 */
add_action( 'manage_pages_custom_column', function($column_name, $post_id) {
	if ( 'featured' != $column_name ) {
		return;
	}

	$post_types_disabled = array();
	$post_types_disabled = (array) apply_filters( 'jptt_featured_post_types_disabled', $post_types_disabled, null );

	if ( !empty( $post_types_disabled ) && in_array( get_post_type( $post_id ), $post_types_disabled ) ) {
		return;
	}

	$featured = get_post_meta( $post_id, '_featured', true );
	if ( in_array( $featured, array( 'yes', 1 ) ) ) {
		echo '<a href="#" class="dashicons dashicons-star-filled jptt-toggle-featured" data-id="' . $post_id . '"></a>';
	} else {
		echo '<a href="#" class="dashicons dashicons-star-empty jptt-toggle-featured" data-id="' . $post_id . '"></a>';
	}
}, 10, 2 );

/**
 * Remove custom featured column in products when WooCommerce exists
 *
 * @since 1.0.0
 */
add_filter( 'jptt_featured_post_types_disabled', function ($post_types_disabled, $post_type) {
	if ( function_exists( 'WC' ) ) {
		$post_types_disabled[] = 'product';
	}
	return $post_types_disabled;
}, 10, 2 );

/**
 * Action to toggle featured post/page in admin
 *
 * @since 1.0.0
 */
add_action( 'wp_ajax_toggle_featured_post', function() {
	if ( !is_admin() ) {
		$error = new WP_Error( 'action_disabled', __( 'Action disabled' ) );
		wp_send_json_error( $error );
	}

	$post_id = (int) (filter_input( INPUT_POST, 'post_id', FILTER_SANITIZE_NUMBER_INT ) ? : filter_input( INPUT_GET, 'post_id', FILTER_SANITIZE_NUMBER_INT ));

	if ( empty( $post ) ) {
		$error = new WP_Error( 'action_disabled', __( 'Action disabled' ) );
		wp_send_json_error( $error );
	}

	$post = get_post( $post_id );

	if ( empty( $post ) ) {
		$error = new WP_Error( 'action_disabled', __( 'Action disabled' ) );
		wp_send_json_error( $error );
	}

	$featured = get_post_meta( $post_id, '_featured', true );

	// 'yes' for WooCommerce support, '1' for legacy support
	if ( 'yes' == $featured || '1' == $featured ) {
		delete_post_meta( $post_id, '_featured' );
		wp_send_json( array( 'success' => true, 'featured' => false ) );
	} else {
		update_post_meta( $post_id, '_featured', 'yes' );
		wp_send_json( array( 'success' => true, 'featured' => true ) );
	}
} );

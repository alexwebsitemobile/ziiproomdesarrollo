<?php

defined( 'ABSPATH' ) or die( 'No direct script access allowed' );

/**
 * Add <code>defer</code> attribute to enqueued script.
 *
 * @since 0.15.0
 *
 * @param string $handle Name of the script.
 */
function wp_defer_script( $handle ) {
	$wp_scripts = wp_scripts();
	_wp_scripts_maybe_doing_it_wrong( __FUNCTION__ );

	$wp_scripts->defer[] = (string) $handle;
}

/**
 * Add <code>async</code> attribute to enqueued script.
 *
 * @since 0.15.0
 *
 * @param string $handle Name of the script.
 */
function wp_async_script( $handle ) {
	$wp_scripts = wp_scripts();
	_wp_scripts_maybe_doing_it_wrong( __FUNCTION__ );

	$wp_scripts->async[] = (string) $handle;
}

add_filter( 'script_loader_tag', function ( $tag, $handle ) {
	$wp_scripts = wp_scripts();

	/** async */
	if ( isset( $wp_scripts->async ) && in_array( $handle, (array) $wp_scripts->async ) ) {
		$tag = str_replace( '<script ', '<script async ', $tag );
	}

	/** defer */
	if ( isset( $wp_scripts->defer ) && in_array( $handle, (array) $wp_scripts->defer ) ) {
		$tag = str_replace( '<script ', '<script defer ', $tag );
	}
	return $tag;
}, 10, 2 );

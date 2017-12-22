<?php

/** Filter to merge current options with new values */
add_filter( 'pre_update_option_jptt_options', function($value, $old_value, $option) {
	$jptt_option = get_option( $option, array() );

	if ( !empty( $value['module_favorites'] ) && (bool) $value['module_favorites'] ) {
		$favorite = JPTT_Favorite::get_instance();
		$favorite->create_table();
	}

	if ( !empty( $value['module_subscribers'] ) && (bool) $value['module_subscribers'] ) {
		$subscriber = JPTT_Subscriber::get_instance();
		$subscriber->create_table();
	}

	require_once realpath( JPTT_BASEPATH . '/includes/class-jptt-security.php' );
	$security = JPTT_Security::get_instance();

	$direct_execution_plugin = empty( $value['disable_direct_execution_plugins'] ) ? false : (bool) $value['disable_direct_execution_plugins'];
	if ( $direct_execution_plugin ) {
		$security->write_htaccess( 'plugins' );
	} else {
		$security->remove_htaccess( 'plugins' );
	}

	$direct_execution_plugin = empty( $value['disable_direct_execution_themes'] ) ? false : (bool) $value['disable_direct_execution_themes'];
	if ( $direct_execution_plugin ) {
		$security->write_htaccess( 'themes' );
	} else {
		$security->remove_htaccess( 'themes' );
	}

	$direct_execution_plugin = empty( $value['disable_direct_execution_uploads'] ) ? false : (bool) $value['disable_direct_execution_uploads'];
	if ( $direct_execution_plugin ) {
		$security->write_htaccess( 'uploads' );
	} else {
		$security->remove_htaccess( 'uploads' );
	}

	return array_merge( $jptt_option, $value );
}, 10, 3 );


if ( ((bool) jptt_get_option( 'xmlrpc_pingback_disabled' ) || (bool) jptt_get_option( 'xmlrpc_all_disabled' )) && !is_admin() ) {
	/** 	Disable XML-RCP pingback methods */
	add_filter( 'xmlrpc_methods', function ( $methods ) {
		unset( $methods['pingback.ping'] );
		unset( $methods['pingback.extensions.getPingbacks'] );
		return $methods;
	} );

	/** Remove Pingback header */
	add_filter( 'wp_headers', function ( $headers ) {
		unset( $headers['X-Pingback'] );
		return $headers;
	} );
}

if ( (bool) jptt_get_option( 'xmlrpc_all_disabled' ) && !is_admin() ) {
	/** Disable XML-RCP */
	add_filter( 'xmlrpc_enabled', '__return_false' );

	/** Disable all XML-RCP methods */
	add_filter( 'xmlrpc_methods', function ( $methods ) {
		return array();
	} );
}

if ( (bool) jptt_get_option( 'remove_version' ) ) {
	/** Remove WordPress version number from head */
	remove_action( 'wp_head', 'wp_generator' );
	/** Remove WordPress version number from feed */
	add_filter( 'the_generator', '__return_empty_string' );
}

if ( (bool) jptt_get_option( 'remove_rsd_link' ) || (bool) jptt_get_option( 'xmlrpc_all_disabled' ) ) {
	/** Remove the EditURI/RSD link from head */
	remove_action( 'wp_head', 'rsd_link' );
	/** Remove the Windows Live Writer manifest link from head */
	remove_action( 'wp_head', 'wlwmanifest_link' );
}

if ( (bool) jptt_get_option( 'theming_helper' ) ) {
	/** Shows a box with info about current Bootstrap breakpoint, resolution and modernizr features. */
	add_action( 'wp_footer', function() {
		include_once realpath( JPTT_BASEPATH . '/templates/responsive-helper.php' );
	}, 99 );
}

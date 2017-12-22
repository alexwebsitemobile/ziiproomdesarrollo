<?php

function get_theme_settings() {
	static $theme_settings;

	$args = func_get_args();

	if ( empty( $theme_settings ) ) {
		$theme_settings = get_option( 'jp-basic-settings' );
	}

	if (empty($args)) {
		return $theme_settings;
	}

	$response = $theme_settings;
	foreach ( $args as $arg ) {
		if ( isset( $response[$arg] ) ) {
			$response = $response[$arg];
		} else {
			return false;
		}
	}

	return $response;
}

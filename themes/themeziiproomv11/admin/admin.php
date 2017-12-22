<?php

if ( !is_admin() ) {
	return;
}

add_action( 'admin_menu', function () {
	add_theme_page( 'Theme Settings', 'Theme Settings', 'edit_theme_options', 'jp-basic-settings', function () {
		include_once __DIR__ . '/settings.php';
	} );
} );

add_action( 'admin_init', function() {
	register_setting( 'jp-basic-settings', 'jp-basic-settings' );
} );

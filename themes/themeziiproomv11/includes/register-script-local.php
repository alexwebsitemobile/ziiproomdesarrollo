<?php

// Register Script
add_action( 'wp_enqueue_scripts', function () {
	/* jQuery v2.1.4 */
	wp_deregister_script( 'jquery' );
	wp_register_script( 'jquery', THEME_URI . '/js/jquery.min.js', array(), '2.1.4', false );
	/* Modernizr v2.8.3 */
	wp_register_script( 'modernizr', THEME_URI . '/js/modernizr.min.js', array(), '2.8.3', false );
	/* Bootstrap v3.3.5 */
	wp_register_script( 'bootstrap', THEME_URI . '/js/bootstrap.min.js', array( 'jquery' ), '3.3.5', false );
	/* WOW.js v1.1.2 */
	wp_register_script( 'wow', THEME_URI . '/js/wow.min.js', array(), '1.1.2', true );
} );

<?php

// Register Script
add_action( 'wp_enqueue_scripts', function () {
	/* Hover.css v2.0.2	 */
	wp_register_style( 'hover',  THEME_URI . '/css/hover-min.css', array(), '2.0.2', 'screen' );
	/* Animate.css v2.0.2	 */
	wp_register_style( 'animate',  THEME_URI . '/css/animate.min.css', array(), '3.3.0', 'screen' );
	/* Bootstrap v3.3.5 */
	wp_register_style( 'bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css', array(), '3.3.5' );
	/* Font Awesome v4.4.0 */
	wp_register_style( 'font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css', array(), '4.4.0' );
	/* Theme */
	wp_register_style( 'main-theme', get_stylesheet_uri(), array( 'bootstrap' ), '1.0' );
} );

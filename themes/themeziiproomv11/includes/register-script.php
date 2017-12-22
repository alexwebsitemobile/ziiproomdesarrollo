<?php

// Register Script
add_action('wp_enqueue_scripts', function () {
	/* jQuery v2.1.4 */
	wp_deregister_script('jquery');
	wp_register_script('jquery', '//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js', array(), '2.1.4', false);
	/* Modernizr v2.8.3 */
	wp_register_script('modernizr', '//cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js', array(), '2.8.3', false);
	/* Bootstrap v3.3.5 */
	wp_register_script('bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js', array('jquery'), '3.3.5', false);
	/* WOW.js v1.1.2 */
	wp_register_script( 'wow', '//cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js', array(), '1.1.2', true );
});

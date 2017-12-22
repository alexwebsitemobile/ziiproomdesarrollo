<?php

add_action('wp_enqueue_scripts', 'jptt_script_cdn');

function jptt_script_cdn()
{
	// jQuery
	$cdn_jquery = get_option('cdn-jquery');
	if (!empty($cdn_jquery)) {
		wp_deregister_script('jquery');
		wp_enqueue_script('jquery', $cdn_jquery, false, null, false);
	}

	// jQuery Migrate
	$cdn_jquery_migrate = get_option('cdn-jquery-migrate');
	if (!empty($cdn_jquery)) {
		wp_deregister_script('jquery-migrate');
		wp_enqueue_script('jquery-migrate', $cdn_jquery_migrate, array('jquery'), null, false);
	}
}

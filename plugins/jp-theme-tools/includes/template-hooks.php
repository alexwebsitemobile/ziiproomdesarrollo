<?php

defined( 'ABSPATH' ) or die( 'No direct script access allowed' );

add_action( 'after_setup_theme', function() {

	/**
	 * Overrides the WooCommerce default pagination with the Bootstrap component.
	 *
	 * @see jptt_pagination()
	 */
	if ( (bool) jptt_get_option( 'woocommerce_pagination' ) ) {
		remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination' );
		add_action( 'woocommerce_after_shop_loop', 'jptt_pagination' );
	}
} );

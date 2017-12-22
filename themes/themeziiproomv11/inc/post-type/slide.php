<?php

/**
 * Register Slide Post Type
 */
add_action( 'init', function () {

	$labels = array(
		'name'                => __( 'Slides', TEXT_DOMAIN ),
		'singular_name'       => __( 'Slide', TEXT_DOMAIN ),
		'menu_name'           => __( 'Slides', TEXT_DOMAIN ),
		'name_admin_bar'      => __( 'Slide', TEXT_DOMAIN ),
		'parent_item_colon'   => __( 'Parent Item:', TEXT_DOMAIN ),
		'all_items'           => __( 'All Items', TEXT_DOMAIN ),
		'add_new_item'        => __( 'Add New Item', TEXT_DOMAIN ),
		'add_new'             => __( 'Add New', TEXT_DOMAIN ),
		'new_item'            => __( 'New Item', TEXT_DOMAIN ),
		'edit_item'           => __( 'Edit Item', TEXT_DOMAIN ),
		'update_item'         => __( 'Update Item', TEXT_DOMAIN ),
		'view_item'           => __( 'View Item', TEXT_DOMAIN ),
		'search_items'        => __( 'Search Item', TEXT_DOMAIN ),
	);
	$args = array(
		'label'               => __( 'Carousel', TEXT_DOMAIN ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail', ),
		'hierarchical'        => false,
		'public'              => false,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 20,
		'show_in_admin_bar'   => false,
		'show_in_nav_menus'   => false,
		'menu_icon'          => 'dashicons-slides',
		'has_archive'         => true,
		'exclude_from_search' => true,
		'publicly_queryable'  => false,
		'rewrite'             => false,
		'capability_type'     => 'post',
	);
	register_post_type( 'slide', $args );

}, 0 );
<?php

/**
 * Register People Post Type
 */
add_action( 'init', function () {

	$labels = array(
		'name'                => _x( 'People', TEXT_DOMAIN ),
		'singular_name'       => _x( 'Person', TEXT_DOMAIN ),
		'menu_name'           => __( 'People', TEXT_DOMAIN ),
		'name_admin_bar'      => __( 'Person', TEXT_DOMAIN ),
		'parent_item_colon'   => __( 'Parent Item:', TEXT_DOMAIN ),
		'all_items'           => __( 'All Items', TEXT_DOMAIN ),
		'add_new_item'        => __( 'Add New Person', TEXT_DOMAIN ),
		'add_new'             => __( 'Add New', TEXT_DOMAIN ),
		'new_item'            => __( 'New Item', TEXT_DOMAIN ),
		'edit_item'           => __( 'Edit Item', TEXT_DOMAIN ),
		'update_item'         => __( 'Update Item', TEXT_DOMAIN ),
		'view_item'           => __( 'View Item', TEXT_DOMAIN ),
		'search_items'        => __( 'Search Item', TEXT_DOMAIN ),
	);
	$args = array(
		'label'               => __( 'Person', TEXT_DOMAIN ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail', ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 20,
		'menu_icon'           => 'dashicons-groups',
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => true,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => true,
		'publicly_queryable'  => false,
		'capability_type'     => 'post',
	);
	register_post_type( 'person', $args );

}, 0 );
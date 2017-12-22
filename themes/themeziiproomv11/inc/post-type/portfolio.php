<?php

/**
 * Register Portfolio Post Type
 */
add_action( 'init', function () {

	$labels = array(
		'name'                => __( 'Portfolio', TEXT_DOMAIN ),
		'singular_name'       => __( 'Portfolio', TEXT_DOMAIN ),
		'menu_name'           => __( 'Portfolio', TEXT_DOMAIN ),
		'name_admin_bar'      => __( 'Portfolio', TEXT_DOMAIN ),
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
	$rewrite = array(
		'slug'                => _x( 'portfolio', 'slug', TEXT_DOMAIN ),
		'with_front'          => true,
		'pages'               => true,
		'feeds'               => true,
	);
	$args = array(
		'label'               => __( 'Portfolio', TEXT_DOMAIN ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail', ),
		'taxonomies'          => array( 'portfolio_cat', 'portfolio_tag' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 5,
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => true,
		'menu_icon'          => 'dashicons-portfolio',
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'rewrite'             => $rewrite,
		'capability_type'     => 'post',
	);
	register_post_type( 'portfolio', $args );

}, 0 );
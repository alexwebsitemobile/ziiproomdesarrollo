<?php

// Set content width value based on the theme's design
if ( !isset( $content_width ) )
	$content_width = 1200;

if ( !function_exists( 'custom_theme_features' ) ) {

// Register Theme Features
	function custom_theme_features() {

		// Add theme support for Automatic Feed Links
		add_theme_support( 'automatic-feed-links' );

		// Add theme support for Post Formats
		add_theme_support( 'post-formats', array( 'status', 'quote', 'gallery', 'image', 'video', 'audio', 'link', 'aside', 'chat' ) );

		// Add theme support for Featured Images
		add_theme_support( 'post-thumbnails' );

		// Add theme support for HTML5 Semantic Markup
		add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

		// Add theme support for document Title tag
		add_theme_support( 'title-tag' );

		// Add theme support for custom background
		add_theme_support( 'custom-background' );

		// Add theme support for custom CSS in the TinyMCE visual editor
		add_editor_style( 'editor-style.css' );

		// Add theme support for Translation
		load_theme_textdomain( TEXT_DOMAIN, get_template_directory() . '/languages' );

		// Register multiple custom navigation menus
		register_nav_menus( array(
				'top_menu' => __('Main Menu' , TEXT_DOMAIN ),
		) );
	}

// Hook into the 'after_setup_theme' action
	add_action( 'after_setup_theme', 'custom_theme_features' );
}

add_action( 'admin_notices', 'showAdminMessages' );

function showAdminMessages() {
	$plugin_messages = array();

	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

	// Download the Yoast WordPress SEO plugin
	if ( !is_plugin_active( 'jp-theme-tools/jp-theme-tools.php' ) ) {
		$plugin_messages[] = 'This theme requires you to install the JP Theme Tools plugin, <a href="https://github.com/jprieton/jp-theme-tools/releases">download it from here</a>.';
	}

	if ( count( $plugin_messages ) > 0 ) {
		echo '<div id="message" class="error">';

		foreach ( $plugin_messages as $message ) {
			echo '<p><strong>' . $message . '</strong></p>';
		}

		echo '</div>';
	}
}

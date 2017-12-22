<?php

/** Block direct access */
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/**
 * Plugin Name: JP WordPress Theme Tools
 * Plugin URI: https://github.com/jprieton/jp-theme-tools/
 * Description: Extends WordPress functionality for themes
 * Version: 0.19.1
 * Author: Javier Prieto
 * Text Domain: jptt
 * Domain Path: /languages
 * Author URI: https://github.com/jprieton/
 * GitHub Plugin URI: jprieton/jp-theme-tools
 * GitHub Branch: master
 * License: GPL3 or later
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */
defined( 'JPTT_TEXT_DOMAIN' ) || define( 'JPTT_TEXT_DOMAIN', 'jptt' );
defined( 'JPTT_BASEPATH' ) || define( 'JPTT_BASEPATH', plugin_dir_path( __FILE__ ) );
defined( 'JPTT_BASEURI' ) || define( 'JPTT_BASEURI', plugin_dir_url( __FILE__ ) );

add_action( 'plugins_loaded', function () {

	/**
	 * Load plugin textdomain.
	 *
	 * @since 1.0.0
	 */
	load_plugin_textdomain( JPTT_TEXT_DOMAIN, false, plugin_basename( dirname( __FILE__ ) ) . '/i18n' );
} );


/**
 * -----------------------------------------------------
 * Cleanup/Rewrite 22/04/2016
 * -----------------------------------------------------
 */
/** Init */
require_once JPTT_BASEPATH . '/includes/init.php';


/** On activate plugin * /
  register_activation_hook( __FILE__, function() {
  Post_Stats::create_table();
  } );
 */
require( dirname( __FILE__ ) . '/_includes/functions-scripts.php' );

// https://developer.wordpress.org/plugins/the-basics/best-practices/
// require( dirname( __FILE__ ) . '/_includes/admin/admin-menu.php' );

define( 'JPTT_THEME_PATH', get_stylesheet_directory() );
define( 'JPTT_THEME_URI', get_stylesheet_directory_uri() );



require_once __DIR__ . '/updater/GitHubUpdater.php';

// Updates
add_action( 'admin_init', function () {
	new GitHubUpdater( __FILE__, 'jprieton', 'jp-theme-tools' );
}, 99 );

include_once __DIR__ . '/_includes/input.php';
include_once __DIR__ . '/_includes/user.php';
include_once __DIR__ . '/_includes/error.php';

include_once JPTT_BASEPATH . '_includes/taxonomy.php';

//Helpers
include_once JPTT_BASEPATH . 'helpers/debug.php';
include_once JPTT_BASEPATH . 'helpers/url.php';
include_once JPTT_BASEPATH . 'helpers/form.php';
include_once JPTT_BASEPATH . 'core/Common.php';
// include_once JPTT_BASEPATH . 'helpers/user.php';
//Frontend
//include_once JPTT_BASEPATH . 'frontend/attachments.php';
//include_once JPTT_BASEPATH . 'frontend/galleries.php';
//include_once JPTT_BASEPATH . 'frontend/posts.php';
//include_once JPTT_BASEPATH . 'frontend/users.php';
// Action hooks
include_once JPTT_BASEPATH . '_includes/link-template.php';
include_once JPTT_BASEPATH . '_includes/class-html.php';
include_once JPTT_BASEPATH . '_includes/post-thumbnail-template.php';
include_once JPTT_BASEPATH . '_includes/class-head-actions.php';
include_once JPTT_BASEPATH . 'includes/class-jptt_instagram.php';

//include_once JPTT_BASEPATH . 'includes/class-user-actions.php';
include_once JPTT_BASEPATH . '_includes/contact.php';
include_once JPTT_BASEPATH . 'actions/profile-image.php';

global $defer_scripts, $async_scripts;
require_once JPTT_BASEPATH . '/functions/common-functions.php';
require_once JPTT_BASEPATH . '/filters/common-filters.php';
require_once JPTT_BASEPATH . '/_includes/actions.php';

require_once __DIR__ . '/core/class-error.php';
require_once __DIR__ . '/core/class-input.php';

require_once __DIR__ . '/core/class-request.php';

// Autoload modules
$jptt_modules = (array) get_option( 'jptt_modules', array() );
foreach ( $jptt_modules as $key => $value ) {
	if ( file_exists( JPTT_BASEPATH . "modules/{$key}/module.php" ) ) {
		include_once JPTT_BASEPATH . "modules/{$key}/module.php";
	}
}

if ( is_admin() ) {


	add_action( 'admin_init', 'jptt_admin_settings' );

	function jptt_admin_settings() {
		// Opciones generales
		register_setting( 'jptt-general-group', 'jptt_options' );
		register_setting( 'jptt-general-group', 'remove-generator', 'boolval' );
		register_setting( 'jptt-general-group', 'remove-feed-links-extra', 'boolval' );
		register_setting( 'jptt-general-group', 'remove-feed-links', 'boolval' );
		register_setting( 'jptt-general-group', 'remove-wlwmanifest-link', 'boolval' );
		register_setting( 'jptt-general-group', 'remove-index-rel-link', 'boolval' );
		register_setting( 'jptt-general-group', 'remove-parent-post-rel-link', 'boolval' );
		register_setting( 'jptt-general-group', 'remove-start_post-rel-link', 'boolval' );
		register_setting( 'jptt-general-group', 'remove-adjacent_posts-rel-link-wp_head', 'boolval' );
		// Analitica y SEO
		register_setting( 'jptt-seo-group', 'google-analytics' );
		register_setting( 'jptt-seo-group', 'google-tag-manager' );
		register_setting( 'jptt-seo-group', 'google-site-verification' );
		register_setting( 'jptt-seo-group', 'bing-site-verification' );
		register_setting( 'jptt-seo-group', 'open-graph-meta', 'boolval' );
		register_setting( 'jptt-seo-group', 'twitter-card-meta', 'boolval' );
		// Contacto
		register_setting( 'jptt-contact-group', 'contact-form-email', 'sanitize_text_field' );
		register_setting( 'jptt-contact-group', 'contact-email', 'sanitize_email' );
		register_setting( 'jptt-contact-group', 'contact-phone', 'sanitize_text_field' );
		register_setting( 'jptt-contact-group', 'google-maps' );
		// Social
		register_setting( 'jptt-social-group', 'social-facebook', 'jptt_valid_url' );
		register_setting( 'jptt-social-group', 'social-facebook-admins' );
		register_setting( 'jptt-social-group', 'social-facebook-app-id' );
		register_setting( 'jptt-social-group', 'social-googleplus', 'jptt_valid_url' );
		register_setting( 'jptt-social-group', 'social-instagram', 'jptt_valid_url' );
		register_setting( 'jptt-social-group', 'social-instagram-client-id' );
		register_setting( 'jptt-social-group', 'social-instagram-access-token' );
		register_setting( 'jptt-social-group', 'social-linkedin', 'jptt_valid_url' );
		register_setting( 'jptt-social-group', 'social-pinterest', 'jptt_valid_url' );
		register_setting( 'jptt-social-group', 'social-twitter', 'jptt_valid_url' );
		register_setting( 'jptt-social-group', 'social-yelp', 'jptt_valid_url' );
		register_setting( 'jptt-social-group', 'social-youtube', 'jptt_valid_url' );
		// CDN
		register_setting( 'jptt-cdn-group', 'cdn-jquery', 'jptt_valid_url' );
		register_setting( 'jptt-cdn-group', 'cdn-jquery-migrate', 'jptt_valid_url' );
		// TimThumb
		register_setting( 'jptt-timthumb-group', 'timthumb_htaccess', 'boolval' );
		register_setting( 'jptt-timthumb-group', 'timthumb_debug_on', 'boolval' );
		register_setting( 'jptt-timthumb-group', 'timthumb_block_external_leechers', 'boolval' );
		register_setting( 'jptt-timthumb-group', 'timthumb_display_error_messages', 'boolval' );
		register_setting( 'jptt-timthumb-group', 'timthumb_allow_external', 'boolval' );
		register_setting( 'jptt-timthumb-group', 'timthumb_allow_all_external_sites', 'boolval' );
		register_setting( 'jptt-timthumb-group', 'timthumb_file_cache_enabled', 'boolval' );
		register_setting( 'jptt-timthumb-group', 'timthumb_file_cache_time_between_cleans', 'intval' );
		register_setting( 'jptt-timthumb-group', 'timthumb_file_cache_directory' );
		register_setting( 'jptt-timthumb-group', 'timthumb_browser_cache_disable', 'boolval' );
		register_setting( 'jptt-timthumb-group', 'timthumb_max_width', 'intval' );
		register_setting( 'jptt-timthumb-group', 'timthumb_max_height', 'intval' );
		register_setting( 'jptt-timthumb-group', 'timthumb_not_found_image' );
		register_setting( 'jptt-timthumb-group', 'timthumb_error_image' );
		register_setting( 'jptt-timthumb-group', 'timthumb_png_is_transparent', 'boolval' );
		register_setting( 'jptt-timthumb-group', 'timthumb_default_zc', 'intval' );
		register_setting( 'jptt-timthumb-group', 'timthumb_default_width', 'intval' );
		register_setting( 'jptt-timthumb-group', 'timthumb_default_height', 'intval' );
	}

	add_action( 'admin_enqueue_scripts', 'jptt_admin_style' );

	function jptt_admin_style() {
		wp_register_style( 'jptt_admin_style', JPTT_BASEURI . 'assets/css/jp-theme-tools-admin.css', false, '1.0.0' );
		wp_enqueue_style( 'jptt_admin_style' );
	}

} else {
	// Overrides WordPress scripts
	require_once __DIR__ . '/_includes/override-cdn.php';
}

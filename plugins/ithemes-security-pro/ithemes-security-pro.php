<?php

/*
 * Plugin Name: iThemes Security Pro
 * Plugin URI: https://ithemes.com/security
 * Description: Take the guesswork out of WordPress security. iThemes Security offers 30+ ways to lock down WordPress in an easy-to-use WordPress security plugin.
 * Author: iThemes
 * Author URI: https://ithemes.com
 * Version: 3.0.3
 * Text Domain: it-l10n-ithemes-security-pro
 * Domain Path: /lang
 * Network: True
 * License: GPLv2
 * iThemes Package: ithemes-security-pro
 */


$locale = apply_filters( 'plugin_locale', get_locale(), 'it-l10n-ithemes-security-pro' );
load_textdomain( 'it-l10n-ithemes-security-pro', WP_LANG_DIR . "/plugins/ithemes-security-pro/it-l10n-ithemes-security-pro-$locale.mo" );
load_plugin_textdomain( 'it-l10n-ithemes-security-pro', false, basename( dirname( __FILE__ ) ) . '/lang/' );

if ( isset( $itsec_dir ) || class_exists( 'ITSEC_Core' ) ) {
	include( dirname( __FILE__ ) . '/core/show-multiple-version-notice.php' );
	return;
}


if ( ! function_exists( 'itsec_pro_register_modules' ) ) {
	// Add pro modules at priority 11 so they are added after core modules (thus taking precedence)
	add_action( 'itsec-register-modules', 'itsec_pro_register_modules', 11 );
	function itsec_pro_register_modules() {
		$path = dirname( __FILE__ );

		include( "$path/pro/core/init.php" );
		include( "$path/pro/dashboard-widget/init.php" );
		include( "$path/pro/malware-scheduling/init.php" );
		include( "$path/pro/online-files/init.php" );
		include( "$path/pro/privilege/init.php" );
		include( "$path/pro/password-expiration/init.php" );
		include( "$path/pro/recaptcha/init.php" );
		include( "$path/pro/import-export/init.php" );
		include( "$path/pro/two-factor/init.php" );
		include( "$path/pro/user-logging/init.php" );
		include( "$path/pro/version-management/init.php" );
		include( "$path/pro/wp-cli/init.php" );
		include( "$path/pro/user-security-check/init.php" );
	}
}


$itsec_dir = dirname( __FILE__ );

require( "$itsec_dir/core/class-itsec-core.php" );
$itsec_core = ITSEC_Core::get_instance();
$itsec_core->init( __FILE__, __( 'iThemes Security Pro', 'it-l10n-ithemes-security-pro' ) );


if ( is_admin() ) {
	require( "$itsec_dir/lib/icon-fonts/load.php" );
}


if ( ! function_exists( 'ithemes_repository_name_updater_register' ) ) {
	function ithemes_repository_name_updater_register( $updater ) {
		$updater->register( 'ithemes-security-pro', __FILE__ );
	}
	add_action( 'ithemes_updater_register', 'ithemes_repository_name_updater_register' );

	require( "$itsec_dir/lib/updater/load.php" );
}

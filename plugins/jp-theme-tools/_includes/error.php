<?php

defined( 'ABSPATH' ) or die( 'No direct script access allowed' );

/**
 * Shortcut for <i>401 Unauthorized</i> error
 * @since v0.12.2
 * @author jprieton
 * @param string $method
 * @param bool $wp_die
 * @param int $status_code (Only if $wp_die is <i>true</i>)
 * @return WP_Error
 */
function error_unauthorized( $method = null, $wp_die = FALSE, $status_code = 401 ) {
	$message = __( 'Unauthorized', 'jptt' );
	$error = new WP_Error( 'unauthorized', $message );
	if ( !empty( $method ) ) {
		$error->add( 'method', $method );
	}

	if ( $wp_die ) {
		wp_die( $error, '', array( 'response' => $status_code ) );
	} else {
		return $error;
	}
}

/**
 * Shortcut for <i>403 Forbidden</i> error
 * @since v0.12.2
 * @author jprieton
 * @param string $method
 * @param bool $wp_die
 * @param int $status_code (Only if $wp_die is <i>true</i>)
 * @return WP_Error
 */
function error_forbidden( $method = null, $wp_die = FALSE, $status_code = 403 ) {
	$message = __( 'Forbidden', 'jptt' );
	$error = new WP_Error( 'forbidden', $message );
	if ( !empty( $method ) ) {
		$error->add( 'method', $method );
	}

	if ( $wp_die ) {
		wp_die( $error, '', array( 'response' => $status_code ) );
	} else {
		return $error;
	}
}

/**
 * Shortcut for <i>404 Not Found</i> error
 * @since v0.12.2
 * @author jprieton
 * @param string $method
 * @param bool $wp_die
 * @param int $status_code (Only if $wp_die is <i>true</i>)
 * @return WP_Error
 */
function error_not_found( $method = null, $wp_die = FALSE, $status_code = 404 ) {
	$message = __( 'Not Found', 'jptt' );
	$error = new WP_Error( 'not_found', $message );
	if ( !empty( $method ) ) {
		$error->add( 'method', $method );
	}

	if ( $wp_die ) {
		wp_die( $error, '', array( 'response' => $status_code ) );
	} else {
		return $error;
	}
}

/**
 * Shortcut for <i>405 Method Not Allowed</i> error
 * @since v0.12.2
 * @author jprieton
 * @param string $method
 * @param bool $wp_die
 * @param int $status_code (Only if $wp_die is <i>true</i>)
 * @return WP_Error
 */
function error_method_not_allowed( $method = null, $wp_die = FALSE, $status_code = 405 ) {
	$message = __( 'Method not allowed', 'jptt' );
	$error = new WP_Error( 'method_not_allowed', $message );
	if ( !empty( $method ) ) {
		$error->add( 'method', $method );
	}

	if ( $wp_die ) {
		wp_die( $error, '', array( 'response' => $status_code ) );
	} else {
		return $error;
	}
}

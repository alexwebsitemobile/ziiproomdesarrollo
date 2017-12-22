<?php

defined( 'ABSPATH' ) or die( 'No direct script access allowed' );

if ( !function_exists( 'is_url' ) ) {

	/**
	 * Verifies that an url is valid.
	 * @since 0.12.3
	 * @param string $url Url address to verify.
	 * @return string|bool Either false or the valid url address.
	 */
	function is_url( $url ) {
		return filter_var( $url, FILTER_VALIDATE_URL );
	}

}

/**
 * Wrapper that retrieve plugin option value based on name of option.
 *
 * @since 1.0.0
 *
 * @param string      $option   Name of option to retrieve. Expected to not be SQL-escaped.
 * @param mixed       $value    Optional. Default value to return if the option does not exist.
 * @return mixed Value set for the option.
 */
function jptt_get_option( $option, $default = false ) {
	$jptt = JPTT::get_instance();
	return $jptt->get_option( $option, $default );
}

/**
 * Wrapper that update the value of an plugin option that was already added.
 *
 * If the option does not exist, then the option will be added with the option value
 *
 * @since 1.0.0
 *
 * @param string      $option   Option name. Expected to not be SQL-escaped.
 * @param mixed       $value    Option value. Must be serializable if non-scalar. Expected to not be SQL-escaped.
 * @return boolean
 */
function jptt_update_option( $option, $value ) {
	$jptt = JPTT::get_instance();
	return $jptt->update_option( $option, $value );
}

/**
 * Outputs publish date as time since posted
 *
 * @since 0.14.0
 *
 * @param string $date
 * @param bool $full
 *
 * @return string|void String if retrieving.
 */
function the_time_ago( $before = '', $after = '', $full = false, $echo = true ) {
	$time_ago = $before . get_the_time_ago( null, $full ) . $after;
	$time_ago = apply_filters( 'the_time_ago', $time_ago, $before, $after );
	if ( $echo ) {
		echo $time_ago;
	} else {
		return $time_ago;
	}
}

/**
 * Retrieve publish date as time since posted
 *
 * @since 0.14.0
 *
 * @param int|WP_Post $post Optional. Post ID or WP_Post object. Default current post.
 * @param type $full
 *
 * @return string
 */
function get_the_time_ago( $post = null, $full = false ) {
	$post = get_post( $post );

	if ( !$post ) {
		return false;
	}

	$post_time = new DateTime( $post->post_date );
	$current_time = new DateTime( current_time( 'mysql' ) );

	$diff = $current_time->diff( $post_time );
	$diff instanceof DateInterval;

	$time_ago = array();

	if ( $diff->y ) {
		$time_ago[] = $diff->y . ' ' . _n( 'year', 'years', $diff->y, JPTT_TEXTDOMAIN );
	}
	if ( $diff->m ) {
		$time_ago[] = $diff->m . ' ' . _n( 'month', 'months', $diff->m, JPTT_TEXTDOMAIN );
	}
	if ( $diff->d ) {
		$time_ago[] = $diff->d . ' ' . _n( 'day', 'days', $diff->d, JPTT_TEXTDOMAIN );
	}
	if ( $diff->h ) {
		$time_ago[] = $diff->h . ' ' . _n( 'hour', 'hours', $diff->h, JPTT_TEXTDOMAIN );
	}
	if ( $diff->m ) {
		$time_ago[] = $diff->m . ' ' . _n( 'minute', 'minutes', $diff->m, JPTT_TEXTDOMAIN );
	}

	if ( empty( $time_ago ) ) {
		$time_ago[] = __( 'a few seconds', JPTT_TEXTDOMAIN );
	}

	$string = ($full) ? implode( ', ', $time_ago ) : $time_ago[0];

	$string = sprintf( _x( '%s ago', 'time_ago', JPTT_TEXTDOMAIN ), $string );

	$string = apply_filters( 'get_the_time_ago', $string, $time_ago, $diff );

	return $string;
}

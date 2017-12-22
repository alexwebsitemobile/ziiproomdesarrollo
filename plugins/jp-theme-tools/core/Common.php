<?php

// --------------------------------------------------------------------

if ( !function_exists( 'remove_invisible_characters' ) ) {

	/**
	 * Remove Invisible Characters
	 *
	 * This prevents sandwiching null characters
	 * between ascii characters, like Java\0script.
	 *
	 * @param	string
	 * @param	bool
	 * @return	string
	 */
	function remove_invisible_characters( $str, $url_encoded = TRUE ) {
		$non_displayables = array();

		// every control character except newline (dec 10),
		// carriage return (dec 13) and horizontal tab (dec 09)
		if ( $url_encoded ) {
			$non_displayables[] = '/%0[0-8bcef]/'; // url encoded 00-08, 11, 12, 14, 15
			$non_displayables[] = '/%1[0-9a-f]/'; // url encoded 16-31
		}

		$non_displayables[] = '/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]+/S'; // 00-08, 11, 12, 14-31, 127

		do {
			$str = preg_replace( $non_displayables, '', $str, -1, $count );
		} while ( $count );

		return $str;
	}

}

// ------------------------------------------------------------------------

if ( !function_exists( 'html_escape' ) ) {

	/**
	 * Returns HTML escaped variable.
	 *
	 * @param	mixed	$var		The input string or array of strings to be escaped.
	 * @param	bool	$double_encode	$double_encode set to FALSE prevents escaping twice.
	 * @return	mixed			The escaped string or array of strings as a result.
	 */
	function html_escape( $var, $double_encode = TRUE ) {
		if ( empty( $var ) ) {
			return $var;
		}

		if ( is_array( $var ) ) {
			return array_map( 'html_escape', $var, array_fill( 0, count( $var ), $double_encode ) );
		}

		return htmlspecialchars( $var, ENT_QUOTES, config_item( 'charset' ), $double_encode );
	}

}

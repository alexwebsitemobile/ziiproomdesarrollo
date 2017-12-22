<?php

/**
 * Convert PHP date format standard to jQuery equivalent
 *
 * @since 1.0.0
 * 
 * @author Tristan Jahier
 * 
 * @param string $format PHP date format
 * @see http://tristan-jahier.fr/blog/2013/08/convertir-un-format-de-date-php-en-format-de-date-jqueryui-datepicker
 */
function jqueryui_date_format( $php_format = null ) {
	if ( empty( $php_format ) ) {
		$php_format = get_option( 'date_format' );
	}

	$format = array(
			// Day
			'd' => 'dd',
			'D' => 'D',
			'j' => 'd',
			'l' => 'DD',
			'N' => '',
			'S' => '',
			'w' => '',
			'z' => 'o',
			// Week
			'W' => '',
			// Month
			'F' => 'MM',
			'm' => 'mm',
			'M' => 'M',
			'n' => 'm',
			't' => '',
			// Year
			'L' => '',
			'o' => '',
			'Y' => 'yy',
			'y' => 'y',
			// Time
			'a' => '',
			'A' => '',
			'B' => '',
			'g' => '',
			'G' => '',
			'h' => '',
			'H' => '',
			'i' => '',
			's' => '',
			'u' => ''
	);
	$jqueryui_format = "";
	$escaping = false;
	for ( $i = 0; $i < strlen( $php_format ); $i++ ) {
		$char = $php_format[$i];
		if ( $char === '\\' ) { // PHP date format escaping character
			$i++;
			if ( $escaping )
				$jqueryui_format .= $php_format[$i];
			else
				$jqueryui_format .= '\'' . $php_format[$i];
			$escaping = true;
		}
		else {
			if ( $escaping ) {
				$jqueryui_format .= "'";
				$escaping = false;
			}
			if ( isset( $format[$char] ) )
				$jqueryui_format .= $format[$char];
			else
				$jqueryui_format .= $char;
		}
	}
	return $jqueryui_format;
}

<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * HTML Class
 *
 * @author jprieton
 */
class HTML {

	/**
	 * Stringify attributes for use in HTML tags.
	 *
	 * Helper function used to convert a string, array, or object
	 * of attributes to a string.
	 *
	 * @param	mixed	string, array, object
	 * @param	string Text domain
	 * @return	string
	 * @author jprieton
	 */
	public static function attributes( $attributes, $domain = null ) {
		$atts = array();

		if ( empty( $attributes ) ) {
			return '';
		}

		if ( is_string( $attributes ) ) {
			return $attributes;
		}

		$attributes = (array) $attributes;
		foreach ( $attributes as $key => $val ) {
			$atts[] = ($domain) ? trim( $key ) . '="' . trim( esc_attr__( $val, $domain ) ) . '"' : trim( $key ) . '="' . trim( esc_attr( $val ) ) . '"';
		}

		return implode( ' ', $atts );
	}

}

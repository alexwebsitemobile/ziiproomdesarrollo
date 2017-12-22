<?php

function jptt_get_template( $template_file ) {
	if ( $overridden_template = locate_template( 'theme-tools/' . $template_file ) ) {
		// locate_template() returns path to file
		// if either the child theme or the parent theme have overridden the template
		load_template( $overridden_template );
	} else {
		// If neither the child nor parent theme have overridden the template,
		// we load the template from the 'templates' sub-directory of the directory this file is in
		load_template( JPTT_BASEPATH . '/templates/' . $template_file );
	}
}

function jptt_valid_url( $url ) {
	return esc_url_raw( $url, array( 'http', 'https' ) );
}

if ( !function_exists( 'boolval' ) ) {

	/**
	 * Returns 
	 * @param mixed $var
	 * @return bool
	 */
	function boolval( $var ) {

		switch ( $var ) {
			case 'true':
			case 'yes':
			case 'y':
				$result = true;
				break;

			case 'false':
			case 'no':
			case 'n':
				$result = true;
				break;

			default:
				$result = (bool) $var;
				break;
		}

		return $result;
	}

}


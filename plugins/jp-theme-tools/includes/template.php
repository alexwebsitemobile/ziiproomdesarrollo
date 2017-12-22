<?php

/**
 * Get template part.
 *
 * @access public
 * @param mixed $slug
 * @param string $name (default: '')
 */
function jptt_get_template_part( $slug, $name = null ) {

	$template = '';

	// Look in yourtheme/jptt/slug-name.php
	if ( $name ) {
		$template = locate_template( array( "jptt/{$slug}-{$name}.php" ) );
	}

	// Get default slug-name.php
	if ( !$template && $name && file_exists( JPTT_BASEPATH . "/templates/{$slug}-{$name}.php" ) ) {
		$template = JPTT_BASEPATH . "/templates/{$slug}-{$name}.php";
	}

	// If template file doesn't exist, look in yourtheme/jptt/slug.php
	if ( !$template ) {
		$template = locate_template( array( "jptt/{$slug}.php" ) );
	}

	// If template file doesn't existGet default slug.php
	if ( !$template && file_exists( JPTT_BASEPATH . "/templates/{$slug}.php" ) ) {
		$template = JPTT_BASEPATH . "/templates/{$slug}.php";
	}

	if ( $template ) {
		$template = realpath( $template );
	}

	// Allow 3rd party plugins to filter template file from their plugin.
	$template = apply_filters( 'jptt_get_template_part', $template, $slug, $name );

	if ( $template ) {
		load_template( $template, false );
	}
}

/**
 * Shows the pagination component
 *
 * @since 0.18.2
 *
 * @see https://github.com/jprieton/jp-theme-tools/wiki/Pagination
 * @see http://getbootstrap.com/components/#pagination
 */
function jptt_pagination( $type = 'default' ) {
	$type = in_array( $type, array( 'default', 'pager' ) ) ? $type : 'default';
	jptt_get_template_part( "global/pagination-{$type}" );
}

/**
 * Aliases for bootstrap_pagination()
 * Shows the pagination component
 *
 * @since 0.18.2
 *
 * @see https://github.com/jprieton/jp-theme-tools/wiki/Pagination
 * @see http://getbootstrap.com/components/#pagination
 */
function bootstrap_pagination( $type = 'default' ) {
	jptt_pagination( $type );
}

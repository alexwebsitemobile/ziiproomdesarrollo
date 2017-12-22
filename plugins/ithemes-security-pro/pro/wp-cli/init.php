<?php

if ( class_exists( 'WP_CLI' ) && class_exists( 'WP_CLI_Command' ) ) {
	require( dirname( __FILE__ ) . '/class-itsec-wp-cli-command-itsec.php' );
	WP_CLI::add_command( 'itsec', 'ITSEC_WP_CLI_Command_ITSEC' );
}

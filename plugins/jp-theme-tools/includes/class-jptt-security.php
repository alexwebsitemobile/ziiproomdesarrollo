<?php

/** Block direct access */
defined( 'ABSPATH' ) or die( 'No direct script access allowed' );

/**
 *
 * @since 1.0.0
 *
 */
class JPTT_Security {

	/** Refers to a single instance of this class. */
	private static $instance = null;

	/**
	 * Creates or returns an instance of this class.
	 *
	 * @since 1.0.0
	 *
	 * @return JPTT_Security A single instance of this class.
	 */
	public static function get_instance() {

		if ( self::$instance == null ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	private function __construct() {

	}

	/**
	 * Get htaccess file content to block direct execution script
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	private function get_htaccess() {
		return "# ----------------------------------------------------------------------\n" .
						"# DISABLE DIRECTORY BROWSING\n" .
						"# ----------------------------------------------------------------------\n" .
						"Options All -Indexes\n" .
						"\n" .
						"# ----------------------------------------------------------------------\n" .
						"# DISABLE DIRECT CODE EXECUTION\n" .
						"# ----------------------------------------------------------------------\n" .
						"<FilesMatch \"\.(php|pl|py|jsp|asp|htm|shtml|sh|cgi)$\">\n" .
						"  order allow,deny\n" .
						"  deny from all\n" .
						"</FilesMatch>\n" .
						"<files .htaccess>\n" .
						"  order allow,deny\n" .
						"  deny from all\n" .
						"</files>\n";
	}

	/**
	 * Add .htaccess file in folder
	 *
	 * @since 1.0.0
	 *
	 * @param string $folder
	 * @return boolean
	 */
	public function write_htaccess( $folder ) {
		$folder = trim( strtolower( $folder ) );

		if ( !in_array( $folder, array( 'plugins', 'themes', 'uploads', 'languages' ) ) ) {
			return false;
		}

		$filename = realpath( WP_CONTENT_DIR . '/' . $folder ) . DIRECTORY_SEPARATOR . '.htaccess';

		try {
			file_put_contents( $filename, $this->get_htaccess() );
		} catch ( Exception $exc ) {

		}

		return true;
	}

	/**
	 * Remove .htaccess file from folder
	 *
	 * @since 1.0.0
	 *
	 * @param string $folder
	 * @return boolean
	 */
	public function remove_htaccess( $folder ) {
		$folder = trim( strtolower( $folder ) );

		if ( !in_array( $folder, array( 'plugins', 'themes', 'uploads', 'languages' ) ) ) {
			return false;
		}

		$dir = realpath( WP_CONTENT_DIR . '/' . $folder );

		$filename = realpath( WP_CONTENT_DIR . '/' . $folder ) . DIRECTORY_SEPARATOR . '.htaccess';

		if ( !file_exists( $filename ) ) {
			return false;
		}

		try {
			unlink( $dir . DIRECTORY_SEPARATOR . '.htaccess' );
		} catch ( Exception $ex ) {

		}
		return true;
	}

}

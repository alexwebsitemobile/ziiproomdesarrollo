<?php

final class ITSEC_Automatic_Away_Mode {
	private static $instance;

	private $last_seen_key = 'itsec_automatic_away_mode_last_seen';
	private $login_code_key = 'itsec_automatic_away_mode_login_code';
	private $nonce_key = 'itsec_automatic_away_mode_nonce';

	private $settings;
	private $user_id;

	private function __construct() {
		$this->settings = ITSEC_Modules::get_settings( 'automatic-away-mode' );

		add_action( 'plugins_loaded', array( $this, 'init' ) );
		add_action( 'wp_login', array( $this, 'wp_login' ), 0, 2 );
		add_action( 'login_form_validate_unlock_code',  array( $this, 'login_form_validate_unlock_code' ) );
	}

	public function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	public function init() {
		global $wp_version;

		$this->user_id = get_current_user_id();

		if ( $this->user_id > 0 ) {
			$last_seen = get_user_meta( $this->user_id, $this->last_seen_key, true );

			if ( $last_seen < time() - HOUR_IN_SECONDS ) {
				$this->update_user_last_seen();
			}
		}
	}

	private function update_user_last_seen() {
		if ( empty( $this->user_id ) ) {
			$this->user_id = get_current_user_id();
		}

		update_user_meta( $this->user_id, $this->last_seen_key, time() );
	}

	private function is_user_inactive( $user_id ) {
		if ( $this->settings['user_max_inactivity'] <= 0 ) {
			return false;
		}

		$last_seen = get_user_meta( $user_id, $this->last_seen_key, true );

		if ( $last_seen + $this->settings['user_max_inactivity'] < time() ) {
			return true;
		}

		return false;
	}

	private function get_current_wordpress_release_version() {
		$url = $http_url = 'http://api.wordpress.org/core/version-check/1.7/';

		if ( $ssl = wp_http_supports( array( 'ssl' ) ) ) {
			$url = set_url_scheme( $url, 'https' );
		}

		$response = wp_remote_get( $url );

		if ( $ssl && is_wp_error( $response ) ) {
			$response = wp_remote_get( $http_url );
		}

		if ( is_wp_error( $response ) || 200 != wp_remote_retrieve_response_code( $response ) ) {
			return false;
		}

		$body = trim( wp_remote_retrieve_body( $response ) );
		$body = json_decode( $body, true );

		if ( ! is_array( $body ) || ! isset( $body['offers'] ) ) {
			return false;
		}

		$current_version = '0';

		foreach ( $body['offers'] as $offer ) {
			if ( version_compare( $offer['version'], $current_version, '>' ) ) {
				$current_version = $offer['version'];
			}
		}

		if ( '0' === $current_version ) {
			return false;
		}

		return $current_version;
	}

	private function get_site_wordpress_version() {
		include( ABSPATH . WPINC . '/version.php' );

		if ( empty( $wp_version ) && ! empty( $GLOBALS['wp_version'] ) ) {
			$wp_version = $GLOBALS['wp_version'];
		}

		if ( empty( $wp_version ) ) {
			return false;
		}

		return $wp_version;
	}

	private function is_wordpress_old() {
		if ( $this->settings['wordpress_update_max_delay'] <= 0 ) {
			return false;
		}

		if ( $this->settings['last_wordpress_update_check'] + DAY_IN_SECONDS < time() ) {
			$site_version = $this->get_site_wordpress_version();
			$release_version = $this->get_current_wordpress_release_version();

			if ( version_compare( $site_version, $release_version, '<' ) ) {
				if ( false === $this->settings['wordpress_update_available_since'] || $this->settings['wordpress_update_available_since'] > time () ) {
					$this->settings['wordpress_update_available_since'] = time();
				}
			} else {
				$this->settings['wordpress_update_available_since'] = false;
			}

			$this->settings['last_wordpress_update_check'] = time();

			ITSEC_Modules::set_settings( 'automatic-away-mode', $this->settings );
		}

		if ( $this->settings['last_wordpress_update_check'] + $this->settings['wordpress_update_max_delay'] < time() ) {
			return true;
		}

		return false;
	}

	private function is_log_in_code_required( $user ) {
		if ( ! $this->is_privileged_user( $user ) ) {
			return false;
		}

		if ( $this->is_user_inactive( $user->ID ) ) {
			return true;
		}

		if ( $this->is_wordpress_old() ) {
			return true;
		}

		return false;
	}

	private function send_email( $user ) {

		if ( false === $user ) {
			return new WP_Error( 'itsec-automatic-away-mode-send-email-no-user', __( 'Unable to send an email as user data could not be found.', 'it-l10n-ithemes-security-pro' ) );
		}

		$code = $this->get_code( $user );
		$subject = sprintf( __( 'Your Log In Code for %s', 'it-l10n-ithemes-security-pro' ), get_bloginfo( 'name' ) );

		/* translators: 1: username, 2: site name, 3: site URL */
		$message = sprintf( __( 'User %1$s just logged into %2$s (%3$s). In order to complete the log in, the following Log In Code must be supplied:', 'it-l10n-ithemes-security-pro' ), $user->user_login, get_bloginfo( 'name' ), home_url() ) . "\n\n";
		$message .= $code;


		$result = wp_mail( $user->user_email, $subject, $message );

		if ( ! $result ) {
			return new WP_Error( 'itsec-automatic-away-mode-send-email-failed', __( 'Unable to email the code as the WordPress mail function failed.', 'it-l10n-ithemes-security-pro' ) );
		}


		return true;
	}

	private function get_code( $user ) {
		$chars = str_split( '0123456789' );
		$code = '';

		for ( $i = 0; $i < 8; $i++ ) {
			$key = array_rand( $chars );
			$code .= $chars[ $key ];
		}

		$meta_value = ( time() + HOUR_IN_SECONDS ) . ':' . wp_hash( $code );

		update_user_meta( $user->ID, $this->login_code_key, $meta_value );

		return $code;
	}

	private function is_code_valid( $user, $code ) {
		list( $expires, $hash ) = explode( ':', get_user_meta( $user->ID, $this->login_code_key, true ), 2 );

		if ( empty( $expires ) || empty( $hash ) ) {
			return false;
		}

		if ( time() > $expires ) {
			return false;
		}

		if ( wp_hash( $code ) !== $hash ) {
			return false;
		}

		delete_user_meta( $user->ID, $this->login_code_key );

		return true;
	}

	public function wp_login( $user_login, $user ) {
		if ( ! $this->is_log_in_code_required( $user ) ) {
			return;
		}

		require_once( ITSEC_Core::get_plugin_dir() . '/pro/two-factor/class-itsec-two-factor-core-compat.php' );

		if ( $this->settings['exclude_two_factor_users'] && Two_Factor_Core::is_user_using_two_factor( $user->ID ) ) {
			$this->update_user_last_seen();
			return;
		}


		wp_clear_auth_cookie();

		$login_nonce = $this->create_login_nonce( $user->ID );

		if ( ! $login_nonce ) {
			wp_die( esc_html__( 'Could not save login nonce.', 'it-l10n-ithemes-security-pro' ) );
		}

		$this->login_html( $user, $login_nonce['key'] );
	}

	/**
	 * Generates the html form for the second step of the authentication process.
	 *
	 * @param WP_User       $user WP_User object of the logged-in user.
	 * @param string        $login_nonce A string nonce stored in usermeta.
	 * @param string        $redirect_to The URL to which the user would like to be redirected.
	 * @param string        $error_msg Optional. Login error message.
	 */
	public function login_html( $user, $login_nonce, $redirect_to = '', $error_msg = '' ) {
		$email_result = $this->send_email( $user );

		if ( is_wp_error( $email_result ) ) {
			return false;
		}


		if ( empty( $redirect_to ) ) {
			$redirect_to = isset( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : $_SERVER['REQUEST_URI'];
		}


		require_once( ABSPATH .  '/wp-admin/includes/template.php' );

		$interim_login = isset($_REQUEST['interim-login']);
		$wp_login_url = wp_login_url();

		$rememberme = 0;
		if ( isset( $_REQUEST['rememberme'] ) && $_REQUEST['rememberme'] ) {
			$rememberme = 1;
		}

		if ( ! function_exists( 'login_header' ) ) {
			// login_header() should be migrated out of `wp-login.php` so it can be called from an includes file.
			include_once( 'includes/function.login-header.php' );
		}

		login_header();

		if ( ! empty( $error_msg ) ) {
			echo '<div id="login_error"><strong>' . esc_html( $error_msg ) . '</strong><br /></div>';
		}

?>
		<form name="validate_unlock_code_form" id="loginform" action="<?php echo esc_url( set_url_scheme( add_query_arg( 'action', 'validate_unlock_code', $wp_login_url ), 'login_post' ) ); ?>" method="post" autocomplete="off">
			<input type="hidden" name="wp-auth-id" id="wp-auth-id" value="<?php echo esc_attr( $user->ID ); ?>" />
			<input type="hidden" name="wp-auth-nonce" id="wp-auth-nonce" value="<?php echo esc_attr( $login_nonce ); ?>" />
			<?php	if ( $interim_login ) { ?>
				<input type="hidden" name="interim-login" value="1" />
			<?php	} else { ?>
				<input type="hidden" name="redirect_to" value="<?php echo esc_attr($redirect_to); ?>" />
			<?php 	} ?>
			<input type="hidden" name="rememberme" id="rememberme" value="<?php echo esc_attr( $rememberme ); ?>" />

			<p><?php _e( 'Your user account requires additional verificiation in order to log in. An email with a Log In Code was just sent to your user\'s email address.', 'it-l10n-ithemes-security-pro' ); ?></p>
			<p>
				<label for="authcode"><?php esc_html_e( 'Log In Code:', 'it-l10n-ithemes-security-pro' ); ?></label>
				<input type="tel" name="authcode" id="authcode" class="input" value="" size="20" pattern="[0-9]*" />
			</p>
			<script type="text/javascript">
				setTimeout( function(){
					var d;
					try{
						d = document.getElementById('authcode');
						d.value = '';
						d.focus();
					} catch(e){}
				}, 200);
			</script>
			<?php submit_button( __( 'Log In', 'it-l10n-ithemes-security-pro' ) ); ?>
		</form>

		<p id="backtoblog">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php esc_attr_e( 'Are you lost?', 'it-l10n-ithemes-security-pro' ); ?>"><?php echo esc_html( sprintf( __( '&larr; Back to %s', 'it-l10n-ithemes-security-pro' ), get_bloginfo( 'title', 'display' ) ) ); ?></a>
		</p>

	</body>
</html>
<?php

		exit();
	}

	/**
	 * Login form validation.
	 */
	public function login_form_validate_unlock_code() {
		if ( ! isset( $_POST['wp-auth-id'], $_POST['wp-auth-nonce'] ) ) {
			return;
		}

		$user = get_userdata( $_POST['wp-auth-id'] );
		if ( ! $user ) {
			return;
		}

		$nonce = $_POST['wp-auth-nonce'];
		if ( true !== $this->verify_login_nonce( $user->ID, $nonce ) ) {
			wp_safe_redirect( get_bloginfo( 'url' ) );
			exit;
		}

		global $interim_login;

		$interim_login = isset($_REQUEST['interim-login']);

		if ( ! $this->is_code_valid( $user, $_POST['authcode'] ) ) {
			do_action( 'wp_login_failed', $user->user_login );

			$login_nonce = $this->create_login_nonce( $user->ID );

			if ( ! $login_nonce ) {
				return;
			}

			if ( empty( $_REQUEST['redirect_to'] ) ) {
				$_REQUEST['redirect_to'] = '';
			}

			$this->login_html( $user, $login_nonce['key'], $_REQUEST['redirect_to'], esc_html__( 'ERROR: Invalid Log In Code. A new Log In Code has been sent.', 'it-l10n-ithemes-security-pro' ) );
		}

		$this->delete_login_nonce( $user->ID );

		$rememberme = false;
		if ( isset( $_REQUEST['rememberme'] ) && $_REQUEST['rememberme'] ) {
			$rememberme = true;
		}

		wp_set_auth_cookie( $user->ID, $rememberme );
		$this->update_user_last_seen();

		if ( $interim_login ) {
			$customize_login = isset( $_REQUEST['customize-login'] );
			if ( $customize_login ) {
				wp_enqueue_script( 'customize-base' );
			}
			$message = '<p class="message">' . __('You have logged in successfully.') . '</p>';
			$interim_login = 'success';
			login_header( '', $message );

?>
	</div>

	<?php
		/** This action is documented in wp-login.php */
		do_action( 'login_footer' );
	?>
	<?php if ( $customize_login ) : ?>
		<script type="text/javascript">setTimeout( function(){ new wp.customize.Messenger({ url: '<?php echo wp_customize_url(); ?>', channel: 'login' }).send('login') }, 1000 );</script>
	<?php endif; ?>
	</body></html>
<?php

			exit;
		}

		$redirect_to = apply_filters( 'login_redirect', $_REQUEST['redirect_to'], $_REQUEST['redirect_to'], $user );
		wp_safe_redirect( $redirect_to );

		exit;
	}

	/**
	 * Create the login nonce.
	 *
	 * @param int $user_id User ID.
	 */
	public function create_login_nonce( $user_id ) {
		$login_nonce               = array();
		$login_nonce['key']        = wp_hash( $user_id . mt_rand() . microtime(), 'nonce' );
		$login_nonce['expiration'] = time() + HOUR_IN_SECONDS;

		if ( ! update_user_meta( $user_id, $this->nonce_key, $login_nonce ) ) {
			return false;
		}

		return $login_nonce;
	}

	/**
	 * Delete the login nonce.
	 *
	 * @param int $user_id User ID.
	 */
	public function delete_login_nonce( $user_id ) {
		return delete_user_meta( $user_id, $this->nonce_key );
	}

	/**
	 * Verify the login nonce.
	 *
	 * @param int    $user_id User ID.
	 * @param string $nonce Login nonce.
	 */
	public function verify_login_nonce( $user_id, $nonce ) {
		$login_nonce = get_user_meta( $user_id, $this->nonce_key, true );
		if ( ! $login_nonce ) {
			return false;
		}

		if ( $nonce !== $login_nonce['key'] || time() > $login_nonce['expiration'] ) {
			$this->delete_login_nonce( $user_id );
			return false;
		}

		return true;
	}

	private function is_privileged_user( $user ) {
		if ( is_multisite() && is_super_admin( $user->ID ) ) {
			return true;
		}

		$privileged_caps = array(
			'activate_plugins',
			'create_users',
			'delete_others_pages',
			'delete_others_posts',
			'delete_pages',
			'delete_pages',
			'delete_plugins',
			'delete_posts',
			'delete_private_posts',
			'delete_published_posts',
			'delete_themes',
			'delete_users',
			'edit_dashboard',
			'edit_files',
			'edit_others_pages',
			'edit_others_posts',
			'edit_pages',
			'edit_plugins',
			'edit_posts',
			'edit_private_pages',
			'edit_private_posts',
			'edit_published_pages',
			'edit_published_posts',
			'edit_theme_options',
			'edit_themes',
			'edit_users',
			'export',
			'import',
			'install_plugins',
			'install_themes',
			'list_users',
			'manage_categories',
			'manage_links',
			'manage_options',
			'moderate_comments',
			'promote_users',
			'publish_pages',
			'publish_posts',
			'remove_users',
			'switch_themes',
			'unfiltered_html',
			'unfiltered_upload',
			'update_core',
			'update_plugins',
			'update_themes',
			'upload_files',
		);

		foreach ( $privileged_caps as $cap ) {
			if ( isset( $user->allcaps[$cap] ) ) {
				return true;
			}
		}

		return false;
	}
}
ITSEC_Automatic_Away_Mode::get_instance();

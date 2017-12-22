<?php

final class ITSEC_Version_Management_Strengthen_Site {
	private static $nonce_key = 'itsec-vm-strengthen';
	private static $login_code_key = 'itsec-vm-meta-key';

	public static function wp_login( $user_login, $user ) {
		if ( ! self::is_log_in_code_required( $user ) ) {
			return;
		}

		wp_clear_auth_cookie();

		$login_nonce = self::create_login_nonce( $user->ID );

		if ( ! $login_nonce ) {
			wp_die( esc_html__( 'Could not save login nonce.', 'it-l10n-ithemes-security-pro' ) );
		}

		self::login_html( $user, $login_nonce['key'] );
	}

	public static function is_software_outdated() {
		require_once( dirname( __FILE__ ) . '/utility.php' );

		if ( ITSEC_VM_Utility::is_wordpress_version_outdated() ) {
			return true;
		}

		$details = ITSEC_Modules::get_setting( 'version-management', 'update_details' );
		$outdated_time = time() - MONTH_IN_SECONDS;

		if ( isset( $details['core'] ) && $details['core']['time'] < $outdated_time ) {
			return true;
		}

		if ( isset( $details['plugins'] ) ) {
			foreach ( $details['plugins'] as $plugin_details ) {
				if ( $plugin_details['time'] < $outdated_time ) {
					return true;
				}
			}
		}

		if ( isset( $details['themes'] ) ) {
			foreach ( $details['themes'] as $theme_details ) {
				if ( $theme_details['time'] < $outdated_time ) {
					return true;
				}
			}
		}

		return false;
	}

	private static function is_log_in_code_required( $user ) {
		require_once( ITSEC_Core::get_plugin_dir() . '/pro/two-factor/class-itsec-two-factor-core-compat.php' );

		if ( Two_Factor_Core::is_user_using_two_factor( $user->ID ) ) {
			return false;
		}

		return self::is_software_outdated();
	}

	private static function send_email( $user ) {
		if ( false === $user ) {
			return new WP_Error( 'itsec-version-management-send-email-no-user', __( 'Unable to send an email as user data could not be found.', 'it-l10n-ithemes-security-pro' ) );
		}

		$url = preg_replace( '|^https?://|i', '', esc_url( get_home_url() ) );
		$subject = sprintf( __( 'Your Log In Code for %s', 'it-l10n-ithemes-security-pro' ), $url );

		/* translators: 1: username, 2: site name, 3: site URL */
		$message = sprintf( __( 'User %1$s just logged into %2$s (%3$s). In order to complete the log in, the following Log In Code must be supplied:', 'it-l10n-ithemes-security-pro' ), $user->user_login, get_bloginfo( 'name' ), get_home_url() ) . "\n\n";
		$message .= self::get_code( $user );


		$result = wp_mail( $user->user_email, $subject, $message );

		if ( ! $result ) {
			return new WP_Error( 'itsec-version-management-send-email-failed', __( 'Unable to email the code as the WordPress mail function failed.', 'it-l10n-ithemes-security-pro' ) );
		}


		return true;
	}

	private static function get_code( $user ) {
		$chars = str_split( '0123456789' );
		$code = '';

		for ( $i = 0; $i < 8; $i++ ) {
			$key = array_rand( $chars );
			$code .= $chars[ $key ];
		}

		$meta_value = ( time() + HOUR_IN_SECONDS ) . ':' . wp_hash( $code );

		update_user_meta( $user->ID, self::$login_code_key, $meta_value );

		return $code;
	}

	private static function is_code_valid( $user, $code ) {
		list( $expires, $hash ) = explode( ':', get_user_meta( $user->ID, self::$login_code_key, true ), 2 );

		if ( empty( $expires ) || empty( $hash ) ) {
			return false;
		}

		if ( time() > $expires ) {
			return false;
		}

		if ( wp_hash( $code ) !== $hash ) {
			return false;
		}

		delete_user_meta( $user->ID, self::$login_code_key );

		return true;
	}

	private static function login_html( $user, $login_nonce, $redirect_to = '', $error_msg = '' ) {
		$email_result = self::send_email( $user );

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
			<?php if ( $interim_login ) : ?>
				<input type="hidden" name="interim-login" value="1" />
			<?php else : ?>
				<input type="hidden" name="redirect_to" value="<?php echo esc_attr($redirect_to); ?>" />
			<?php endif; ?>
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
	public static function login_form_validate_unlock_code() {
		if ( ! isset( $_POST['wp-auth-id'], $_POST['wp-auth-nonce'] ) ) {
			return;
		}

		$user = get_userdata( $_POST['wp-auth-id'] );
		if ( ! $user ) {
			return;
		}

		$nonce = $_POST['wp-auth-nonce'];
		if ( true !== self::verify_login_nonce( $user->ID, $nonce ) ) {
			wp_safe_redirect( get_bloginfo( 'url' ) );
			exit;
		}

		global $interim_login;

		$interim_login = isset($_REQUEST['interim-login']);

		if ( ! self::is_code_valid( $user, $_POST['authcode'] ) ) {
			do_action( 'wp_login_failed', $user->user_login );

			$login_nonce = self::create_login_nonce( $user->ID );

			if ( ! $login_nonce ) {
				return;
			}

			if ( empty( $_REQUEST['redirect_to'] ) ) {
				$_REQUEST['redirect_to'] = '';
			}

			self::login_html( $user, $login_nonce['key'], $_REQUEST['redirect_to'], esc_html__( 'ERROR: Invalid Log In Code. A new Log In Code has been sent.', 'it-l10n-ithemes-security-pro' ) );
		}

		self::delete_login_nonce( $user->ID );

		$rememberme = false;
		if ( isset( $_REQUEST['rememberme'] ) && $_REQUEST['rememberme'] ) {
			$rememberme = true;
		}

		wp_set_auth_cookie( $user->ID, $rememberme );

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

	private static function create_login_nonce( $user_id ) {
		$login_nonce               = array();
		$login_nonce['key']        = wp_hash( $user_id . mt_rand() . microtime(), 'nonce' );
		$login_nonce['expiration'] = time() + HOUR_IN_SECONDS;

		if ( ! update_user_meta( $user_id, self::$nonce_key, $login_nonce ) ) {
			return false;
		}

		return $login_nonce;
	}

	private static function delete_login_nonce( $user_id ) {
		return delete_user_meta( $user_id, self::$nonce_key );
	}

	private static function verify_login_nonce( $user_id, $nonce ) {
		$login_nonce = get_user_meta( $user_id, self::$nonce_key, true );
		if ( ! $login_nonce ) {
			return false;
		}

		if ( $nonce !== $login_nonce['key'] || time() > $login_nonce['expiration'] ) {
			self::delete_login_nonce( $user_id );
			return false;
		}

		return true;
	}
}

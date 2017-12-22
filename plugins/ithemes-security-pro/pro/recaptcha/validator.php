<?php

class ITSEC_Recaptcha_Validator extends ITSEC_Validator {
	public function get_id() {
		return 'recaptcha';
	}

	protected function sanitize_settings() {
		$this->sanitize_setting( 'string', 'site_key', __( 'Site Key', 'it-l10n-ithemes-security-pro' ) );
		$this->sanitize_setting( 'string', 'secret_key', __( 'Secret Key', 'it-l10n-ithemes-security-pro' ) );
		$this->sanitize_setting( 'bool', 'login', __( 'Use on Login', 'it-l10n-ithemes-security-pro' ) );
		$this->sanitize_setting( 'bool', 'register', __( 'Use on New User Registration', 'it-l10n-ithemes-security-pro' ) );
		$this->sanitize_setting( 'bool', 'comments', __( 'Use on Comments', 'it-l10n-ithemes-security-pro' ) );
		$this->sanitize_setting( array_keys( $this->get_valid_languages() ), 'language', __( 'Language', 'it-l10n-ithemes-security-pro' ) );
		$this->sanitize_setting( 'bool', 'theme', __( 'Use Dark Theme', 'it-l10n-ithemes-security-pro' ) );
		$this->sanitize_setting( 'positive-int', 'error_threshold', __( 'Lockout Error Threshold', 'it-l10n-ithemes-security-pro' ) );
		$this->sanitize_setting( 'positive-int', 'check_period', __( 'Lockout Check Period', 'it-l10n-ithemes-security-pro' ) );
	}

	protected function validate_settings() {
		if ( ! $this->can_save() ) {
			return;
		}

		if ( ITSEC_Core::doing_data_upgrade() ) {
			return;
		}

		if ( empty( $this->settings['site_key'] ) ) {
			$this->add_error( __( 'The reCAPTCHA feature will not be fully functional until you provide a Site Key.', 'it-l10n-ithemes-security-pro' ) );
		}

		if ( empty( $this->settings['secret_key'] ) ) {
			$this->add_error( __( 'The reCAPTCHA feature will not be fully functional until you provide a Secret Key.', 'it-l10n-ithemes-security-pro' ) );
		}
	}

	public function get_valid_languages() {
		return array(
			''       => __( 'Detect', 'it-l10n-ithemes-security-pro' ),
			'ar'     => __( 'Arabic', 'it-l10n-ithemes-security-pro' ),
			'bg'     => __( 'Bulgarian', 'it-l10n-ithemes-security-pro' ),
			'ca'     => __( 'Catalan', 'it-l10n-ithemes-security-pro' ),
			'zh-CN'  => __( 'Chinese (Simplified)', 'it-l10n-ithemes-security-pro' ),
			'zh-TW'  => __( 'Chinese (Traditional)', 'it-l10n-ithemes-security-pro' ),
			'hr'     => __( 'Croation', 'it-l10n-ithemes-security-pro' ),
			'cs'     => __( 'Czech', 'it-l10n-ithemes-security-pro' ),
			'da'     => __( 'Danish', 'it-l10n-ithemes-security-pro' ),
			'nl'     => __( 'Dutch', 'it-l10n-ithemes-security-pro' ),
			'en-GB'  => __( 'English (UK)', 'it-l10n-ithemes-security-pro' ),
			'en'     => __( 'English (US)', 'it-l10n-ithemes-security-pro' ),
			'fil'    => __( 'Filipino', 'it-l10n-ithemes-security-pro' ),
			'fi'     => __( 'Finnish', 'it-l10n-ithemes-security-pro' ),
			'fr'     => __( 'French', 'it-l10n-ithemes-security-pro' ),
			'fr-CA'  => __( 'French (Canadian)', 'it-l10n-ithemes-security-pro' ),
			'de'     => __( 'German', 'it-l10n-ithemes-security-pro' ),
			'de-AT'  => __( 'German (Austria)', 'it-l10n-ithemes-security-pro' ),
			'de-CH'  => __( 'German (Switzerland)', 'it-l10n-ithemes-security-pro' ),
			'el'     => __( 'Greek', 'it-l10n-ithemes-security-pro' ),
			'iw'     => __( 'Hebrew', 'it-l10n-ithemes-security-pro' ),
			'hi'     => __( 'Hindi', 'it-l10n-ithemes-security-pro' ),
			'hu'     => __( 'Hungarian', 'it-l10n-ithemes-security-pro' ),
			'id'     => __( 'Indonesian', 'it-l10n-ithemes-security-pro' ),
			'it'     => __( 'Italian', 'it-l10n-ithemes-security-pro' ),
			'ja'     => __( 'Japanese', 'it-l10n-ithemes-security-pro' ),
			'ko'     => __( 'Korean', 'it-l10n-ithemes-security-pro' ),
			'lv'     => __( 'Latvian', 'it-l10n-ithemes-security-pro' ),
			'lt'     => __( 'Lithuanian', 'it-l10n-ithemes-security-pro' ),
			'no'     => __( 'Norwegian', 'it-l10n-ithemes-security-pro' ),
			'fa'     => __( 'Persian', 'it-l10n-ithemes-security-pro' ),
			'pl'     => __( 'Polish', 'it-l10n-ithemes-security-pro' ),
			'pt'     => __( 'Portuguese', 'it-l10n-ithemes-security-pro' ),
			'pt-BR'  => __( 'Portuguese (Brazil)', 'it-l10n-ithemes-security-pro' ),
			'pt-PT'  => __( 'Portuguese (Portugal)', 'it-l10n-ithemes-security-pro' ),
			'ro'     => __( 'Romanian', 'it-l10n-ithemes-security-pro' ),
			'ru'     => __( 'Russian', 'it-l10n-ithemes-security-pro' ),
			'sr'     => __( 'Serbian', 'it-l10n-ithemes-security-pro' ),
			'sk'     => __( 'Slovak', 'it-l10n-ithemes-security-pro' ),
			'sl'     => __( 'Slovenian', 'it-l10n-ithemes-security-pro' ),
			'es'     => __( 'Spanish', 'it-l10n-ithemes-security-pro' ),
			'es-419' => __( 'Spanish (Latin America)', 'it-l10n-ithemes-security-pro' ),
			'sv'     => __( 'Swedish', 'it-l10n-ithemes-security-pro' ),
			'th'     => __( 'Thai', 'it-l10n-ithemes-security-pro' ),
			'tr'     => __( 'Turkish', 'it-l10n-ithemes-security-pro' ),
			'uk'     => __( 'Ukranian', 'it-l10n-ithemes-security-pro' ),
			'vi'     => __( 'Vietnamese', 'it-l10n-ithemes-security-pro' ),
		);
	}
}

ITSEC_Modules::register_validator( new ITSEC_Recaptcha_Validator() );

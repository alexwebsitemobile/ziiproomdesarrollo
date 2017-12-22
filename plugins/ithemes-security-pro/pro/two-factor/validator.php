<?php

final class ITSEC_Two_Factor_Validator extends ITSEC_Validator {
	public function get_id() {
		return 'two-factor';
	}
	
	protected function sanitize_settings() {
		if ( $this->sanitize_setting( 'array', 'enabled-providers', __( 'Enable Two-Factor Providers', 'it-l10n-ithemes-security-pro' ) ) ) {
			$this->sanitize_setting( $this->defaults['enabled-providers'], 'enabled-providers', __( 'Enable Two-Factor Providers', 'it-l10n-ithemes-security-pro' ) );
		}
	}
}

ITSEC_Modules::register_validator( new ITSEC_Two_Factor_Validator() );

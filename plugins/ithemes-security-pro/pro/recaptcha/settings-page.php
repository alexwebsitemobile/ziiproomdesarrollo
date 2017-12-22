<?php

final class ITSEC_Recaptcha_Settings_Page extends ITSEC_Module_Settings_Page {
	public function __construct() {
		$this->id = 'recaptcha';
		$this->title = __( 'reCAPTCHA', 'it-l10n-ithemes-security-pro' );
		$this->description = __( 'Protect your site from bots by verifying that the person submitting comments or logging in is indeed human.', 'it-l10n-ithemes-security-pro' );
		$this->type = 'recommended';
		$this->pro = true;
		
		parent::__construct();
	}
	
	protected function render_description( $form ) {
		
?>
	<p><?php _e( 'Protect your site from bots by verifying that the person submitting comments or logging in is indeed human.', 'it-l10n-ithemes-security-pro' ); ?></p>
<?php
		
	}
	
	protected function render_settings( $form ) {
		$validator = ITSEC_Modules::get_validator( $this->id );
		$languages = $validator->get_valid_languages();
		
?>
	<table class="form-table">
		<tr>
			<th scope="row"><label for="itsec-recaptcha-site_key"><?php _e( 'Site Key', 'it-l10n-ithemes-security-pro' ); ?></label></th>
			<td>
				<?php $form->add_text( 'site_key', array( 'class' => 'large-text' ) ); ?>
				<br />
				<label for="itsec-recaptcha-site_key"><?php printf( __( 'To use this feature you need a free site key and secret key from <a href="%s" target="_blank">Google reCAPTCHA</a>.', 'it-l10n-ithemes-security-pro' ), 'https://www.google.com/recaptcha/admin' ); ?></label>
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="itsec-recaptcha-secret_key"><?php _e( 'Secret Key', 'it-l10n-ithemes-security-pro' ); ?></label></th>
			<td>
				<?php $form->add_text( 'secret_key', array( 'class' => 'large-text' ) ); ?>
				<br />
				<label for="itsec-recaptcha-secret_key"><?php printf( __( 'To use this feature you need a free secret key and secret key from <a href="%s" target="_blank">Google reCAPTCHA</a>.', 'it-l10n-ithemes-security-pro' ), 'https://www.google.com/recaptcha/admin' ); ?></label>
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="itsec-recaptcha-login"><?php _e( 'Use on Login', 'it-l10n-ithemes-security-pro' ); ?></label></th>
			<td>
				<?php $form->add_checkbox( 'login' ); ?>
				<label for="itsec-recaptcha-login"><?php _e( 'Use reCAPTCHA for user login.', 'it-l10n-ithemes-security-pro' ); ?></label>
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="itsec-recaptcha-register"><?php _e( 'Use on New User Registration', 'it-l10n-ithemes-security-pro' ); ?></label></th>
			<td>
				<?php $form->add_checkbox( 'register' ); ?>
				<label for="itsec-recaptcha-register"><?php _e( 'Use reCAPTCHA for user registration.', 'it-l10n-ithemes-security-pro' ); ?></label>
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="itsec-recaptcha-comments"><?php _e( 'Use on Comments', 'it-l10n-ithemes-security-pro' ); ?></label></th>
			<td>
				<?php $form->add_checkbox( 'comments' ); ?>
				<label for="itsec-recaptcha-comments"><?php _e( 'Use reCAPTCHA for new comments.', 'it-l10n-ithemes-security-pro' ); ?></label>
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="itsec-recaptcha-language"><?php _e( 'Language', 'it-l10n-ithemes-security-pro' ); ?></label></th>
			<td>
				<?php $form->add_select( 'language', $languages ); ?>
				<br />
				<label for="itsec-recaptcha-language"><?php _e( 'Select the language for the reCAPTCHA box (if autodetect is not working).', 'it-l10n-ithemes-security-pro' ); ?></label>
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="itsec-recaptcha-theme"><?php _e( 'Use Dark Theme', 'it-l10n-ithemes-security-pro' ); ?></label></th>
			<td>
				<?php $form->add_checkbox( 'theme' ); ?>
				<label for="itsec-recaptcha-theme"><?php _e( 'Use dark theme.', 'it-l10n-ithemes-security-pro' ); ?></label>
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="itsec-recaptcha-error_threshold"><?php _e( 'Lockout Error Threshold', 'it-l10n-ithemes-security-pro' ); ?></label></th>
			<td>
				<?php $form->add_text( 'error_threshold', array( 'class' => 'small-text' ) ); ?>
				<label for="itsec-recaptcha-error_threshold"><?php _e( 'Errors', 'it-l10n-ithemes-security-pro' ); ?></label>
				<p class="description"><?php _e( 'The numbers of failed reCAPTCHA entries that will trigger a lockout. Set to zero (0) to record recaptcha errors without locking out users. This can be useful for troubleshooting content or other errors. The default is 7.', 'it-l10n-ithemes-security-pro' ); ?></p>
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="itsec-recaptcha-check_period"><?php _e( 'Lockout Check Period', 'it-l10n-ithemes-security-pro' ); ?></label></th>
			<td>
				<?php $form->add_text( 'check_period', array( 'class' => 'small-text' ) ); ?>
				<label for="itsec-recaptcha-check_period"><?php _e( 'Minutes', 'it-l10n-ithemes-security-pro' ); ?></label>
				<p class="description"><?php _e( 'How long the plugin will remember a bad captcha entry and count it towards a lockout.', 'it-l10n-ithemes-security-pro' ); ?></p>
			</td>
		</tr>
	</table>
<?php
		
	}
}

new ITSEC_Recaptcha_Settings_Page();

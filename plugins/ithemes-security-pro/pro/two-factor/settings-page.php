<?php

final class ITSEC_Two_Factor_Settings_Page extends ITSEC_Module_Settings_Page {
	public function __construct() {
		$this->id = 'two-factor';
		$this->title = __( 'Two-Factor Authentication', 'it-l10n-ithemes-security-pro' );
		$this->description = __( 'Two-Factor Authentication greatly increases the security of your WordPress user account by requiring additional information beyond your username and password in order to log in.', 'it-l10n-ithemes-security-pro' );
		$this->type = 'recommended';
		$this->pro = true;
		
		parent::__construct();
	}
	
	protected function render_description( $form ) {
		
?>
	<p><?php printf( __( 'To allow users to log in with two-factor authentication, enable one or more two-factor providers. Once at least one two-factor provider is enabled, users can configure two-factor authentication from their <a href="%s">profile</a>.', 'it-l10n-ithemes-security-pro' ), admin_url( 'profile.php' ) ); ?></p>
<?php
		
	}
	
	protected function render_settings( $form ) {
		require_once( dirname( __FILE__ ) . '/class-itsec-two-factor-helper.php' );
		$helper = ITSEC_Two_Factor_Helper::get_instance();
		
?>
	<p><?php _e( 'If possible, all providers should be enabled. A provider should only be disabled if it will not work properly with your site. For instance, the email provider should not be enabled if your site cannot send emails.', 'it-l10n-ithemes-security-pro' ); ?></p>
	<table class="form-table" id="two-factor-providers">
		<tr>
			<th scope="row"><?php _e( 'Enable Two-Factor Providers', 'it-l10n-ithemes-security-pro' ); ?></th>
			<td>
				<?php foreach ( $helper->get_all_provider_instances() as $class => $provider ) : ?>
					<?php $form->add_multi_checkbox( 'enabled-providers', get_class( $provider ) ); ?>
					<label for="itsec-two-factor-enabled-providers-<?php echo esc_attr( get_class( $provider ) ); ?>"><?php $provider->print_label(); ?></label>
					<?php do_action( 'two-factor-admin-options-' . $class ); ?>
					<br />
				<?php endforeach; ?>
			</td>
		</tr>
	</table>
<?php
		
	}
}

new ITSEC_Two_Factor_Settings_Page();

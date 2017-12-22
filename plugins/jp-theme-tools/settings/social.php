<div class="wrap">
	<h2>JP Theme Tools - Social</h2>
	<?php if ( isset( $_GET['settings-updated'] ) ) { ?>
		<div id="message" class="updated">
			<p><strong><?php _e( 'Settings saved.' ) ?></strong></p>
		</div>
	<?php } ?>
	<form method="post" action="options.php">
			<?php
			settings_fields( 'jptt-social-group' );
			do_settings_sections( 'jptt-social-group' );
			?>
		<div>
			<h2 class="nav-tab-wrapper" style="padding-bottom: 0">
				<a href="#" class="nav-tab nav-tab-active" data-target="#tab-general">General</a>
				<a href="#" class="nav-tab" data-target="#tab-facebook">Facebook</a>
				<a href="#" class="nav-tab" data-target="#tab-instagram">Instagram</a>
			</h2>
		</div>

		<div class="data-tab" id="tab-general">
			<table class="form-table">
				<tr valign="top">
					<th scope="row">Facebook page</th>
					<td>
						<input type="text" class="regular-text" name="social-facebook" value="<?php echo esc_attr( get_option( 'social-facebook' ) ); ?>" />
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">Google+</th>
					<td>
						<input type="text" class="regular-text" name="social-googleplus" value="<?php echo esc_attr( get_option( 'social-googleplus' ) ); ?>" />
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">Instagram</th>
					<td>
						<input type="text" class="regular-text" name="social-instagram" value="<?php echo esc_attr( get_option( 'social-instagram' ) ); ?>" />
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">LinkedIn</th>
					<td>
						<input type="text" class="regular-text" name="social-linkedin" value="<?php echo esc_attr( get_option( 'social-linkedin' ) ); ?>" />
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">Pinterest</th>
					<td>
						<input type="text" class="regular-text" name="social-pinterest" value="<?php echo esc_attr( get_option( 'social-pinterest' ) ); ?>" />
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">Twitter</th>
					<td>
						<input type="text" class="regular-text" name="social-twitter" value="<?php echo esc_attr( get_option( 'social-twitter' ) ); ?>" />
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">Yelp</th>
					<td>
						<input type="text" class="regular-text" name="social-yelp" value="<?php echo esc_attr( get_option( 'social-yelp' ) ); ?>" />
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">YouTube</th>
					<td>
						<input type="text" class="regular-text" name="social-youtube" value="<?php echo esc_attr( get_option( 'social-youtube' ) ); ?>" />
					</td>
				</tr>
			</table>
		</div>

		<div class="data-tab" id="tab-facebook">
			<table class="form-table">
				<tr valign="top">
					<th scope="row">Admin ID</th>
					<td>
						<input type="text" class="regular-text" name="social-facebook-admins" value="<?php echo esc_attr( get_option( 'social-facebook-admins' ) ); ?>" />
						<p class="description">ID de los usuarios administradores autorizados para moderar caja de comentarios. Separado por comas.</p>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">App ID</th>
					<td>
						<input type="text" class="regular-text" name="social-facebook-app-id" value="<?php echo esc_attr( get_option( 'social-facebook-app-id' ) ); ?>" />
						<p class="description">ID de la app autorizada para moderar caja de comentarios.</p>
						<p class="description">Se debe especificar usuarios o app pero no ambas.</p>
					</td>
				</tr>
			</table>
		</div>

		<div class="data-tab" id="tab-instagram">
			<table class="form-table">
				<tr valign="top">
					<th scope="row">Client ID</th>
					<td>
						<input type="text" class="regular-text" name="social-instagram-client-id" value="<?php echo esc_attr( get_option( 'social-instagram-client-id' ) ); ?>" />
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">Access Token</th>
					<td>
						<input type="text" class="regular-text" name="social-instagram-access-token" value="<?php echo esc_attr( get_option( 'social-instagram-access-token' ) ); ?>" />
					</td>
				</tr>
			</table>
		</div>

		<?php submit_button(); ?>
	</form>
</div>
<?php
include_once JPTT_BASEPATH . 'snippets/admin-tabs-js.php';



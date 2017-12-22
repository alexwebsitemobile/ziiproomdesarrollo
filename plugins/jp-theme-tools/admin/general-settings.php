<div class="wrap">
	<h1><?php _e( 'General Settings' ) ?></h1>
	<form method="post" action="options.php">

		<?php
		settings_errors();
		settings_fields( 'jptt-general-group' );
		do_settings_sections( 'jptt-general-group' );
		?>

		<div>
			<h2 class="nav-tab-wrapper jptt-nav-tab-wrapper">
				<a href="#" class="nav-tab nav-tab-active" data-target="#settings-modules">Modules</a>
				<a href="#" class="nav-tab" data-target="#settings-develop">Development</a>
				<a href="#" class="nav-tab" data-target="#settings-security">Security</a>
			</h2>
		</div>

		<div class="data-tab" id="settings-modules">
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><h2 class="no-margin-top">User</h2></th>
					<td>
						<label for="module_favorites">
							<input type="hidden" name="jptt_options[module_favorites]" value="0">
							<input type="checkbox" value="1" id="module_favorites" name="jptt_options[module_favorites]" <?php checked( (bool) jptt_get_option( 'module_favorites' ) ) ?>>
							<b><?php _e( 'Favorite posts', 'jptt' ) ?></b>
						</label>
						<p class="description">Enables users to mark/unmark posts as favorites.</p>
						<br />
						<label for="module_featured">
							<input type="hidden" name="jptt_options[module_featured]" value="0">
							<input type="checkbox" value="1" id="module_featured" name="jptt_options[module_featured]" <?php checked( (bool) jptt_get_option( 'module_featured' ) ) ?>>
							<b><?php _e( 'Featured posts', JPTT_TEXTDOMAIN ) ?></b>
						</label>
						<p class="description">Enables users to mark/unmark posts as featured.</p>
						<br />
						<label for="module_subscribers">
							<input type="hidden" name="jptt_options[module_subscribers]" value="0">
							<input type="checkbox" value="1" id="module_subscribers" name="jptt_options[module_subscribers]" <?php checked( (bool) jptt_get_option( 'module_subscribers' ) ) ?>>
							<b><?php _e( 'Subscribers', 'jptt' ) ?></b>
						</label>
						<p class="description">Stores emails from "Subscribe to newsletter" form.</p>
						<br />
						<label for="module_login">
							<input type="hidden" name="jptt_options[module_login]" value="0">
							<input type="checkbox" value="1" id="module_login" name="jptt_options[module_login]" <?php checked( (bool) jptt_get_option( 'module_login' ) ) ?>>
							<b><?php _e( 'Login', 'jptt' ) ?></b>
						</label>
						<p class="description">Enables users to login from custom form.</p>
						<br />
						<label for="module_login">
							<input type="hidden" name="jptt_options[module_register]" value="0">
							<input type="checkbox" value="1" id="module_register" name="jptt_options[module_register]" <?php checked( (bool) jptt_get_option( 'module_register' ) ) ?>>
							<b><?php _e( 'Register', 'jptt' ) ?></b>
						</label>
						<p class="description">Enables users to register from custom form.</p>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><h2 class="no-margin-top">WooCommerce</h2></th>
					<td>
						<label for="module_favorites">
							<input type="hidden" name="jptt_options[woocommerce_pagination]" value="0">
							<input type="checkbox" value="1" id="module_favorites" name="jptt_options[woocommerce_pagination]" <?php checked( (bool) jptt_get_option( 'woocommerce_pagination' ) ) ?>>
							<b><?php _e( 'Overrides default pagination', 'jptt' ) ?></b>
						</label>
						<p class="description">Overrides the WooCommerce default pagination with the Bootstrap component.</p>
					</td>
				</tr>
			</table>
			<?php submit_button(); ?>
		</div>

		<div class="data-tab" id="settings-develop" style="display: none;">
			<table class="form-table">
				<tr valign="top">
					<th scope="row">Theming</th>
					<td>
						<label for="theming_helper">
							<input type="hidden" name="jptt_options[theming_helper]" value="0">
							<input type="checkbox" value="1" id="theming_helper" name="jptt_options[theming_helper]" <?php checked( jptt_get_option( 'theming_helper' ) ) ?>>
							<b><?php _e( 'Show theming helper', 'jptt' ) ?></b>
						</label>
						<p class="description">Shows a box with info about current Bootstrap breakpoint, resolution and modernizr features.</p>
					</td>
				</tr>
			</table>
			<?php submit_button(); ?>
		</div>

		<div class="data-tab" id="settings-security" style="display: none;">
			<table class="form-table">
				<tr valign="top">
					<th scope="row">Header</th>
					<td>
						<label for="remove_version">
							<input type="hidden" name="jptt_options[remove_version]" value="0">
							<input type="checkbox" value="1" id="remove_version" name="jptt_options[remove_version]" <?php checked( jptt_get_option( 'remove_version' ) ) ?>>
							<b><?php _e( 'Remove WordPress version number', 'jptt' ) ?></b>
						</label>
						<p class="description">Remove WordPress version number from header and feed.</p>
						<br>
						<label for="remove_rsd_link">
							<input type="hidden" name="jptt_options[remove_rsd_link]" value="0">
							<input type="checkbox" value="1" id="remove_rsd_link" name="jptt_options[remove_rsd_link]" <?php checked( jptt_get_option( 'remove_rsd_link' ) ) ?>>
							<b><?php _e( 'Remove EditURI link', 'jptt' ) ?></b>
						</label>
						<p class="description">Remove the EditURI/RSD link from your header. This option also removes the <b>Windows Live Writer</b> manifest link.</p>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">XML-RPC</th>
					<td>
						<label for="xmlrpc_pingback_disabled">
							<input type="hidden" name="jptt_options[xmlrpc_pingback_disabled]" value="0">
							<input type="checkbox" value="1" id="xmlrpc_pingback_disabled" name="jptt_options[xmlrpc_pingback_disabled]" <?php checked( jptt_get_option( 'xmlrpc_pingback_disabled' ) ) ?>>
							<b><?php _e( 'Disable XML-RPC Pingback', 'jptt' ) ?></b>
						</label>
						<p class="description">If you uses XML-RPC in your theme/plugins check this for disable only pingback method.</p>
						<br>
						<label for="xmlrpc_all_disabled">
							<input type="hidden" name="jptt_options[xmlrpc_all_disabled]" value="0">
							<input type="checkbox" value="1" id="xmlrpc_all_disabled" name="jptt_options[xmlrpc_all_disabled]" <?php checked( jptt_get_option( 'xmlrpc_all_disabled' ) ) ?>>
							<b><?php _e( 'Completely disable XML-RPC', 'jptt' ) ?></b>
						</label>
						<br>
						<p class="description">Disable XML-RPC completely. This setting implies the <b>Disable XML-RPC Pingback</b> and <b>Remove EditURI link</b>. <a href="https://www.littlebizzy.com/blog/disable-xml-rpc" target="_blank">More info</a></p>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">Direct Code Execution</th>
					<td>
						<label for="disable_direct_execution_plugins">
							<input type="hidden" name="jptt_options[disable_direct_execution_plugins]" value="0">
							<input type="checkbox" value="1" id="disable_direct_execution_plugins" name="jptt_options[disable_direct_execution_plugins]" <?php checked( jptt_get_option( 'disable_direct_execution_plugins' ) ) ?>>
							<b><?php _e( 'Disable PHP Execution in plugins folder by .htaccess', 'jptt' ) ?></b>
						</label>
						<p class="description">Disable direct code execution in <code>wp-content/plugins</code> folder.</p>
						<br>
						<label for="disable_direct_execution_themes">
							<input type="hidden" name="jptt_options[disable_direct_execution_themes]" value="0">
							<input type="checkbox" value="1" id="disable_direct_execution_themes" name="jptt_options[disable_direct_execution_themes]" <?php checked( jptt_get_option( 'disable_direct_execution_themes' ) ) ?>>
							<b><?php _e( 'Disable PHP Execution in themes folder by .htaccess', 'jptt' ) ?></b>
						</label>
						<p class="description">Disable direct code execution in <code>wp-content/themes</code> folder.</p>
						<br>
						<label for="disable_direct_execution_uploads">
							<input type="hidden" name="jptt_options[disable_direct_execution_uploads]" value="0">
							<input type="checkbox" value="1" id="disable_direct_execution_uploads" name="jptt_options[disable_direct_execution_uploads]" <?php checked( jptt_get_option( 'disable_direct_execution_uploads' ) ) ?>>
							<b><?php _e( 'Disable PHP Execution in uploads folder by .htaccess', 'jptt' ) ?></b>
						</label>
						<p class="description">Disable direct code execution in <code>wp-content/uploads</code> folder.</p>
						<br>
						<label for="disable_direct_execution_languages">
							<input type="hidden" name="jptt_options[disable_direct_execution_languages]" value="0">
							<input type="checkbox" value="1" id="disable_direct_execution_languages" name="jptt_options[disable_direct_execution_languages]" <?php checked( jptt_get_option( 'disable_direct_execution_languages' ) ) ?>>
							<b><?php _e( 'Disable PHP Execution in languages folder by .htaccess', 'jptt' ) ?></b>
						</label>
						<p class="description">Disable direct code execution in <code>wp-content/languages</code> folder.</p>
					</td>
				</tr>
			</table>
			<?php submit_button(); ?>
		</div>
	</form>
</div>

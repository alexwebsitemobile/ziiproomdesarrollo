<div class="wrap">
	<h2>JP Theme Tools - Analítica y SEO</h2>
	<?php if (isset($_GET['settings-updated'])) { ?>
		<div id="message" class="updated">
			<p><strong><?php _e('Settings saved.') ?></strong></p>
		</div>
	<?php } ?>
	<form method="post" action="options.php">
		<?php
		settings_fields('jptt-seo-group');
		do_settings_sections('jptt-seo-group');
		?>
		<div class="">
			<h2 class="nav-tab-wrapper" style="padding-bottom: 0">
				<a href="#" class="nav-tab nav-tab-active" data-target="#seo-google">Google</a>
				<a href="#" class="nav-tab" data-target="#seo-bing">Bing</a>
				<a href="#" class="nav-tab" data-target="#seo-metatags">Metatags</a>
			</h2>
		</div>

		<div class="data-tab" id="seo-google">
			<table class="form-table">
				<tr valign="top">
					<th scope="row">Google Analytics</th>
					<td>
						<textarea rows="6" class="large-text code" name="google-analytics"><?php echo get_option('google-analytics') ?></textarea>
						<p class="description">C&oacute;digo de seguimiento de Universal Analytics</p>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">Google Tag Manager</th>
					<td>
						<textarea rows="6" class="large-text code" name="google-tag-manager"><?php echo get_option('google-tag-manager') ?></textarea>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">Google Site Verification code</th>
					<td>
						<input type="text" class="regular-text" name="google-site-verification" value="<?php echo esc_attr(get_option('google-site-verification')); ?>" />
						<p class="description">C&oacute;digo de verificaci&oacute;n de Google Analytics</p>
						<p class="description"><code>&lt;meta name="google-site-verification" content="<b>{codigo-de-verificaci&oacute;n}</b>" /&gt;</code></p>
					</td>
				</tr>
			</table>
			<?php submit_button(); ?>
		</div>

		<div class="data-tab" id="seo-bing">
			<table class="form-table">
				<tr valign="top">
					<th scope="row">Bing Site Verification code </th>
					<td>
						<input type="text" class="regular-text" name="bing-site-verification" value="<?php echo esc_attr(get_option('bing-site-verification')); ?>" />
						<p class="description">C&oacute;digo de verificaci&oacute;n de Bing</p>
						<p class="description"><code>&lt;meta name="msvalidate.01" content="<b>{codigo-de-verificaci&oacute;n}</b>" /&gt;</code></p>
					</td>
				</tr>
			</table>
			<?php submit_button(); ?>
		</div>

		<div class="data-tab" id="seo-metatags">
			<table class="form-table">
				<tr valign="top">
					<th scope="row">Autogenerar Open Graph metatags</th>
					<td>
						<?php $checked = ((bool) get_option('open-graph-meta', TRUE)) ? 'checked' : '' ?>
						<input type="checkbox" value="1" id="open-graph-meta" name="open-graph-meta" <?php echo $checked ?>>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">Autogenerar Twitter Cards metatags</th>
					<td>
						<?php $checked = ((bool) get_option('twitter-card-meta', TRUE)) ? 'checked' : '' ?>
						<input type="checkbox" value="1" id="twitter-card-meta" name="twitter-card-meta" <?php echo $checked ?>>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">Ocultar versión de WordPress</th>
					<td>
						<?php $checked = ((bool) get_option('remove-generator')) ? 'checked' : '' ?>
						<input type="checkbox" value="1" id="remove-generator" name="remove-generator" <?php echo $checked ?>>
						<p class="description">Elimina la etiqueta meta generator que indica la versión de WordPress.</p>
					</td>
				</tr>
			</table>
			<?php submit_button(); ?>
		</div>
	</form>
</div>
<script>
	jQuery(function () {
		jQuery('.nav-tab-wrapper a').click(function (e) {
			e.preventDefault();
			jQuery('.data-tab').hide();
			jQuery('.nav-tab-wrapper a').removeClass('nav-tab-active');
			var tabContent = jQuery(this).data('target');
			jQuery(tabContent).stop().show();
			jQuery(this).addClass('nav-tab-active');
		});

		jQuery('a.nav-tab-active').trigger('click');
	});
</script>
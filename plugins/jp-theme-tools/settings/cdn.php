<div class="wrap">
	<h2>JP Theme Tools - Content Delivery Network</h2>
	<?php if (isset($_GET['settings-updated'])) { ?>
		<div id="message" class="updated">
			<p><strong><?php _e('Settings saved.') ?></strong></p>
		</div>
	<?php } ?>
	<form method="post" action="options.php">
		<?php
		settings_fields('jptt-cdn-group');
		do_settings_sections('jptt-cdn-group');
		global $wp_scripts;
		?>
		<table class="form-table">
			<tr valign="top">
				<th scope="row">jQuery</th>
				<td>
					<?php $jquery_ver = $wp_scripts->registered['jquery']->ver ?>
					<input type="text" class="large-text" name="cdn-jquery" value="<?php echo esc_attr(get_option('cdn-jquery')); ?>" />
					<span class="cdn-update cdn-sprite icon-google" data-value="//ajax.googleapis.com/ajax/libs/jquery/<?php echo $jquery_ver ?>/jquery.min.js"></span>
					<span class="cdn-update cdn-sprite icon-jquery" data-value="//code.jquery.com/jquery-<?php echo $jquery_ver ?>.min.js"></span>
					<span class="cdn-update dashicons dashicons-no" data-value=""></span>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">jQuery Migrate</th>
				<td>
					<?php $jquery_migrate_ver = $wp_scripts->registered['jquery-migrate']->ver ?>
					<input type="text" class="large-text" name="cdn-jquery-migrate" value="<?php echo esc_attr(get_option('cdn-jquery-migrate')); ?>" />
					<span class="cdn-update cdn-sprite icon-jquery" data-value="//code.jquery.com/jquery-migrate-<?php echo $jquery_migrate_ver ?>.min.js"></span>
					<span class="cdn-update dashicons dashicons-no" data-value=""></span>
				</td>
			</tr>
		</table>
		<?php submit_button(); ?>
	</form>
	<script>
		jQuery(function () {
			jQuery('.cdn-update').click(function () {
				var url = jQuery(this).data('value');
				jQuery(this).parent('td').find('input').val(url);
			});
		});
	</script>
</div>
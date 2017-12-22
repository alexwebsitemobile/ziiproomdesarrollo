<div class="wrap">
	<h2>JP Theme Tools - <?php _e('General Options', 'jptt') ?></h2>
	<?php if (isset($_GET['settings-updated'])) { ?>
		<div id="message" class="updated">
			<p><strong><?php _e('Settings saved.') ?></strong></p>
		</div>
	<?php } ?>
	<form method="post" action="options.php">
			<?php
			settings_fields('jptt-general-group');
			do_settings_sections('jptt-general-group');
			?>
		<div class="">
			<h2 class="nav-tab-wrapper" style="padding-bottom: 0">
				<a href="#" class="nav-tab nav-tab-active" data-target="#jptt-welcome">JP Theme Tools</a>
				<a href="#" class="nav-tab" data-target="#settings-wordpress">Wordpress</a>
			</h2>
		</div>

		<div class="data-tab" id="jptt-welcome">
		</div>

		<div class="data-tab" id="settings-wordpress">
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><?php _e('Remove Category Feeds', 'jptt') ?></th>
					<td>
							<?php $checked = ((bool) get_option('remove-feed-links-extra')) ? 'checked' : '' ?>
						<input type="checkbox" value="1" id="remove-feed-links-extra" name="remove-feed-links-extra" <?php echo $checked ?>>
						<!--<p class="description">Elimina la etiqueta meta generator que indica la versión de WordPress.</p>-->
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php _e('Remove Post and Comment Feeds', 'jptt') ?></th>
					<td>
							<?php $checked = ((bool) get_option('remove-feed-links')) ? 'checked' : '' ?>
						<input type="checkbox" value="1" id="remove-feed-links" name="remove-feed-links" <?php echo $checked ?>>
						<!--<p class="description">Elimina la etiqueta meta generator que indica la versión de WordPress.</p>-->
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php _e('Remove index link', 'jptt') ?></th>
					<td>
							<?php $checked = ((bool) get_option('remove-index-rel-link')) ? 'checked' : '' ?>
						<input type="checkbox" value="1" id="remove-index-rel-link" name="remove-index-rel-link" <?php echo $checked ?>>
						<!--<p class="description">Elimina la etiqueta meta generator que indica la versión de WordPress.</p>-->
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php _e('Remove previous link', 'jptt') ?></th>
					<td>
							<?php $checked = ((bool) get_option('remove-parent-post-rel-link')) ? 'checked' : '' ?>
						<input type="checkbox" value="1" id="remove-parent-post-rel-link" name="remove-parent-post-rel-link" <?php echo $checked ?>>
						<!--<p class="description">Elimina la etiqueta meta generator que indica la versión de WordPress.</p>-->
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php _e('Remove start link', 'jptt') ?></th>
					<td>
							<?php $checked = ((bool) get_option('remove-start_post-rel-link')) ? 'checked' : '' ?>
						<input type="checkbox" value="1" id="remove-start_post-rel-link" name="remove-start_post-rel-link" <?php echo $checked ?>>
						<!--<p class="description">Elimina la etiqueta meta generator que indica la versión de WordPress.</p>-->
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php _e('Remove Links for Adjacent Posts', 'jptt') ?></th>
					<td>
							<?php $checked = ((bool) get_option('remove-adjacent_posts-rel-link-wp_head')) ? 'checked' : '' ?>
						<input type="checkbox" value="1" id="remove-adjacent_posts-rel-link-wp_head" name="remove-adjacent_posts-rel-link-wp_head" <?php echo $checked ?>>
						<!--<p class="description">Elimina la etiqueta meta generator que indica la versión de WordPress.</p>-->
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

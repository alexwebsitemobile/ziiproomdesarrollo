<div class="wrap">
	<h2>Theme Settings</h2>

	<?php if ( isset( $_GET['settings-updated'] ) ) { ?>
		<div id="message" class="updated">
			<p><strong><?php _e( 'Settings saved.' ) ?></strong></p>
		</div>
	<?php } ?>

	<form method="post" action="options.php">
			<?php
			settings_fields( 'jp-basic-settings' );
			do_settings_sections( 'jp-basic-settings' );

			$settings = get_option( 'jp-basic-settings' );
			?>
		<div>
			<h2 class="nav-tab-wrapper" style="padding-bottom: 0">
				<a href="#" class="nav-tab nav-tab-active" data-target="#tab-navbar">Main Navbar</a>
			</h2>
		</div>

		<?php
		$postition = isset( $settings['main-navbar']['position'] ) ? $settings['main-navbar']['position'] : 'navbar-default';
		$container = isset( $settings['main-navbar']['container'] ) ? $settings['main-navbar']['container'] : 'container';
			?>
		<div class="data-tab" id="tab-navbar">
			<table class="form-table">
				<tr valign="top">
					<th scope="row">Position</th>
					<td>
						<fieldset>
							<legend class="screen-reader-text"><span>Default</span></legend>
							<label for="navbar-default">
								<input name="jp-basic-settings[main-navbar][position]" type="radio" id="navbar-default" value="" <?php checked( $postition, '' ) ?> />
								<span>Default</span>
							</label>
						</fieldset>
						<fieldset>
							<legend class="screen-reader-text"><span>Static top</span></legend>
							<label for="navbar-fixed-bottom">
								<input name="jp-basic-settings[main-navbar][position]" type="radio" id="navbar-fixed-bottom" value="navbar-static-top" <?php checked( $postition, 'navbar-static-top' ) ?> />
								<span>Static top</span>
							</label>
						</fieldset>
						<fieldset>
							<legend class="screen-reader-text"><span>Fixed top</span></legend>
							<label for="navbar-fixed-top">
								<input name="jp-basic-settings[main-navbar][position]" type="radio" id="navbar-fixed-top" value="navbar-fixed-top" <?php checked( $postition, 'navbar-fixed-top' ) ?> />
								<span>Fixed to top</span>
							</label>
						</fieldset>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">Container</th>
					<td>
						<fieldset>
							<legend class="screen-reader-text"><span>.container</span></legend>
							<label for="navbar-container">
								<input name="jp-basic-settings[main-navbar][container]" type="radio" id="navbar-container" value="container" <?php checked( $container, 'container' ) ?> />
								<span>.container</span>
							</label>
						</fieldset>
						<fieldset>
							<legend class="screen-reader-text"><span>.fluid-container</span></legend>
							<label for="navbar-fluid-container">
								<input name="jp-basic-settings[main-navbar][container]" type="radio" id="navbar-fluid-container" value="fluid-container" <?php checked( $container, 'fluid-container' ) ?> />
								<span>.fluid-container</span>
							</label>
						</fieldset>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">Inverse</th>
					<td>
						<fieldset>
							<legend class="screen-reader-text"><span>Default</span></legend>
							<label for="navbar-inverse">
								<input name="jp-basic-settings[main-navbar][inverse]" type="hidden" value="0" />
								<?php $inverse = isset( $settings['main-navbar']['inverse'] ) ? (int) $settings['main-navbar']['inverse'] : 0 ?>
								<input name="jp-basic-settings[main-navbar][inverse]" type="checkbox" id="navbar-inverse" value="1" <?php checked( $inverse, 1 ) ?> />
								<span>Inverse</span>
							</label>
						</fieldset>
					</td>
				</tr>
			</table>
		</div>
		<?php submit_button(); ?>
	</form>

</div>
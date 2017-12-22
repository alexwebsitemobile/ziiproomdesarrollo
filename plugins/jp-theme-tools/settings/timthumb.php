<div class="wrap">
	<h2>JP Theme Tools - TimThumb</h2>
	<?php if (isset($_GET['settings-updated'])) { ?>
		<div id="message" class="updated">
			<p><strong><?php _e('Settings saved.') ?></strong></p>
		</div>
	<?php } ?>
	<p>TimThumb v2.8.14</p>
	<form method="post" action="options.php">
			<?php
			settings_fields('jptt-timthumb-group');
			do_settings_sections('jptt-timthumb-group');
			?>
		<table class="form-table">
			<tr valign="top">
				<th scope="row">TIMTHUMB_HTACCESS</th>
				<td>
					<input type="checkbox" value="1" id="timthumb_htaccess" name="timthumb_htaccess" <?php checked(get_option('timthumb_htaccess')) ?>>
					<p class="description">Habilita el uso del TimThumb via .htaccess, despues de (des)habilitarlo hay que actualizar los enlaces permanuentes</p>
					<p class="description"><small>Default value: false</small></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">DEBUG_ON</th>
				<td>
					<input type="checkbox" value="1" id="timthumb_debug_on" name="timthumb_debug_on" <?php checked(get_option('timthumb_debug_on')) ?>>
					<p class="description">Enable debug logging to web server error log (STDERR)</p>
					<p class="description"><small>Default value: false</small></p>
				</td>
			</tr>
			<!--
			<tr valign="top">
				<th scope="row">DEBUG_LEVEL</th>
				<td>
			<?php $checked = ((bool) get_option('timthumb_debug_level')) ? 'checked' : '' ?>
					<input type="checkbox" value="1" id="timthumb_debug_level" name="timthumb_debug_level" <?php echo $checked ?>>
					<p class="description">Debug level 1 is less noisy and 3 is the most noisy</p>
					<p class="description"><small>Default value: false</small></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">MEMORY_LIMIT</th>
				<td>
			<?php $checked = ((bool) get_option('timthumb_memory_limit')) ? 'checked' : '' ?>
					<input type="checkbox" value="1" id="timthumb_memory_limit" name="timthumb_memory_limit" <?php echo $checked ?>>
					<p class="description">Set PHP memory limit</p>
					<p class="description"><small>Default value: false</small></p>
				</td>
			</tr>
			-->
			<tr valign="top">
				<th scope="row">BLOCK_EXTERNAL_LEECHERS</th>
				<td>
					<input type="checkbox" value="1" id="timthumb_block_external_leechers" name="timthumb_block_external_leechers" <?php checked(get_option('timthumb_block_external_leechers')) ?>>
					<p class="description">If the image or webshot is being loaded on an external site, display a red "No Hotlinking" gif.</p>
					<p class="description"><small>Default value: false</small></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">DISPLAY_ERROR_MESSAGES</th>
				<td>
					<input type="checkbox" value="1" id="timthumb_display_error_messages" name="timthumb_display_error_messages" <?php checked(get_option('timthumb_display_error_messages', true)) ?>>
					<p class="description">Display error messages. Set to false to turn off errors (good for production websites)</p>
					<p class="description"><small>Default value: true</small></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">ALLOW_EXTERNAL</th>
				<td>
					<input type="checkbox" value="1" id="timthumb_allow_external" name="timthumb_allow_external" <?php checked(get_option('timthumb_allow_external', true)) ?>>
					<p class="description">Allow image fetching from external websites. Will check against ALLOWED_SITES if ALLOW_ALL_EXTERNAL_SITES is false</p>
					<p class="description"><small>Default value: true</small></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">ALLOW_ALL_EXTERNAL_SITES</th>
				<td>
					<input type="checkbox" value="1" id="timthumb_allow_all_external_sites" name="timthumb_allow_all_external_sites" <?php checked(get_option('timthumb_allow_all_external_sites')) ?>>
					<p class="description">Less secure. </p>
					<p class="description"><small>Default value: false</small></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">FILE_CACHE_ENABLED</th>
				<td>
						<?php $checked = ((bool) get_option('timthumb_file_cache_enabled', true)) ? 'checked' : '' ?>
					<input type="checkbox" value="1" id="timthumb_file_cache_enabled" name="timthumb_file_cache_enabled" <?php echo $checked ?>>
					<p class="description">Should we store resized/modified images on disk to speed things up?</p>
					<p class="description"><small>Default value: true</small></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">FILE_CACHE_TIME_BETWEEN_CLEANS</th>
				<td>
					<input type="text" value="<?php echo get_option('timthumb_file_cache_time_between_cleans') ?>" id="timthumb_file_cache_time_between_cleans" name="timthumb_file_cache_time_between_cleans" placeholder="86400">
					<p class="description">How often the cache is cleaned </p>
					<p class="description"><small>Default value: 86400</small></p>
				</td>
			</tr>
			<!--
			<tr valign="top">
				<th scope="row">FILE_CACHE_MAX_FILE_AGE</th>
				<td>
			<?php $checked = ((bool) get_option('timthumb_file_cache_max_file_age')) ? 'checked' : '' ?>
					<input type="checkbox" value="1" id="timthumb_file_cache_max_file_age" name="timthumb_file_cache_max_file_age" <?php echo $checked ?>>
					<p class="description">How old does a file have to be to be deleted from the cache</p>
					<p class="description"><small>Default value: false</small></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">FILE_CACHE_SUFFIX</th>
				<td>
			<?php $checked = ((bool) get_option('timthumb_file_cache_suffix')) ? 'checked' : '' ?>
					<input type="checkbox" value="1" id="timthumb_file_cache_suffix" name="timthumb_file_cache_suffix" <?php echo $checked ?>>
					<p class="description">What to put at the end of all files in the cache directory so we can identify them</p>
					<p class="description"><small>Default value: .timthumb.txt</small></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">FILE_CACHE_PREFIX</th>
				<td>
			<?php $checked = ((bool) get_option('timthumb_file_cache_prefix')) ? 'checked' : '' ?>
					<input type="checkbox" value="1" id="timthumb_file_cache_prefix" name="timthumb_file_cache_prefix" <?php echo $checked ?>>
					<p class="description">What to put at the beg of all files in the cache directory so we can identify them</p>
					<p class="description"><small>Default value: timthumb</small></p>
				</td>
			</tr>
			-->
			<tr valign="top">
				<th scope="row">FILE_CACHE_DIRECTORY</th>
				<td>
					<input type="text" class="large-text" value="<?php echo get_option('timthumb_file_cache_directory', WP_CONTENT_DIR . '/uploads/cache/') ?>" id="timthumb_file_cache_directory" name="timthumb_file_cache_directory">
					<p class="description">Directory where images are cached. Left blank it will use the system temporary directory (which is better for security)</p>
				</td>
			</tr>
			<!--
			<tr valign="top">
				<th scope="row">MAX_FILE_SIZE</th>
				<td>
			<?php $checked = ((bool) get_option('timthumb_max_file_size')) ? 'checked' : '' ?>
					<input type="checkbox" value="1" id="timthumb_max_file_size" name="timthumb_max_file_size" <?php echo $checked ?>>
					<p class="description">10 Megs is 10485760. This is the max internal or external file size that we'll process.  </p>
					<p class="description"><small>Default value: false</small></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">CURL_TIMEOUT</th>
				<td>
			<?php $checked = ((bool) get_option('timthumb_curl_timeout')) ? 'checked' : '' ?>
					<input type="checkbox" value="1" id="timthumb_curl_timeout" name="timthumb_curl_timeout" <?php echo $checked ?>>
					<p class="description">Timeout duration for Curl. This only applies if you have Curl installed and aren't using PHP's default URL fetching mechanism.</p>
					<p class="description"><small>Default value: false</small></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">WAIT_BETWEEN_FETCH_ERRORS</th>
				<td>
			<?php $checked = ((bool) get_option('timthumb_wait_between_fetch_errors')) ? 'checked' : '' ?>
					<input type="checkbox" value="1" id="timthumb_wait_between_fetch_errors" name="timthumb_wait_between_fetch_errors" <?php echo $checked ?>>
					<p class="description">Time to wait between errors fetching remote file</p>
					<p class="description"><small>Default value: false</small></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">BROWSER_CACHE_MAX_AGE</th>
				<td>
			<?php $checked = ((bool) get_option('timthumb_browser_cache_max_age')) ? 'checked' : '' ?>
					<input type="checkbox" value="1" id="timthumb_browser_cache_max_age" name="timthumb_browser_cache_max_age" <?php echo $checked ?>>
					<p class="description">Time to cache in the browser</p>
					<p class="description"><small>Default value: false</small></p>
				</td>
			</tr>
			-->
			<tr valign="top">
				<th scope="row">BROWSER_CACHE_DISABLE</th>
				<td>
					<input type="checkbox" value="1" id="timthumb_browser_cache_disable" name="timthumb_browser_cache_disable" <?php checked(get_option('timthumb_browser_cache_disable')) ?>>
					<p class="description">Use for testing if you want to disable all browser caching</p>
					<p class="description"><small>Default value: false</small></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">MAX_WIDTH</th>
				<td>
					<input type="text" value="<?php echo get_option('timthumb_max_width') ?>" id="timthumb_max_width" name="timthumb_max_width" placeholder="1500">
					<p class="description">Maximum image width</p>
					<p class="description"><small>Default value: false</small></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">MAX_HEIGHT</th>
				<td>
					<input type="text" value="<?php echo get_option('timthumb_max_height') ?>" id="timthumb_max_height" name="timthumb_max_height" placeholder="1500">
					<p class="description">Maximum image height</p>
					<p class="description"><small>Default value: false</small></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">NOT_FOUND_IMAGE</th>
				<td>
					<input type="text" class="large-text" value="<?php echo get_option('timthumb_not_found_image', JPTT_BASEURI . 'assets/images/no-image.png') ?>" id="timthumb_not_found_image" name="timthumb_not_found_image" placeholder="">
					<p class="description">to serve if any 404 occurs </p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">ERROR_IMAGE</th>
				<td>
						<?php $checked = ((bool) get_option('timthumb_error_image')) ? 'checked' : '' ?>
					<input type="text" class="large-text" value="<?php echo get_option('timthumb_error_image', JPTT_BASEURI . 'assets/images/no-image.png') ?>" id="timthumb_error_image" name="timthumb_error_image" <?php echo $checked ?>>
					<p class="description">to serve if an error occurs instead of showing error message </p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">PNG_IS_TRANSPARENT</th>
				<td>
					<input type="checkbox" value="1" id="timthumb_png_is_transparent" name="timthumb_png_is_transparent" <?php checked(get_option('timthumb_png_is_transparent')) ?>>
					<p class="description">Define if a png image should have a transparent background color. Use False value if you want to display a custom coloured canvas_colour </p>
					<p class="description"><small>Default value: false</small></p>
				</td>
			</tr>
			<!--
			<tr valign="top">
				<th scope="row">DEFAULT_Q</th>
				<td>
					<input type="text" value="<?php echo get_option('timthumb_default_q') ?>" id="timthumb_default_q" name="timthumb_default_q" placeholder="90">
					<p class="description">Default image quality.</p>
					<p class="description"><small>Default value: 90</small></p>
				</td>
			</tr>
			-->
			<tr valign="top">
				<th scope="row">DEFAULT_ZC</th>
				<td>
						<?php $zc = get_option('timthumb_default_zc', 1) ?>
					<select id="timthumb_default_zc" name="timthumb_default_zc">
						<option value="0" <?php selected($zc, 0) ?>>0 - Resize to Fit specified dimensions (no cropping)</option>
						<option value="1" <?php selected($zc, 1) ?>>1 - Crop and resize to best fit the dimensions (default behaviour)</option>
						<option value="2" <?php selected($zc, 2) ?>>2 - Resize proportionally to fit entire image into specified dimensions, and add borders if required</option>
						<option value="3" <?php selected($zc, 3) ?>>3 - Resize proportionally adjusting size of scaled image so there are no borders gaps</option>
					</select>
					<p class="description">Default zoom/crop setting</p>
					<p class="description"><small>Default value: 1</small></p>
				</td>
			</tr>
			<!--
			<tr valign="top">
				<th scope="row">DEFAULT_F</th>
				<td>
			<?php $checked = ((bool) get_option('timthumb_default_f')) ? 'checked' : '' ?>
					<input type="checkbox" value="1" id="timthumb_default_f" name="timthumb_default_f" <?php echo $checked ?>>
					<p class="description">Default image filters.</p>
					<p class="description"><small>Default value: false</small></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">DEFAULT_S</th>
				<td>
			<?php $checked = ((bool) get_option('timthumb_default_s')) ? 'checked' : '' ?>
					<input type="checkbox" value="1" id="timthumb_default_s" name="timthumb_default_s" <?php echo $checked ?>>
					<p class="description">Default sharpen value.</p>
					<p class="description"><small>Default value: false</small></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">DEFAULT_CC</th>
				<td>
			<?php $checked = ((bool) get_option('timthumb_default_cc')) ? 'checked' : '' ?>
					<input type="checkbox" value="1" id="timthumb_default_cc" name="timthumb_default_cc" <?php echo $checked ?>>
					<p class="description">Default canvas colour.</p>
					<p class="description"><small>Default value: false</small></p>
				</td>
			</tr>
			-->
			<tr valign="top">
				<th scope="row">DEFAULT_WIDTH</th>
				<td>
					<input type="text" value="<?php echo get_option('timthumb_default_width') ?>" id="timthumb_default_width" name="timthumb_default_width" placeholder="100">
					<p class="description">Default thumbnail width.</p>
					<p class="description"><small>Default value: false</small></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">DEFAULT_HEIGHT</th>
				<td>
					<input type="text" value="<?php echo get_option('timthumb_default_height') ?>" id="timthumb_default_height" name="timthumb_default_height" placeholder="100">
					<p class="description">Default thumbnail height.</p>
					<p class="description"><small>Default value: false</small></p>
				</td>
			</tr>

		</table>
		<?php submit_button() ?>
	</form>
</div>

<?php

if (is_admin() && FALSE) {

	add_action('admin_action_update', function() {
		$submit = wp_parse_args($_POST);
		if (!empty($submit['option_page']) && $submit['option_page'] != 'jptt-timthumb-group') return;

		global $wpdb;
		$wpdb instanceof wpdb;

		$options = $wpdb->get_results("SELECT option_name, option_value FROM $wpdb->options WHERE option_name LIKE 'timthumb_%'");

		$content = "<?php \n";
		foreach ($options as $option) {
			$item = str_replace('TIMTHUMB_', '', strtoupper($option->option_name));
			$value = is_numeric($option->option_value) ? (int) $option->option_value : "'{$option->option_value}'";
			$content.= "define('{$item}', {$value});\n";
		}

		$filename = JPTT_BASEPATH . 'libraries/timthumb/timthumb-config.php';

		if (file_exists($filename)) {
			unlink($filename);
		}

		$config_file = fopen($filename, "w") or die("Unable to open file!");
		fwrite($config_file, $content);
		fclose($config_file);

		return;
	});
}
<?php

defined('ABSPATH') or die("No script kiddies please!");

if (!function_exists('debug')) {

	/**
	 * Dumps information about the variable wrapped in &lt;pre&gt; tag and, optionally, terminate the current script.
	 *
	 * @param mixed $var The variable you want to dump.
	 * @param bool $stop If true terminate the current script.
	 * @return void
	 */
	function debug($var, $stop = false) {
		echo '<pre>';
		var_dump($var);
		echo '</pre>';

		if ($stop) {
			die();
		}
	}

}

if (!function_exists('debug_template')) {

	function debug_template() {
		add_filter('template_include', function ($template) {
			global $wp_query;
			debug($template);
			debug($wp_query, 1);
		}, 99);
	}

}
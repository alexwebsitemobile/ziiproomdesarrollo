<?php

add_filter('mailto', function($str) {

	if (!is_string($str)) {
		return '';
	}

	$mail = sanitize_text_field($str);

	if (is_email($mail)) {
		$mail = sprintf('<a href="mailto:%s">%s</a>', $mail, $mail);
	}

	return $mail;
});

add_filter('__mod_rewrite_rules', function($rule) {

	if (get_option('use-timthumb-htaccess', false)) {

		$not_found_rule = $timthumb_rule = '';

		$home_root = parse_url(JPTT_BASEURI . 'libraries/timthumb/timthumb.php', PHP_URL_PATH);
		$default_image = parse_url(JPTT_BASEURI . 'assets/images/no-image.png', PHP_URL_PATH);

		$not_found_rule .= "<IfModule mod_rewrite.c>\n";
		$not_found_rule .= "RewriteEngine On\n";
		$not_found_rule .= "RewriteCond %{REQUEST_FILENAME} !-f\n";
		$not_found_rule .= "RewriteCond %{REQUEST_URI} (?i)(jpg|jpeg|png|gif)$ \n";
		$not_found_rule .= "RewriteCond %{QUERY_STRING} h=([1-9]) [OR]\n";
		$not_found_rule .= "RewriteCond %{QUERY_STRING} w=([1-9])\n";
		$not_found_rule .= "RewriteRule (.*) {$home_root}?%{QUERY_STRING}&src={$default_image} [L]\n";
		$not_found_rule .= "\n";
		$not_found_rule .= "RewriteCond %{REQUEST_FILENAME} !-f\n";
		$not_found_rule .= "RewriteCond %{REQUEST_URI} (?i)(jpg|jpeg|png|gif)$ \n";
		$not_found_rule .= "RewriteRule (.*) {$default_image} [L]\n";
		$not_found_rule .= "</IfModule>\n";
		$not_found_rule .= "\n";

		$timthumb_rule .= "\n";
		$timthumb_rule .= "<IfModule mod_rewrite.c>\n";
		$timthumb_rule .= "RewriteEngine On\n";
		$timthumb_rule .= "RewriteCond %{REQUEST_FILENAME} -f\n";
		$timthumb_rule .= "RewriteCond %{REQUEST_URI} (?i)(jpg|jpeg|png|gif)$ \n";
		$timthumb_rule .= "RewriteCond %{QUERY_STRING} h=([1-9]) [OR]\n";
		$timthumb_rule .= "RewriteCond %{QUERY_STRING} w=([1-9])\n";
		$timthumb_rule .= "RewriteRule (.*) {$home_root}?%{QUERY_STRING}&src=%{REQUEST_URI}\n";
		$timthumb_rule .= "</IfModule>\n";
	}

	return $not_found_rule . $rule .$timthumb_rule;
});

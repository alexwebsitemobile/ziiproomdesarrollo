<?php

defined('ABSPATH') or die("No script kiddies please!");

/**
 * Returns an Bootstrap checkbox element
 * @param string $identifier
 * @param string $label
 * @param string $value
 * @param bool $checked
 * @return string
 */
function get_boostrap_checkbox($identifier, $label, $value = 1, $checked = FALSE) {

	$checked = checked((bool) $checked, TRUE, FALSE);

	$checkbox = '<div class="checkbox">';
	$checkbox .= sprintf('<label for="%s">', $identifier);
	$checkbox .= sprintf('<input type="checkbox" name="%s" id="%s" value="%s" %s>', $identifier, $identifier, $value, $checked);
	$checkbox .= $label;
	$checkbox .= '</label>';
	$checkbox .= '</div>';

	return $checkbox;
}

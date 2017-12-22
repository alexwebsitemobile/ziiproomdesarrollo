<?php

namespace jptt\core;

defined('ABSPATH') or die('No direct script access allowed');

class Html {

	public function select($attr = array(), $data = array(), $options = array(), $echo = false) {
		$attr_defaults = array(
				'class' => 'form-control',
				'id' => '',
				'name' => ''
		);
		$attr = wp_parse_args($attr, $attr_defaults);

		$format = '<select %s>%s</select>';

		$attribute = $this->parse_attributes($attr);
		$content = $this->options($data, $options);

		$html = sprintf($format, $attribute, $content);

		if ($echo) echo $html;
		return $html;
	}

	public function options($data = array(), $options = array(), $echo = false) {
		$format = '<option value="%s" %s>%s</option>';

		$defaults = array(
				'value' => 'value',
				'text' => 'text',
				'selected' => '',
		);

		$options = (object) wp_parse_args($options, $defaults);

		$html = '';
		foreach ($data as $item) {
			$html .= sprintf($format, $item->{$options->value}, selected($item->{$options->value}, $options->selected, FALSE), $item->{$options->text});
		}

		if ($echo) echo $html;
		return $html;
	}

	/**
	 * Must use <i>HTML::attributes()</i>
	 * @deprecated since version 0.12.2
	 * @param type $attr
	 * @param type $echo
	 * @return string
	 */
	public function parse_attributes($attr = array(), $echo = false) {
		$attr = array_map('esc_attr', $attr);
		$html = '';
		foreach ($attr as $name => $value) {
			$html .= " $name=" . '"' . trim($value) . '"';
		}

		if ($echo) echo $html;
		return $html;
	}

}

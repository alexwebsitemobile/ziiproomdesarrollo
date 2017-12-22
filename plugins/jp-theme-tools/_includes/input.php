<?php

/**
 *
 * @param int $type <p>
 * One of <b>INPUT_GET</b>, <b>INPUT_POST</b>,
 * <b>INPUT_COOKIE</b>, <b>INPUT_SERVER</b>, or
 * <b>INPUT_ENV</b>.
 * </p>
 * @param string $field
 * @return int
 */
function filter_input_int( $type, $field ) {
	$input_value = (int) filter_input( $type, $field, FILTER_SANITIZE_NUMBER_INT );
	return $input_value;
}

/**
 *
 * @param int $type <p>
 * One of <b>INPUT_GET</b>, <b>INPUT_POST</b>,
 * <b>INPUT_COOKIE</b>, <b>INPUT_SERVER</b>, or
 * <b>INPUT_ENV</b>.
 * </p>
 * @param string $field
 * @return string|bool
 */
function filter_input_wpnonce( $type, $field = '_wpnonce' ) {
	$input_value = filter_input( $type, $field, FILTER_SANITIZE_STRIPPED );
	return $input_value;
}

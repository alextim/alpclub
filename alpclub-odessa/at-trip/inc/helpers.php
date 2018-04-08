<?php
declare(strict_types=1);
/**
 * Helper Functions.
 *
 * @package at-trip/inc
 */

/**
 * Return dropdown.
 *
 * @param  array $args Arguments for dropdown list.
 * @return HTML  return dropdown list.
 */
function at_trip_get_dropdown_currency_list( array $args = [] ) : string {

	$currency_list = at_trip_get_currency_list();
	if (!$currency_list ) {
		return '';
	}

	$default = [
		'id'		=> '',
		'class'		=> '',
		'name'		=> '',
		'option'	=> '',
		'options'	=> '',
		'selected'	=> '',
		];

	$args = array_merge( $default, $args );

	$dropdown = ('' === $args['option']) ? '' : '<option value="" >' . $args['option'] . '</option>';

	foreach ( $currency_list as $key => $currency ) {
		$dropdown .= '<option value="' . $key . '" ' . selected( $args['selected'], $key, false ) . '  >' . $currency . ' (' . at_trip_get_currency_symbol( $key ) . ')</option>';
	}
	return '<select name="' . $args['name'] . '" id="' . $args['id'] . '" class="' . $args['class'] . '" >' . $dropdown  . '</select>';
}
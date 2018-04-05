<?php
declare(strict_types=1);
/**
 *  All Currency Listing Array.
 *
 *  @package wp-pattern-design
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/** Return All Available Currencies. */
function at_trip_get_currency_list() : array {
	$currency = [
		'EUR' => 'Euro Member Countries',
		'RUB' => 'Russia Ruble',
		'UAH' => 'Ukraine Hryvna',
		'USD' => 'United States Dollar',
	];

	return apply_filters( 'at_trip_currencies', $currency );
}

function at_trip_get_currency_symbol( string $currency_code = '' ) : string {
	if ( empty($currency_code) ) {
		
		//$settings = wp_travel_get_settings();
		//$currency_code = ( isset( $settings['currency'] ) ) ? $settings['currency'] : 'USD';
		
		$currency_code = 'EUR';
	}

	$currency_symbols = [
		'EUR' => '&#8364;',
		'RUB' => '&#1088;&#1091;&#1073;',
		'UAH' => '&#8372;',
		'USD' => '&#36;',
	];

	$currency_symbols = apply_filters( 'at_trip_currency_symbols', $currency_symbols );

	return ( array_key_exists( $currency_code, $currency_symbols ) ) ? $currency_symbols[ $currency_code ] : 'N/A';
}
<?php
/**
 * Widget template
 *
 * @package Alpclub_Odessa
 */

$term_id = absint($person_type);

if ( $term_id > 0 ) {
	$qargs = [
		'post_type' => AT_PERSON_POST_TYPE,
		
		'orderby' => 'meta_value_num',
		//'orderby' => 'meta_value_numeric',
		//'meta_type' => 'NUMERIC',
		
		'meta_key' => 'person_sort_order',
		'order' => 'DESC',
		'tax_query' => [
			[
				'taxonomy' => 'person_type',
				'field'    => 'term_id',
				'terms'    => $term_id,
			],
		],
	];
} else {
	$qargs = [];
}

at_print_in_columns( '', '', AT_PERSON_POST_TYPE, $qargs, AT_PERSON_ITEMS_PER_ROW);
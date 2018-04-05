<?php
/**
 * Admin Helper
 *
 * @package inc/admin/
 */


// ADMIN COLUMN - HEADERS
add_filter( 'manage_edit-' . AT_TRIP_POST_TYPE . '_columns', function ( $columns ) {
	unset( $columns['date'] );
	$columns['sticky'] = 'Sticky';
	$columns['price'] = 'Price';
	$columns['dates'] = 'Dates';
	$columns['days'] = 'Days/Nights';
	return $columns;
} );



// ADMIN COLUMN - CONTENT
add_action( 'manage_' . AT_TRIP_POST_TYPE . '_posts_custom_column', 'at_trip_manage_columns', 10, 2 );
function at_trip_manage_columns( $column_name, $id ) {
	$post = get_post( $id );
	$trip = new AT_Trip_Trip( $post );
	
	switch ( $column_name ) {
		
		case 'sticky':
			if (1 === $trip->get_sticky()) {
				//$icon_class = ( 1 === $sticky ) ? 'dashicons-star-filled' : 'dashicons-star-empty';
				$icon_class = 'dashicons-star-filled';
				printf( '<span class="dashicons %s"></span>', $icon_class );
			}
			break;

		case 'price':
			$price = $trip->get_price();
			if ($price > 0) {
				$currency = $trip->get_currency();
				if (isset($currency)) {
					$currency = at_trip_get_currency_symbol($currency);
				}
				echo $price . '&nbsp;' . $currency;
			}
			break;

		case 'dates':
			$fixed_departure = $trip->get_fixed_departure();
		
			if ( $fixed_departure ) {
				$start_date = $trip->get_start_date();
				$end_date = $trip->get_end_date();
				
				$s = '';
				if ( !empty($start_date) ) {
					//$d = new DateTime($start_date);
					//$s = $d->format('d-m-Y');
					$s = $start_date;
				}
				if ( !empty($end_date)) {
					
					//$d = new DateTime($end_date);
					//$s .= ' - ' . $d->format('d-m-Y');
					$s .= ' - ' . $end_date;
				}
				echo $s;
			}
			break;

		case 'days':
			$fixed_departure = $trip->get_fixed_departure();
			if ( !$fixed_departure ) {
				$days = $trip->get_duration_days();
				$nights = $trip->get_duration_nights();
				if ( $days > 0 || $nights > 0 ) {
					printf( '%d / %d', $days, $nights );
				}
			}
			break;
			
		default:
			break;
	}
}


// ADMIN COLUMN - SORTING - MAKE HEADERS SORTABLE
// https://gist.github.com/906872
add_filter( 'manage_edit-' . AT_TRIP_POST_TYPE . '_sortable_columns', 'at_trip_sort' );
function at_trip_sort( $columns ) {
	$custom = array(
		'sticky' 	=> 'trip_sticky',
		'price' 	=> 'trip_price',
	);
	return wp_parse_args( $custom, $columns );
	return $columns;
}

<?php
declare(strict_types=1);
/**
 * AT Trip Trip class
 *
 * @package AT Trip
 */
final class AT_Trip_Trip {
	private $post;
	private $post_meta;
	private $date_format_mask;

	function __construct( $post = null ) {
		$this->post = is_null( $post ) ? get_post( get_the_ID() ) : $post;
		$this->post_meta = get_post_meta( $this->post->ID );
		$this->date_format_mask = get_option( 'date_format' );
		if (! $this->date_format_mask ) {
			$this->date_format_mask = 'd.m.Y';
		}
		return $this->post;
	}
	
	public function get_sticky()              : int   { return $this->get_field_int( 'trip_sticky' ); }

	public function get_fixed_departure()     : int    { return $this->get_field_int( 'trip_fixed_departure' ); }
	
	public function get_start_date()          : string { return $this->get_field_date( 'trip_start_date' ); }
	public function get_end_date()            : string { return $this->get_field_date( 'trip_end_date' ); }

	public function get_duration_days()       : int    { return $this->get_field_int( 'trip_duration_days' ); }
	public function get_duration_nights()     : int    { return $this->get_field_int( 'trip_duration_nights' ); }
	
	public function get_price()               : int    { return $this->get_field_int( 'trip_price' ); }
	public function get_currency()            : string { return $this->get_field_text( 'trip_currency' ); }
	
	public function get_enable_sale()         : int    { return $this->get_field_int( 'trip_enable_sale' ); }
	public function get_sale_price()          : int    { return $this->get_field_int( 'trip_sale_price' ); }

	public function get_highest_point()		  : int    { return $this->get_field_int( 'trip_highest_point' ); }
	public function get_technical_difficulty(): int    { return $this->get_field_int( 'trip_technical_difficulty' ); }
	public function get_fitness_level()		  : int    { return $this->get_field_int( 'trip_fitness_level' ); }
	public function get_group_size()		  : int    { return $this->get_field_int( 'trip_group_size' ); }

	function get_description() : string {
		return ( isset( $this->post->post_content ) && '' !== $this->post->post_content ) ? $this->post->post_content : '';
	}
	public function get_outline()           : string { return $this->get_field_raw( 'trip_outline' ); }
	
	public function get_include()           : string { return $this->get_field_raw( 'trip_include' ); }
	public function get_exclude()           : string { return $this->get_field_raw( 'trip_exclude' ); }

	public function get_price_details()	    : string { return $this->get_field_raw( 'trip_price_details' ); }
	public function get_equipment()		    : string { return $this->get_field_raw( 'trip_equipment' ); }
	public function get_additional_info()   : string { return $this->get_field_raw( 'trip_additional_info' ); }
	public function get_gallery()		    : string { return $this->get_field_raw( 'trip_gallery' ); }

	public function get_registration_enabled()  : int    { return $this->get_field_int( 'trip_registration_enabled' ); }
	public function get_registration_end_date() : string { return $this->get_field_date( 'trip_registration_end_date' ); }
	public function get_registration_form()     : string { return $this->get_field_url( 'trip_registration_form' ); }
	
	private function get_field_raw( string $field ) : string {	
		if ( isset( $this->post_meta[$field][0] ) && '' !== $this->post_meta[$field][0] ) {
			return $this->post_meta[$field][0]; 
		}
		return '';
	}

	private function get_field_text( string $field ) : string  {	
		if ( isset( $this->post_meta[$field][0] ) && '' !== $this->post_meta[$field][0] ) {
			return esc_html( $this->post_meta[$field][0] ); 
		}
		return '';
	}
	
	private function get_field_url( string $field ) : string  {	
		if ( isset( $this->post_meta[$field][0] ) && '' !== $this->post_meta[$field][0] ) {
			return esc_url( $this->post_meta[$field][0] ); 
		}
		return '';
	}
	
	private function get_field_date( string $field ) : string  {	
		if ( isset( $this->post_meta[$field][0] ) && '' !== $this->post_meta[$field][0] ) {
			return date( $this->date_format_mask, (int)$this->post_meta[$field][0] ); 
		}
		return '';
	}
	
	private function get_field_int( string $field )  : int { 
		if ( isset( $this->post_meta[$field][0] ) && '' !== $this->post_meta[$field][0] ) {
			return absint( $this->post_meta[$field][0] ); 
		}
		return 0; 
	}

	private function get_trip_taxonomy( string $taxonomy, string $before, string $sep, string $after ) : string {
		$lists = get_the_term_list( $this->post->ID, $taxonomy, $before, $sep, $after );
		if ( false !== $lists && !is_wp_error($lists) ) {
			return (string)$lists;
		}
		return '';	
	}
	
	function get_trip_type_list( string $before = '', string $sep = ', ', string $after = '' )  : string {
		return $this->get_trip_taxonomy( 'trip_type', $before, $sep, $after );
	}

	function get_activity_list( string $before = '', string $sep = ', ', string $after = '' ) : string {
		return $this->get_trip_taxonomy( 'activity', $before, $sep, $after );
	}

	function get_destination_list( string $before = '', string $sep = ', ', string $after = '' ) : string {
		return $this->get_trip_taxonomy( 'destination', $before, $sep, $after );
	}	
	
	function get_keyword_list( string $before = '', string $sep = ', ', string $after = '' ) : string {
		return $this->get_trip_taxonomy( 'trip_keyword', $before, $sep, $after );
	}

	function format_days(int $days) : string {
		return ( $days > 0 ) ? at_num_form($days, 'день', 'дня', 'дней') : '';
	}
	
	function format_nights(int $nights): string  {
		return ( $nights > 0 ) ? at_num_form($nights, 'ночь', 'ночи', 'ночей') : '';
	}
	
	private function get_fa(string $icon) : string {
		return '<i class="fa fa-' . $icon . '"></i>';
	}
	
	private function print_info_item( string $title, string $value, string $prefix = '', string $suffix = '' ) {
		if ( !empty ($value) ) {
			$s = '<div class="trip-info-item">';
			$s .= '<span class="trip-info-title">' . $title . '</span>';
			
			$s .= '<span class="trip-info-value">';
			if ( !empty ($prefix) ) {
				$s .=  $prefix . '&nbsp;';
			}			
			$s .= $value;
			if ( !empty ($suffix) ) {
				$s .= '&nbsp;' . $suffix;
			}
			$s .= '</span>';
			
			$s .= '</div>';
			echo $s;
		}
	}
	private function print_all_prices_html( $title, $price, $sale_price, $currency ){
		$s = '<div ="trip-info-item">';
		$s .= '<span class="trip-info-title">' . $title . '</span>';
		
		$s .= '<span class="trip-info-value old-price">' . $price;
		$s .= '&nbsp;' . $currency;
		$s .= '</span>';

		$s .= '<span class="trip-info-value sale-price">' . $sale_price;
		$s .= '&nbsp;' . $currency;
		$s .= '</span>';
		
		$s .= '</div>';
		echo $s;
	}

	private function print_level_html( $title, $value ) {
		if ( $value > 0 ) {
			$s = '<div class="trip-info-item">';
			$s .= '<span class="trip-info-title">' . $title . '</span>';
			
			$max_value = 4;
			
			$s .= '<span class="trip-info-value">';
			for( $i = 1; $i <= $max_value; $i++ ) {
				$s .= $i <= $value ? '★' : '☆';
			}
			$s .= '</span>';
			
			$s .= '</div>';
			echo $s;
		}
	}
	
	function print_all_info() {
		$this->print_dates_duration();
		$this->print_other_info();
		$this->print_price();
	}
	
	function print_dates_duration() {
		if ( $this->get_fixed_departure() ) {
			$this->print_dates();
		} else {
			$this->print_duration();	
		}		
	}
	
	function print_dates() {
		$s = '';
		$start_date = $this->get_start_date();
		$end_date = $this->get_end_date();
		
		if ( !empty($start_date) ) {
			$s = $start_date;
		}
		
		if ( !empty($end_date) ) {
			$s .= ' - ' . $end_date;
		}
		
		$this->print_info_item( $this->get_fa('calendar'), $s );
	}
	
	function print_registration_form(string $title, string $id = '', string $class = '') {
		if ( !$this->get_registration_enabled() ) {
			return;
		}
		$end_date = $this->get_registration_end_date();
		if ( !empty($end_date) ) {
			if (strtotime($end_date) < time() ) {
				return;
			}
		}

		$s = $this->get_registration_form();
		
		if ( !empty($s) ) {
			if (!empty($id)) {
				$id = ' id="' . esc_attr($id) . '" ';
			}			
			if (!empty($class)) {
				$class = ' class="' . esc_attr($class) . '" ';
			}
			echo '<a ' . $id .  $class . ' target="_blank" rel="noopener nofollow" href="' . $s . '">' . esc_html($title) . '</a>';
		}
	}
	
	function print_duration() {
		$s = '';
		$s = $this->format_days( $this->get_duration_days());
		
		$nights = $this->get_duration_nights();
		if ( $nights > 0 ) {
			if ( !empty( $s ) ) {
				$s .= ' / ';
			}
			$s .= $this->format_nights( $nights );
		}
		
		$this->print_info_item( $this->get_fa('clock-o'), $s );
	}	
	
	function print_other_info() {
		$highest_point = $this->get_highest_point();
		if ( $highest_point > 0 ) {
			$this->print_info_item( $this->get_fa('area-chart'), (string)$highest_point, '', 'м' );
		}
		
		$this->print_level_html( 'Сложность', $this->get_technical_difficulty() );
		$this->print_level_html( 'Фитнес', $this->get_fitness_level() );
		
		$group_size = $this->get_group_size();
		if ( $group_size > 0 ) {
			$this->print_info_item( $this->get_fa('group'), (string)$group_size, 'до', 'чел' );
		}
		$this->print_all_categories();
	}
	
	function print_all_categories() {
		$list = $this->get_trip_type_list();
		if ( !empty($list) ) {
			$this->print_info_item( 'Тип', $list );
		}
		$list = $this->get_activity_list();
		if ( !empty($list) ) {
			$this->print_info_item( 'Активность', $list );
		}
		$list = $this->get_destination_list();
		if ( !empty($list) ) {
			$this->print_info_item( 'Направление', $list );
		}
		$list = $this->get_keyword_list();
		if ( !empty($list) ) {
			$this->print_info_item( 'Тэг', $list );
		}
	}


	function print_price() {
		$price = $this->get_price();
		$currency = $this->get_currency();
		$enable_sale = $this->get_enable_sale();
	
		if (isset($currency)) {
			$currency = at_trip_get_currency_symbol($currency);
		}
		
		if ( $enable_sale ) {
			$sale_price = $this->get_sale_price();
			if ( $sale_price > 0 ) {
				
				if ($price > 0) {
					$this->print_all_prices_html( $this->get_fa('money'), $price, $sale_price, $currency );
					return;
				}
				
				$price = $sale_price;
			} 
		} 
		if ($price > 0) {
			$this->print_info_item( $this->get_fa('money'), (string)$price, '', $currency );
		}
	}
	
	function get_tabs() {
	
		$description    = $this->get_description();
		$outline        = $this->get_outline();
		$trip_include 	= $this->get_include();
		$trip_exclude 	= $this->get_exclude();
		$price_details  = $this->get_price_details();
		$equipment      = $this->get_equipment();
		$additional_info= $this->get_additional_info();
		$gallery        = $this->get_gallery();
		
		$tabs = [];
		
		if ( !empty($description) ) {
			$tabs[] = new AT_Trip_Tab( 'tabone', 'Описание', $description );
		}

		if ( !empty($outline) ) {
			$tabs[] = new AT_Trip_Tab( 'tabtwo', 'Программа по дням', $outline );
		}

		if ( !empty($trip_include) || !empty($trip_exclude) ) {
			$s = '';
			

			if ( !empty($trip_include)) {
				$s .= '<div class="trip-service-tab-wrap">';
					$s .= '<div class="trip-service-tab-subtitle"><span class="fa fa-plus"></span><span>Включено</span></div>';
					$s .= $trip_include;
				$s .= '</div>';
			}
			if ( !empty($trip_exclude)) {
				$s .= '<div class="trip-service-tab-wrap">';
					$s .= '<div class="trip-service-tab-subtitle"><span class="fa fa-minus"></span><span>Не включено</span></div>';
					$s .= $trip_exclude;
				$s .= '</div>';
			}
			if ( !empty($s) ) {
				$tabs[] = new AT_Trip_Tab( 'tabthree', 'Услуги по дням', $s );
			}
		}
		

		if ( !empty($price_details) ) {
			$tabs[] = new AT_Trip_Tab( 'tabfour', 'Стоимость', $price_details );
		}

		if ( !empty($equipment) ) {			
			$tabs[] = new AT_Trip_Tab( 'tabfive', 'Снаряжение', $equipment );
		}

		if ( !empty($additional_info) ) {			
			$tabs[] = new AT_Trip_Tab( 'tabsix', 'Доп.информация', $additional_info );
		}

		if ( !empty($gallery) ) {
			$tabs[] = new AT_Trip_Tab( 'tabseven', 'Галерея', $gallery );
		}	
		
		return  $tabs;
	}
}
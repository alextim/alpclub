<?php
/**
 * Core functions
 *
 * @package Alpclub_Odessa
 */
function aco_get_person_type_choices( bool $add_all = true ) : array {
	return aco_get_custom_taxonomy_choices( 'person_type', 'All Types', $add_all );
} 
 
function aco_get_trip_activity_choices( bool $add_all = true ) : array {
	return aco_get_custom_taxonomy_choices( 'activity', 'All Activities', $add_all );
} 
 
function aco_get_custom_taxonomy_choices( string $taxonomy_name, string $all_caption, bool $add_all ) : array {
	$choices = [];
	
	if ( true === $add_all ) {
		$choices[0] = esc_html__( $all_caption, 'alpclub-odessa' );
	}
	
	$args = [
		'taxonomy' => $taxonomy_name,
		'hide_empty '=> false,
		'parent' => 0,
	];
	

	$terms = get_terms($args);

	if ( !empty( $terms ) && !is_wp_error( $terms ) ) {
		foreach($terms as $term) {
			$choices[ $term->term_id ] = $term->name;
		}
	}
	
	return $choices;
}


function aco_get_posts_choices ( int $limit_post_number, string $post_type = '' ) : array {
	$qargs = ['posts_per_page' => $limit_post_number];
	if ( !empty($post_type) ) {
		$qargs['post_type'] = $post_type;
	}
	$posts = get_posts($qargs);
	
	foreach ($posts as $post) {
		$choices[$post->ID] = $post->post_title;
	}	
	return $choices;		
} 

function aco_is_maintanence_mode() : bool {
	
	$default_options = ['maintenance_mode' => false];

	$theme_options = (array) get_theme_mod( 'theme_options' );
	$theme_options = wp_parse_args( $theme_options, $default_options );

	$value = false;

	if ( isset( $theme_options[ 'maintenance_mode' ] ) ) {
		$value = $theme_options[ 'maintenance_mode' ];
	}

	return (bool)$value;
}


function aco_esc_url2( $url ) {
	if( preg_match('/^post: *([0-9]+)/', $url, $matches) ) {
		// Convert the special post URL into a permalink
		$url = get_the_permalink( intval($matches[1]) );
		if( empty($url) ) return '';
		if ( is_wp_error($url) ) return '';
	}
	if( preg_match('/^category: *([a-z]+)/', $url, $matches) ) {
		$url = get_term_link($matches[1]);
		if( empty($url) || is_wp_error($url) ) return '';
		return $url;
	}
	if( preg_match('/^activity: *([a-z]+)/', $url, $matches) ) {
		$url = get_term_link($matches[1], 'activity' );
		if( empty($url) || is_wp_error($url) ) return '';
		return $url;
	}
	if( preg_match('/^destination: *([a-z]+)/', $url, $matches) ) {
		$url = get_term_link($matches[1], 'destination' );
		if( empty($url) || is_wp_error($url) ) return '';
		return $url;
	}	
	if( strpos('trips', $url) === 0) {
		$url = get_post_type_archive_link( AT_TRIP_POST_TYPE );
		if( empty($url) || is_wp_error($url) ) return '';
		return $url;
	}	
	if( strpos('persons', $url) === 0 ) {
		$url = get_post_type_archive_link( AT_PERSON_POST_TYPE );
		if( empty($url) || is_wp_error($url) ) return '';
		return $url;
	}	

	$protocols = wp_allowed_protocols();
	$protocols[] = 'skype';
	return esc_url( $url, $protocols );
}
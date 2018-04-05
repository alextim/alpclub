<?php
/**
 * Latest trips widget
 *
 * Widget Name: Alpclub Odessa Latest Trips
 * Description: Displays latest trips in grid.
 * Author: Alex Tim
 * Author URI: 
 *
 * @package Alpclub_Odessa
 */
class Alpclub_Odessa_Latest_Trips_Widget extends SiteOrigin_Widget {

	function __construct() {

		parent::__construct(
			'alpclub-odessa-latest-trips',
			esc_html__( 'ACO: Latest Trips', 'alpclub-odessa' ),
			array(
				'description' => esc_html__( 'Displays latest trips in grid.', 'alpclub-odessa' ),
			),
			array(),
			false,
			plugin_dir_path( __FILE__ )
		);
	}

	function get_widget_form() {
    $post_type_data = get_post_type_object( AT_TRIP_POST_TYPE );
    $post_type_slug = $post_type_data->rewrite['slug'];	
	
		return array(
			'title' => array(
				'type'  => 'text',
				'label' => esc_html__( 'Title', 'alpclub-odessa' ),
				),
			'subtitle' => array(
				'type'  => 'text',
				'label' => esc_html__( 'Subtitle', 'alpclub-odessa' ),
				),
			'heading_alignment' => array(
				'label'   => esc_html__( 'Title/subtitle Alignment', 'alpclub-odessa' ),
				'type'    => 'select',
				'default' => 'center',
				'options' => surya_chandra_get_heading_alignment_options(),
				),
			'activity' => array(
				'label'           => esc_html__( 'Select Activity:', 'alpclub-odessa' ),
				'type'    => 'select',
				'default' => 0, //All
				'options' => aco_get_trip_activity_choices(),
				),
			'sticky_filter' => array(
				'label'   => esc_html__( 'Select', 'alpclub-odessa' ),
				'type'    => 'select',
				'default' => 'center',
				'options' => [  'unsorted', 'sticky first', 'sticky only', 'exclude sticky' ],
				),	
			'post_number' => array(
				'label'   => esc_html__( 'Number of Posts', 'alpclub-odessa' ),
				'type'    => 'number',
				'default' => 3,
				),
			'post_column' => array(
				'label'   => esc_html__( 'Number of Columns', 'alpclub-odessa' ),
				'type'    => 'select',
				'default' => 3,
				'options' => surya_chandra_get_numbers_dropdown_options( 2, 4 ),
				),
			'featured_image' => array(
				'label'   => esc_html__( 'Featured Image', 'alpclub-odessa' ),
				'type'    => 'select',
				'default' => 'large',
				'options' => surya_chandra_get_image_sizes_options( false ),
				),
			'more_text' => array(
				'label'   => esc_html__( 'More Text', 'alpclub-odessa' ),
				'type'    => 'text',
				'default' => esc_html__( 'Know More', 'alpclub-odessa' ),
				),
			'excerpt_length' => array(
				'label'       => esc_html__( 'Excerpt Length', 'alpclub-odessa' ),
				'description' => esc_html__( 'in words', 'alpclub-odessa' ),
				'type'        => 'number',
				'default'     => 15,
				),
			'explore_button_text' => array(
				'label'   => esc_html__( 'Explore Button Text', 'alpclub-odessa' ),
				'type'    => 'text',
				'default' => esc_html__( 'Explore More', 'alpclub-odessa' ),
				),
			'explore_button_url' => array(
				'label'   => esc_html__( 'Explore Button URL', 'alpclub-odessa' ),
				'type'    => 'text',
				'default' => $post_type_slug,
				),
			'enable_dates' => array(
				'label'   => esc_html__( 'Enable Date/Duration', 'alpclub-odessa' ),
				'type'    => 'checkbox',
				'default' => false,
				),
			'enable_price' => array(
				'label'   => esc_html__( 'Enable Price', 'alpclub-odessa' ),
				'type'    => 'checkbox',
				'default' => false,
				),			
			);
	}

}

if ( ! function_exists( 'aco_get_single_trip_activity' ) ) :


	function aco_get_single_trip_activity( $post_obj = null ) {

		$output = array();

		global $post;

		if ( is_null( $post_obj ) ) {
			$post_obj = $post;
		}

		$terms = get_the_terms( $post_obj, 'activity' );

		if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
			$first_term = array_shift( $terms );
			$output['name']    = $first_term->name;
			$output['slug']    = $first_term->slug;
			$output['term_id'] = $first_term->term_id;
			$output['url']     = get_term_link( $first_term );
		}

		return $output;
	}

endif;

siteorigin_widget_register( 'alpclub-odessa-latest-trips', __FILE__, 'Alpclub_Odessa_Latest_Trips_Widget' );
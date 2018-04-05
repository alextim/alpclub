<?php
/**
 * Recent trips widget
 *
 * Widget Name: Alpclub Odessa Recent Trips
 * Description: Displays recent trips.
 * Author: Alex Tim
 * Author URI: 
 *
 * @package Alpclub_Odessa
 */
final class Alpclub_Odessa_Recent_Trips_Widget extends SiteOrigin_Widget {

	function __construct() {

		parent::__construct(
			'alpclub-odessa-recent-trips',
			esc_html__( 'ACO: Recent Trips', 'alpclub-odessa' ),
			array(
				'description' => esc_html__( 'Displays recent trips.', 'alpclub-odessa' ),
			),
			array(),
			false,
			plugin_dir_path( __FILE__ )
		);
	}

	function get_widget_form() {

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
				'label'   => esc_html__( 'Number of Trips', 'alpclub-odessa' ),
				'type'    => 'number',
				'default' => 3,
				),
			'featured_image' => array(
				'label'   => esc_html__( 'Featured Image', 'alpclub-odessa' ),
				'type'    => 'select',
				'default' => 'thumbnail',
				'options' => surya_chandra_get_image_sizes_options( true, array( 'disable', 'thumbnail' ), false ),
				),
			'image_width' => array(
				'label'       => esc_html__( 'Image Width', 'alpclub-odessa' ),
				'description' => esc_html__( 'in px', 'alpclub-odessa' ),
				'type'        => 'number',
				'default'     => 70,
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

siteorigin_widget_register( 'alpclub-odessa-recent-trips', __FILE__, 'Alpclub_Odessa_Recent_Trips_Widget' );
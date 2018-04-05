<?php
/**
 * Special trip widget
 *
 * Widget Name: Alpclub Odessa Special Trip
 * Description: Displays single trip.
 * Author: Alex Tim
 * Author URI: 
 *
 * @package Alpclub_Odessa
 */
final class Alpclub_Odessa_Special_Trip_Widget extends SiteOrigin_Widget {

	function __construct() {

		parent::__construct(
			'alpclub-odessa-special-trip',
			esc_html__( 'ACO: Special Trip', 'alpclub-odessa' ),
			array(
				'description' => esc_html__( 'Displays single trip.', 'alpclub-odessa' ),
			),
			array(),
			false,
			plugin_dir_path( __FILE__ )
		);
	}

	function get_widget_form() {
		$post_choices = aco_get_posts_choices (200, AT_TRIP_POST_TYPE);
		$post_choices[0] = esc_html__( '&mdash; Select &mdash;', 'alpclub-odessa' );
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
			'special_trip_id' => array(
				'label'   => esc_html__( 'Select Trip:', 'alpclub-odessa' ),
				'type'    => 'select',
				'default' => '0',
				'options' => $post_choices,
				),
			'featured_image' => array(
				'label'   => esc_html__( 'Featured Image', 'alpclub-odessa' ),
				'type'    => 'select',
				'default' => 'medium',
				'options' => surya_chandra_get_image_sizes_options(),
				),
			'featured_image_alignment' => array(
				'label'   => esc_html__( 'Image Alignment', 'alpclub-odessa' ),
				'type'    => 'select',
				'default' => 'left',
				'options' => surya_chandra_get_alignment_options(),
				),
			'enable_excerpt' => array(
				'label'   => esc_html__( 'Enable Excerpt', 'alpclub-odessa' ),
				'type'    => 'checkbox',
				'default' => false,
				),			
			'enable_dates' => array(
				'label'   => esc_html__( 'Enable Dates/Duration', 'alpclub-odessa' ),
				'type'    => 'checkbox',
				'default' => false,
				),			
			'enable_price' => array(
				'label'   => esc_html__( 'Enable Price', 'alpclub-odessa' ),
				'type'    => 'checkbox',
				'default' => false,
				),			
			'enable_other_info' => array(
				'label'   => esc_html__( 'Enable Other Info', 'alpclub-odessa' ),
				'type'    => 'checkbox',
				'default' => false,
				),			
			);
	}
}

siteorigin_widget_register( 'alpclub-odessa-special-trip', __FILE__, 'Alpclub_Odessa_Special_Trip_Widget' );
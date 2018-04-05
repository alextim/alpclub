<?php
/**
 * Latest news widget
 *
 * Widget Name: Alpclub Odessa Latest News
 * Description: Displays latest posts in grid.
 * Author: Alex Tim
 * Author URI: 
 *
 * @package Alpclub_Odessa
 */
class Alpclub_Odessa_Latest_News_Widget extends SiteOrigin_Widget {

	function __construct() {

		parent::__construct(
			'alpclub-odessa-latest-news',
			esc_html__( 'ACO: Latest News', 'alpclub-odessa' ),
			array(
				'description' => esc_html__( 'Displays latest posts in grid.', 'alpclub-odessa' ),
			),
			array(),
			false,
			plugin_dir_path( __FILE__ )
		);
	}

	function get_widget_form() {
		$post_choices = aco_get_posts_choices (200);
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
			'post_category' => array(
				'label'           => esc_html__( 'Select Category:', 'alpclub-odessa' ),
				'type'            => 'taxonomy-dropdown',
				'show_option_all' => esc_html__( 'All Categories', 'alpclub-odessa' ),
				),
			'sticky_filter' => array(
				'label'   => esc_html__( 'Select', 'alpclub-odessa' ),
				'type'    => 'select',
				'default' => 'center',
				'options' => [  'unsorted', 'sticky first', 'sticky only', 'exclude sticky' ],
				),			
			'exclude_post_id' => array(
				'label'   => esc_html__( 'Exclude Post:', 'alpclub-odessa' ),
				'type'    => 'select',
				'default' => '0',
				'options' => $post_choices,
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
				'type'    => 'link',
				'default' => '',
				),
			);
	}

}

siteorigin_widget_register( 'alpclub-odessa-latest-news', __FILE__, 'Alpclub_Odessa_Latest_News_Widget' );
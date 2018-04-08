<?php
/**
 * Special post widget
 *
 * Widget Name: Alpclub Odessa Special Post
 * Description: Displays single post.
 * Author: Alex Tim
 * Author URI: 
 *
 * @package Alpclub_Odessa
 */
final class Alpclub_Odessa_Special_Post_Widget extends SiteOrigin_Widget {

	function __construct() {

		parent::__construct(
			'alpclub-odessa-special-post',
			esc_html__( 'ACO: Special Post', 'alpclub-odessa' ),
			array(
				'description' => esc_html__( 'Displays single post.', 'alpclub-odessa' ),
			),
			array(),
			false,
			plugin_dir_path( __FILE__ )
		);
	}

	function get_widget_form() {
		$post_choices = aco_get_posts_choices (200);
		$post_choices[0] = esc_html__( '&mdash; Select &mdash;', 'alpclub-odessa' );
		return [
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
			'special_post_id' => array(
				'label'   => esc_html__( 'Select Post:', 'alpclub-odessa' ),
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
				'default' => true,
				),				
			];
	}
}

siteorigin_widget_register( 'alpclub-odessa-special-post', __FILE__, 'Alpclub_Odessa_Special_Post_Widget' );
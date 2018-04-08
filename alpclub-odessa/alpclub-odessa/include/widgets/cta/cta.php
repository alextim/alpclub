<?php
/**
 * CTA widget
 *
 * Widget Name: Alpclub Odessa CTA
 * Description: A simple call to action widget.
 * Author: Alex Tim
 * Author URI: 
 *
 * @package Alpclu_Odessa
 */

/**
 * CTA widget class.
 *
 * @since 1.0.0
 */
final class Alpclub_Odessa_CTA_Widget extends SiteOrigin_Widget {

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 */
	function __construct() {

		parent::__construct(
			'alpclub-odessa-cta',
			esc_html__( 'ACO: CTA', 'alpclub-odessa' ),
			array(
				'description' => esc_html__( 'A simple call to action widget.', 'alpclub-odessa' ),
			),
			array(),
			false,
			plugin_dir_path( __FILE__ )
		);
	}

	/**
	 * Get widget form.
	 *
	 * @since 1.0.0
	 *
	 * @return array Widget form.
	 */
	function get_widget_form() {

		return array(
			'title' => array(
				'type'  => 'text',
				'label' => esc_html__( 'Title', 'alpclub-odessa' ),
				),
			'subtitle' => array(
				'type'  => 'textarea',
				'label' => esc_html__( 'Subtitle', 'alpclub-odessa' ),
				),
			'primary_button_text' => array(
				'type'    => 'text',
				'label'   => esc_html__( 'Primary Button Text', 'alpclub-odessa' ),
				'default' => esc_html__( 'Learn More', 'alpclub-odessa' ),
				),
			'primary_button_url' => array(
				'type'    => 'link',
				'label'   => esc_html__( 'Primary Button URL', 'alpclub-odessa' ),
				'default' => '#',
				),
			'primary_button_new_window' => array(
				'label'   => esc_html__( 'Open in a new window', 'alpclub-odessa' ),
				'type'    => 'checkbox',
				'default' => false,
				),
			'primary_button_rel' => array(
						'type' => 'text',
						'label' => __('Rel attribute', 'alpclub-odessa'),
						'description' => __('Adds a rel attribute to the button link.', 'alpclub-odessa'),
				),			
			'secondary_button_text' => array(
				'type'  => 'text',
				'label' => esc_html__( 'Secondary Button Text', 'alpclub-odessa' ),
				),				
			'secondary_button_text' => array(
				'type'  => 'text',
				'label' => esc_html__( 'Secondary Button Text', 'alpclub-odessa' ),
				),
			'secondary_button_url' => array(
				'type'  => 'link',
				'label' => esc_html__( 'Secondary Button URL', 'alpclub-odessa' ),
				),
			'secondary_button_new_window' => array(
				'label'   => esc_html__( 'Open in a new window', 'alpclub-odessa' ),
				'type'    => 'checkbox',
				'default' => false,
				),
			'secondary_button_rel' => array(
						'type' => 'text',
						'label' => __('Rel attribute', 'alpclub-odessa'),
						'description' => __('Adds a rel attribute to the button link.', 'alpclub-odessa'),
				),			'settings' => array(
				'type'   => 'section',
				'label'  => esc_html__( 'Settings', 'alpclub-odessa' ),
				'hide'   => false,
				'fields' => array(
					'cta_layout' => array(
						'type'    => 'radio',
						'label'   => esc_html__( 'Select Layout', 'alpclub-odessa' ),
						'default' => 1,
						'options' => array(
							1 => esc_html__( 'Layout 1', 'alpclub-odessa' ),
							2 => esc_html__( 'Layout 2', 'alpclub-odessa' ),
							),
						),
					'cta_title_color' => array(
						'type'    => 'color',
						'label'   => esc_html__( 'Title Color', 'alpclub-odessa' ),
						'default' => '#FFF',
						),
					'cta_subtitle_color' => array(
						'type'    => 'color',
						'label'   => esc_html__( 'Subtitle Color', 'alpclub-odessa' ),
						'default' => '#CCC',
						),
					'cta_background_color' => array(
						'type'        => 'color',
						'label'       => esc_html__( 'Background Color', 'alpclub-odessa' ),
						'default'     => '#00AEF0',
						'description' => esc_html__( 'Applies to Layout 1 only.', 'alpclub-odessa' ),
						),
					),
				),

			);
	}

	/**
	 * Less variables.
	 *
	 * @since 1.0.0
	 *
	 * @param array $instance Widget instance.
	 * @return array Less variables.
	 */
	function get_less_variables( $instance ) {
		if ( empty( $instance ) ) {
			return array();
		}

		return array(
			'cta_title_color'      => $instance['settings']['cta_title_color'],
			'cta_subtitle_color'   => $instance['settings']['cta_subtitle_color'],
			'cta_background_color' => $instance['settings']['cta_background_color'],
		);
	}

}

siteorigin_widget_register( 'alpclub-odessa-cta', __FILE__, 'Alpclub_Odessa_CTA_Widget' );
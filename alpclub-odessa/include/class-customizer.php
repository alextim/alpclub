<?php

//include get_stylesheet_directory() . '/customizer/sanitize.php';
//include get_stylesheet_directory(). '/customizer/tags-dropdown-custom-control.php';
ACO_ThemeCustomizer::get_instance();

final class ACO_ThemeCustomizer {
	private static $instance;
	
	public static function get_instance() {
        if ( null == self::$instance ) {
			self::$instance = new self;
        }
        return self::$instance;
    } 	
	
    private function __construct() {
		// удаление из род темы работает, когда параметр последовательности выполнения 50        

		add_action( 'customize_register', function ($wp_customize) {
			$this->remove_(  $wp_customize );
			$this->register_(  $wp_customize );
		}, 50);

		//add_filter( 'surya_chandra_filter_default_theme_options', [&$this, 'add_defaults']);
    }

	private function remove_( $wp_customize ) {
		// удаляем поля ввода из родительской темы
		$wp_customize->remove_control('theme_options[contact_number]');
		$wp_customize->remove_control('theme_options[contact_address]');
		$wp_customize->remove_control('theme_options[contact_email]');


		//удаляем копку индусов о продаже
		$wp_customize->remove_section( 'theme_upsell' );
		
		$wp_customize->remove_section( 'section_footer' );		
		//Кнопка Вступить в хедере
		$wp_customize->remove_control('theme_options[quote_button_url]');
		$wp_customize->remove_control('theme_options[quote_button_text]');
		$wp_customize->remove_section( 'section_header' );		
		
		//удаляем настройку CSS
		$wp_customize->remove_section( 'custom_css' );
		
	    $wp_customize->remove_section( 'static_front_page' );
        // Убираем панель смены темы
		$wp_customize->remove_control( 'active_theme' );	
		$wp_customize->remove_panel( 'themes' );
	}


	private function register_(  $wp_customize ) {
		$defaults = surya_chandra_get_default_theme_options();	
		
		$sections = [];

		$sections['aco_maintanence_settings'] = [
			'Maitanence', 1,
			[
				['maintenance_mode', 'at_sanitize_checkbox', 'Maintenance mode', '', 'checkbox'],
			]
		];

		$sections['aco_miscellaneous_settings'] = [
			'Miscellaneous', 35,
			[
				['member_count',    'absint',               'Member Count',   '', 'number'],
				['show_breadcrumb', 'at_sanitize_checkbox', 'Show Breadcumb', '', 'checkbox'],
			]
		];
/*
GoogleAnalytics
		$sections['aco_ga_settings'] = [
			'Google Analytics', 100,
			[
				['ga_active',      'at_sanitize_checkbox', 'Activate',    '', 'checkbox'],
				['ga_tracking_id', '',                                   'Tracking ID', '', 'text'],
				['ga_in_footer',   'at_sanitize_checkbox', 'In footer',   'Put "analytics.js" in footer', 'checkbox'],
				['ga_async',       'at_sanitize_checkbox', 'Async',       '"async" tag works only on modern browsers', 'checkbox'],
			]
		];		
*/		
		$this->create_sections( $wp_customize, $sections, $defaults );
/*		
		$panels = AT_Contact_Info_Customizer::get_panels( $defaults );
		foreach( $panels as $panel_key => $panel ) {
			$wp_customize->add_panel( $panel_key, [
				'title' => $panel[0],
				'description' => $panel[1],
				'priority' => 10,
			]);
			$this->create_sections( $wp_customize,  $panel[2], $defaults, $panel_key );
		}
*/		
		
	}
	
	private function create_sections( $wp_customize, array &$sections, array &$defaults, string $panel_key = '') {
		foreach( $sections as $section_key => $section ){
			$section_args = [
				'title'     => $section[0],
				'priority'  => $section[1],
				];
			if (!empty($panel_key)) {
				$section_args['panel'] = $panel_key;
			}
			$wp_customize->add_section( $section_key, $section_args );
			
			foreach ( $section[2] as $item ) {
				$setting_name = 'theme_options[' . $item[0] . ']';
				$setting_field = [
					'default'=> $defaults[ $item[0] ], 
					'sanitize_callback' => empty ($item[1]) ? 'sanitize_text_field' : $item[1],
				];
/*
				if (isset($item[6]) && !empty($item[6])) {
					$setting_field['validate_callback'] = $item[6];
				}
*/				
				
				$wp_customize->add_setting( $setting_name, $setting_field );
				
				$args = [
					'label'   => $item[2],
					'description'   => $item[3],
					'section' =>  $section_key,
					'type'    => $item[4],
				];
				
				if ( isset($item[5]) ) {
					$args['choices'] = $item[5];
				}
				$wp_customize->add_control( $setting_name, $args );
			}		
		}		
	}
}
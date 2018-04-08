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
				['maintenance_mode', ['AT_Sanitize', 'sanitize_checkbox'], 'Maintenance mode', '', 'checkbox'],
			]
		];

		$sections['aco_miscellaneous_settings'] = [
			'Miscellaneous', 35,
			[
				['member_count',    'absint',                             'Member Count',   '', 'number', '', ['AT_Sanitize', 'validate_member_count']],
				['show_breadcrumb', ['AT_Sanitize', 'sanitize_checkbox'], 'Show Breadcumb', '', 'checkbox'],
			]
		];
/*
GoogleAnalytics
		$sections['aco_ga_settings'] = [
			'Google Analytics', 100,
			[
				['ga_active',      ['AT_Sanitize', 'sanitize_checkbox'], 'Activate',    '', 'checkbox'],
				['ga_tracking_id', '',                                   'Tracking ID', '', 'text'],
				['ga_in_footer',   ['AT_Sanitize', 'sanitize_checkbox'], 'In footer',   'Put "analytics.js" in footer', 'checkbox'],
				['ga_async',       ['AT_Sanitize', 'sanitize_checkbox'], 'Async',       '"async" tag works only on modern browsers', 'checkbox'],
			]
		];		
*/		
		$this->create_sections( $wp_customize, $sections, $defaults );
/*		
		$panels = AT_Contact_Info_Customizer::get_panels();
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


final class AT_Sanitize_Setting_Stub {
	public $default;
	public function __construct($default = '') { $this->default = $default; }
}

final class AT_Sanitize {
	public static function sanitize_dropdown_pages( $page_id, $setting ) {
		$page_id = absint( $page_id );
		return ( 'publish' === get_post_status( $page_id ) ? $page_id : $setting->default );
	}	
	
	public static function sanitize_checkbox( $checked  ) {
		return ( ( isset( $checked ) && true === $checked ) ? true : false );
	}	
	
	public static function sanitize_select( $input, $setting ) {
		// Ensure input is a slug.
		$input = sanitize_key( $input );

		// Get list of choices from the control associated with the setting.
		$choices = $setting->manager->get_control( $setting->id )->choices;

		// If the input is a valid key, return it; otherwise, return the default.
		return array_key_exists( $input, $choices ) ? $input : $setting->default;
	}
	public static function sanitize_phone( $value, $setting ) {
		$san_value = preg_replace('/\D/', '', $value);
		return (strlen($san_value) === 12) ? $san_value : $setting->default;		
	}
	public static function sanitize_skype( $value, $setting ) {
		$san_value = preg_replace('/[^A-Za-z0-9\._]/', '', $value);
		return preg_match('/^[a-z][a-z0-9\.,\-_]{5,31}$/i', $san_value) ? $san_value : $setting->default;		
	}
	public static function sanitize_telegram( $value, $setting ) {
		$san_value = preg_replace('/[^A-Za-z0-9_]/', '', $value);

		$n = strlen($san_value);
		return ($n >= 5 && $n <= 32) ? $san_value : $setting->default;		
	}
	public static function sanitize_postal_index( $value, $setting ) {
		$postal_index = absint($value);
		
		return (5 === strlen($postal_index)) ? $postal_index : $setting->default;
	}
	
	public static function validate_member_count( $validity, $value ) {
		$member_count = (int)$value;
		if ( $member_count < 0 ) {
			//$validity->add( 'member_count', 'Postal indexMember count has to be greate then 0'); 
		} 
		return $validity;
	}	
	
	public static function validate_postal_index( $validity, $value ) {
		$postal_index = (int)$value;
		if ( $postal_index < 0 ) {
			$validity->add( 'postal_index', 'Postal index has to be greate then 0.' );
		} else if ($postal_index > 99999 ) {
			$validity->add( 'postal_index', 'Postal index has to be less then 999999.' );
		} else if ( strlen($postal_index) != 5 ) {
			$validity->add( 'postal_index', 'Postal index has to be 5 symbol length.' );			
		}
		return $validity;
	}		
	public static function validate_skype_name( $validity, $value ) {
		if ( !empty( $value ) ) {
			if (!preg_match('/^[a-z][a-z0-9\.,\-_]{5,31}$/i', $name)) {
				$validity->add( 'skype', ( 'Skype name is not valid.' ) );
			}
		}
		$validity->add( 'skype', ( 'Skype name is not valid.' ) );
		return $validity;
	}
		
	public static function validate_phone_number( $validity, $value ) {
		$value = trim($value);
		if ( !empty( $value ) ) {
			$tel = preg_replace('/[^0-9]/', '', $value);
			if ( empty($tel) ) {
				$validity->add( 'phone', ( 'Phone number is not valid.' ) );
			} else if (strlen($tel) == 12) {
				if (strpos( $value, '+') !== 0 ) {
					$validity->add( 'phone', ( 'Phone number is not valid.' ) );
				}
			} else {
				$validity->add( 'phone', ( 'Phone number is not valid.' ) );
			}
		}
		return $validity;
	}
}
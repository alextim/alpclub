<?php
/*
Plugin Name: AT Contact Info
Plugin URI: 
Description: Declares a plugin that manage contact info
Version: 1.0
Author: Alex Tim
Author URI: 
License: GPLv2
*/
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
require_once( plugin_dir_path( __FILE__ ) . '/inc/defaults.php' );

//require_once( plugin_dir_path( __FILE__ ) . '/inc/class-customizer.php' );
//require_once( plugin_dir_path( __FILE__ ) . '/inc/class-contact-info-widget.php' );

add_shortcode( 'at_contact_phone_1',      function() { return AT_Contact_Info::get_tel_a(AT_Contact_Info::get_phone_1()); } );
add_shortcode( 'at_contact_email_1',      function() { return AT_Contact_Info::get_email_a(AT_Contact_Info::get_email_1()); } );
add_shortcode( 'at_contact_opening_time', function() { return AT_Contact_Info::get_opening_time(); } );

add_shortcode( 'at_contact_vcard', function($atts = []) {
	$atts = array_change_key_case((array)$atts, CASE_LOWER);	

	// override default attributes with user attributes
	$wporg_atts = shortcode_atts([ 'part' => 'all', ], $atts);
								 
	$part = sanitize_text_field($wporg_atts['part']);	
	return AT_Contact_Info::get_vcard($part);
} );

final class AT_Contact_Info {
	private static function get_option(string $name) : string {
		//return surya_chandra_get_option( $name );
		$defaults = at_contact_info_default_options();
		return $defaults[$name];
	}

	private static function get_company_name()      : string { return self::get_option( 'company_name' ); }	
	private static function get_street_address_1()  : string { return self::get_option( 'street_address_1' ); }	
	private static function get_street_address_2()  : string { return self::get_option( 'street_address_2' ); }	
	private static function get_city()              : string { return self::get_option( 'city' ); }	
	private static function get_postal_index()      : string { return self::get_option( 'postal_index' ); }	
	private static function get_country()           : string { return self::get_option( 'country' ); }	
	
	public static function get_address_inline() : string {
		$output = '';
		
		$street_address_1 = self::get_street_address_1();
		if ( !empty($street_address_1) ) {
			if ( !empty($output) ) {
				$output .= '&nbsp;';
			}
			$output .= $street_address_1;
		}
		
		$street_address_2 = self::get_street_address_2();
		if ( !empty($street_address_2) ) {
			if ( !empty($output) ) {
				$output .= '&nbsp;';
			}
			$output .= $street_address_2;
		}
		
		$city = self::get_city();
		if ( !empty($city) ) {
			if ( !empty($output) ) {
				$output .= '&nbsp;';
			}		
			$output .= $city;
		}	
		
		$country = self::get_country();
		if ( !empty($country) ) {
			if ( !empty($city) ) {
				$output .= ',';
			}			
			if ( !empty($output) ) {
				$output .= '&nbsp;';
			}		
			$output .= $country;
		}
		return $output;	
	}
	
	public static function get_phone_1() : string  { return self::get_option( 'phone_1' ); }	
	public static function get_email_1() : string  { return self::get_option( 'email_1' ); }
	
	
	public static function get_vcard( $part = 'all' ) : string {
		
		if ( $part == 'all' ) {
			$output = self::get_address();
			$output .= self::get_communication();
		} else if ( $part == 'addr' ) {
			$output = self::get_address();
		} else if ( $part == 'comm' ) {
			$output = self::get_communication();
		} else {
			$output = '';
		}
		
		return ('' === $output) ? '' : '<address class="vcard">' . $output . '</address>';
	}
	
	public static  function get_address() : string  {

		$company_name 		= self::get_company_name();
		$street_address_1	= self::get_street_address_1();
		$street_address_2	= self::get_street_address_2();
		$city				= self::get_city();
		$postal_index		= self::get_postal_index();
		$country			= self::get_country();
		
		$output = '';

		if ( $company_name ) {
			$output .= '<div class="org">' .  esc_html($company_name) . '</div>';
		}	
		
		if ( $street_address_1 || $street_address_2 || $city || $postal_index || $country ) {
			$output .= '<div class="adr">';
			
			if ( $street_address_1 || $street_address_2) {
				
				if ( $street_address_1 ) {
					$output .= '<div class="street-address">' . esc_html($street_address_1) . '</div>';
				}
				if ( $street_address_2 ) {
					$output .= '<div class="extended-address">' . esc_html($street_address_2) . '</div>';
				}
			}
			
			if ( $city ) {
				$output .= '<span class="locality">' . esc_html($city)  . '</span>&nbsp;';
			}

			$postal_index = absint( $postal_index );
			if ( $postal_index ) {
				$output .= '<span class="postal-code">' . $postal_index . '</span>';
			}
			if ( $country ) {
				$output .= '<div class="country-name">' . esc_html($country) . '</div>';
			}	
			
			$output .= '</div>';
		}
	
		return $output;
	}
	
	public static function get_communication()  : string {

		$phone_1 = self::get_phone_1();
		$phone_2 = self::get_option( 'phone_2' );
		$phone_3 = self::get_option( 'phone_3' );
		$fax     = self::get_option( 'fax' );
		
		$email_1 = self::get_email_1();
		$email_2 = self::get_option( 'email_2' );
		
		$skype	 = self::get_option( 'skype' );
		$whatsapp= self::get_option( 'whatsapp' );
		$tg	     = self::get_option( 'tg' );
		$viber	 = self::get_option( 'viber' );
		
		
		$url	 = self::get_option( 'url' );
		
		$output = '';
		
		if( $phone_1 || $phone_2 || $phone_3 ) {
			
			$before = '<div>';
			$after = '</div>';
			
			$s1 =  self::get_tel_a( $phone_1, 'tel', $before, $after );
			$s1 .=  self::get_tel_a( $phone_2, 'tel', $before, $after );
			$s1 .=  self::get_tel_a( $phone_3, 'tel', $before, $after );
			if (!empty($s1) ) {
				$output =  '<div class="communication-row">' . 
						'<div class="communication-icon"><i class="fa fa-phone"></i></div>' . 
						 '<div class="communication-data">' . $s1;
				$output .=  '</div></div>';		 
			}
		}
		
		if ( $fax ) {
			$before = '<div class="communication-row">';		
			$before .= '<div class="communication-icon"><i class="fa fa-fax"></i></div>';
			$before .= '<div class="communication-data">';
			
			$after = '</div></div>';

			$output .=  self::get_tel_a( $fax, $before, $after, 'fax' );
		} 

	
		if( $email_1 || $email_2 ) {
			$before = '<div>';
			$after = '</div>';

			$s2 =  self::get_email_a( $email_1, 'email', $before, $after );
			
			$s2 .=  self::get_email_a( $email_2, 'email', $before, $after );
			
			if (!empty($s2) ) {
				$output .=  '<div class="communication-row">';
				$output .=  '<div class="communication-icon"><i class="fa fa-envelope-o"></i></div>';
				$output .=  '<div  class="communication-data">';				
				$output .= $s2;
				$output .=  '</div></div>';
			}

		}

		if ( $skype || $whatsapp || $viber || $tg) {
			$before =  '<span class="communication-messenger">';
			$after =  '</span>';

			$output .=  '<div class="communication-row">';
			$output .=  '<div class="communication-icon"></div>';
			
			$output .=  self::get_skype_a( $skype, 'url', $before, $after);
			$output .=  self::get_whatsapp_a( $whatsapp, 'url', $before, $after);
			$output .=  self::get_telegram_a( $tg, 'url', $before, $after);
			$output .=  self::get_viber_a( $viber, 'url', $before, $after);

			$output .=   '</div>';
		} 
		
		if ( $url )  {
			$output .=  '<div class="communication-row">';
			$output .=  '<div class="communication-icon"><i class="fa fa-link"></i></div>';
			$output .=  '<div  class="communication-data">';

			$output .=  '<a class="url" href="' . esc_url($url) . '">' . self::ulr_to_domain($url). '</a>';  

			$output .=  '</div></div>';
		} 		
		
		return ('' === $output) ? '' : '<div class="communication-info">' . $output . '</div>';
	}
	
	public static function get_email_a( $content, $class = '', $before = '', $after = '' ) : string {
		if ( !is_email( $content ) ) {
			return '';
		}

		$email_link = sprintf( 'mailto:%s', antispambot($content) );
		
		if (!empty($class)) {
			$class = ' class="' . $class . '" ';
		}

		return $before . sprintf( '<a %s href="%s">%s</a>', $class, $email_link, antispambot($content) ) . $after;
	}
	
	public static function get_whatsapp_a( $content, $class, $before, $after ) : string  {
		if ( empty( $content ) ) {
			return '';
		}
		$content = '+' . $content;
		return self::get_m_a( 'whatsapp', 'whatsapp://send?phone=%s', $content, $class, $before, $after );
	}
	
	public static function get_telegram_a( $content, $class, $before, $after ) : string {
		return self::get_m_a( 'tg', 'tg://resolve?domain=%s', $content, $class, $before, $after, 'telegram' );
	}
	
	public static function get_viber_a( $content, $class, $before, $after ) : string {
		if ( empty( $content ) ) {
			return '';
		}
		if (!wp_is_mobile()) {
			$content = '+' . $content;
		} 
		return self::get_m_a( 'viber', 'viber://add?number=%s', $content, $class, $before, $after, '', 'v' );
		
	}
	public static function get_skype_a( $content, $class, $before, $after, $fa = '', $text = '' ) : string {
		if ( empty( $content ) ) {
			return '';
		}
		return self::get_m_a( 'skype', 'skype:%s?call', $content, $class, $before, $after, $fa, $text );
	}		
	private static function get_m_a( $protocol, $link_template, $content, $class, $before, $after, $fa = '', $text = '') : string {
		$link = sprintf( $link_template, $content );
		
		if ( !empty($class) ) {
			$class = sprintf(' class="%s" ', $class);
		}
		
		if ( empty($text) ) {
			if (empty($fa)) {
				$fa = $protocol;
			}
			$text = sprintf('<i class="fa fa-%s"></i>', $fa);
		}

		return $before . sprintf( '<a %s href="%s">%s</a>', $class, esc_url( $link, [$protocol] ), $text) . $after;
	}
	
	public static function get_tel_a( $phone, $class = '', $before = '', $after = '', $href = '' ) : string {
		if ( empty($phone) ) {
			return '';
		}		
		if ( empty($href) ) {
			$href = 'tel';
		}
		if ( !empty($class) ) {
			$class = ' class="' . $class . '" ';
		}
		return $before. '<a ' . $class . '  href="' . $href . ':+' . $phone . '">' . self::format_phone($phone) . '</a>' . $after;
	}
	
	private static function format_phone($phone) : string {
		return sprintf( '+%s (%s) %s-%s-%s',
              substr($phone,  0, 3),
              substr($phone,  3, 2),
              substr($phone,  5, 3),
              substr($phone,  8, 2),
              substr($phone, 10, 2));
	}
	
	//
	//https://stackoverflow.com/questions/9364242/how-to-remove-http-www-and-slash-from-url-in-php
	//
	private static function ulr_to_domain ( $input  ) : string {
		// in case scheme relative URI is passed, e.g., //www.google.com/
		$input = trim($input, '/');

		// If scheme not included, prepend it
		if (!preg_match('#^http(s)?://#', $input)) {
			$input = 'http://' . $input;
		}

		$urlParts = parse_url($input);

		// remove www
		return preg_replace('/^www\./', '', $urlParts['host']);
	}

	public static function get_opening_time() : string {
		
		$values = [];
		
		for ($i = 1; $i <= 7; $i++ ) {
			$val = self::get_option( 'opening_time_' . $i );
			if ( isset($val) && !is_null($val) && !empty($val) )
				$values[$i] = $val;
		}
		
		if ( empty($values) )
			return '';
		
		$output = '<div>';
		foreach ( $values as $val ) {
			$output .=  esc_html( $val );
			$output .=  '<br/>';			
		}
		$output .=  '</div>';
		
		return $output;
	}
}
<?php
/*
Plugin Name: AT Person
Plugin URI: 
Description: Declares a plugin that will create a custom post type "person"
Version: 1.0
Author: Alex Tim
Author URI: 
License: GPLv2
*/
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function AT_Person() {
	return AT_Person::get_instance();
}
AT_Person();	


final class AT_Person {
	private static $instance;
	
	public static function get_instance() {
        if ( null == self::$instance ) {
			self::$instance = new self;
        }
        return self::$instance;
    } 	
	
	private function __construct() {
		$this->define_constants();
		$this->includes();
		$this->init_hooks();
	}
	
	private function define_constants() {
		define( 'AT_PERSON_POST_TYPE', 'person' );
		define( 'AT_PERSON_PLUGIN_FILE', __FILE__ );
		define( 'AT_PERSON_PLUGIN_DIR', untrailingslashit( dirname( AT_PERSON_PLUGIN_FILE ) ) );	
		define( 'AT_PERSON_ABSPATH', dirname( __FILE__ ) . '/' );
	}
	
	private function includes() {
		require AT_PERSON_ABSPATH . '/inc/class-post-types.php';
		require AT_PERSON_ABSPATH . '/inc/class-taxonomies.php';

		require AT_PERSON_ABSPATH . '/inc/class-person.php';
		
		if ( is_admin() ) {
			require AT_PERSON_ABSPATH . '/inc/admin/admin-helper.php';
			require AT_PERSON_ABSPATH . '/inc/admin/class-admin-metaboxes.php';
		}
	}
	
	private function init_hooks() {
		
		register_activation_hook( __FILE__, function () {
			$posts = new AT_Person_Post_Types();
			$posts::init();
			
			$taxonomy = new AT_Person_Taxonomies();
			$taxonomy::init();
			
			flush_rewrite_rules();
		});
		
		add_action( 'init', array( 'AT_Person_Post_Types', 'init' ) );
		add_action( 'init', array( 'AT_Person_Taxonomies', 'init' ) );
	
		if ( is_admin() ) {
			$mb = new AT_Person_Admin_Metaboxes();
		} 
	}
}
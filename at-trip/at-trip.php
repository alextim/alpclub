<?php
declare(strict_types=1);
/*
Plugin Name: AT Trip
Plugin URI: 
Description: Declares a plugin that will create a custom post type
Version: 1.0
Author: Alex Tim
Author URI: 
License: GPLv2
*/
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function AT_Trip() {
	return AT_Trip::get_instance();
}
AT_Trip();

final class AT_Trip {
	private static $instance = null;
	
	public static function get_instance() {
        if ( null === self::$instance ) {
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
		define( 'AT_TRIP_POST_TYPE', 'trip' );
		
		define( 'AT_TRIP_PLUGIN_FILE', __FILE__ );
		define( 'AT_TRIP_PLUGIN_DIR', untrailingslashit( dirname( AT_TRIP_PLUGIN_FILE ) ) );
		define( 'AT_TRIP_ABSPATH', dirname( __FILE__ ) . '/' );

	}
	
	private function includes() {

		require AT_TRIP_ABSPATH . '/inc/class-post-types.php';
		require AT_TRIP_ABSPATH . '/inc/class-taxonomies.php';
		require AT_TRIP_ABSPATH . '/inc/class-trip-tab.php';
		require AT_TRIP_ABSPATH . '/inc/class-trip.php';
		//include AT_TRIP_ABSPATH . '/inc/class-frontend-assets.php';

		require AT_TRIP_ABSPATH . '/inc/currencies.php';
		require AT_TRIP_ABSPATH . '/inc/helpers.php';

		require AT_TRIP_ABSPATH . '/inc/lib/at-num-form.php';
		
		if ( is_admin() ) {
			require AT_TRIP_ABSPATH . '/inc/admin/admin-helper.php';
			require AT_TRIP_ABSPATH . '/inc/admin/class-admin-metaboxes.php';
			require AT_TRIP_ABSPATH . '/inc/admin/class-admin-assets.php';
		}
	}
	
	private function init_hooks() {
		
		register_activation_hook( __FILE__, function () {
			$posts = new AT_Trip_Post_Types();
			AT_Trip_Post_Types::init();
			
			$taxonomy = new AT_Trip_Taxonomies();
			$taxonomy::init();
			
			flush_rewrite_rules();
		});
		
		add_action( 'init', [ 'AT_Trip_Post_Types', 'init' ] );
		add_action( 'init', [ 'AT_Trip_Taxonomies', 'init' ] );
		
		if ( is_admin() ) {
			$mb = new AT_Trip_Admin_Metaboxes();
		}
	}
}
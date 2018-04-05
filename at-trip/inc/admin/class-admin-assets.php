<?php

new AT_Trip_Admin_Assets();


class AT_Trip_Admin_Assets {
	var $assets_path;
	private $suffix;
	
	public function __construct() {
		$this->assets_path = plugin_dir_url( AT_TRIP_PLUGIN_FILE );
		$this->suffix = ''; //'.min';
		
		add_action( 'admin_enqueue_scripts', array( $this, 'styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'scripts' ) );
		
	}
	
	function styles( $hook ) {
		global $post_type;

		if ( ( 'post.php' == $hook || 'post-new.php' == $hook ) && ( AT_TRIP_POST_TYPE == $post_type ) ) {
			wp_enqueue_style('jquery-ui-css', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');

			wp_enqueue_style( 'trip-tabs', $this->assets_path . 'assets/css/tabs' . '' . '.css', array() );
		}
	}

	function scripts( $hook ) {
		global $post_type;

		if ( ( 'post.php' == $hook || 'post-new.php' == $hook ) && ( AT_TRIP_POST_TYPE == $post_type ) ) {
			/*
			wp_enqueue_script('jquery');
			wp_enqueue_script('jquery-ui-core');
			wp_enqueue_script('jquery-ui-datepicker');
			*/
			
			wp_enqueue_script(
				'at-trip-back-end',
				$this->assets_path . 'assets/js/at-trip-back-end.js',
				array( 'jquery', 'jquery-ui-core', 'jquery-ui-datepicker' ),
				null,
				true
			);
		}
	}
}
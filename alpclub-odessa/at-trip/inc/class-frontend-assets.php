<?php
class AT_Trip_Frontend_Assets {
	var $assets_path;
	public function __construct() {
		$this->assets_path = plugin_dir_url( AT_TRIP_PLUGIN_FILE );
		add_action( 'wp_enqueue_scripts', array( $this, 'styles' ) );
//		add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ) );
	}

	function styles() {
		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		wp_enqueue_style( 'trip-tabs', $this->assets_path . 'assets/css/accordion' . '' . '.css', array() );
		wp_enqueue_style( 'trip-frontend', $this->assets_path . 'assets/css/trip-frontend' . '' . '.css', array() );
	}
	function scripts() {
	}
}

new AT_Trip_Frontend_Assets();
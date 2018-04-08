<?php
/*
Plugin Name: AT Lib
Plugin URI: 
Description: Declares a plugin that download lib
Version: 1.0
Author: Alex Tim
Author URI: 
License: GPLv2
*/
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


define( 'AT_LIB_ABSPATH', dirname( __FILE__ ) . '/' );
	
//if ( is_admin() || is_customize_preview() ) {
	require AT_LIB_ABSPATH . '/inc/class-sanitize.php';
//}

require AT_LIB_ABSPATH . '/inc/at-num-form.php';
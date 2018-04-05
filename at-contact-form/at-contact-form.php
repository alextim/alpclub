<?php
/*
Plugin Name: AT Contact Form
Plugin URI: 
Description: Declares a plugin that manage contact Form
Version: 1.2
Author: Alex Tim
Author URI: 
License: GPLv2
*/
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $at_contact_form_db_version;
$at_contact_form_db_version = '1.2';

function AT_Contact_Form() {
	return AT_Contact_Form::get_instance();
}
AT_Contact_Form();
final class AT_Contact_Form {
	private static $instance = null;
	
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
		define( 'AT_CF_PLUGIN_FILE',  __FILE__ );
		define( 'AT_CF_PLUGIN_URL',   plugin_dir_url( __FILE__ ) );
		define( 'AT_CF_PLUGIN_NAME',  'AT_Contact_Form' );
		define( 'AT_CF_DB_VERSION',   'at_contact_form_db_version' );
		define( 'AT_CF_TABLE_NAME',   'at_contact_form' );
		define( 'AT_CF_PLUGIN_DIR',   untrailingslashit( dirname( AT_CF_PLUGIN_FILE ) ) );
		define( 'AT_CF_ABSPATH',      dirname( __FILE__ ) . '/' );
		
		define( 'AT_CF_OPTIONS_NAME', 'at_contact_form_options');
		
	}
	
	private function includes() {
		require AT_CF_ABSPATH . '/inc/recaptcha.php';
		require AT_CF_ABSPATH . '/inc/class-process-form.php';
	
		if ( is_admin() ) {
			if (!class_exists('WP_List_Table')) {
				require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
			}			
			require AT_CF_ABSPATH . '/inc/class-admin.php';
			require AT_CF_ABSPATH . '/inc/class-admin-tables.php';
			require AT_CF_ABSPATH . '/inc/class-admin-message-list.php';
			require AT_CF_ABSPATH . '/inc/class-admin-address-book-list.php';
		}
	}
	
	private function init_hooks() {
		register_activation_hook( __FILE__, [&$this, 'install']);
		register_uninstall_hook( __FILE__, [AT_CF_PLUGIN_NAME, 'uninstall'] );
		
		add_action( 'plugins_loaded', [&$this, 'update_db_check'] );		
		if ( is_admin() ) {
			new AT_Contact_Form_Admin();
			new AT_Contact_Form_Admin_Tables();
		}
	}
	
	function update_db_check() {
		global $at_contact_form_db_version;
		if ( get_site_option( AT_CF_DB_VERSION ) != $at_contact_form_db_version ) {
			$this->install();
		}
	}	
	
	function install() {
		global $at_contact_form_db_version;

		$installed_ver = get_option( AT_CF_DB_VERSION );

		if ( $installed_ver != $at_contact_form_db_version ) {
			global $wpdb;

			$table_name = $wpdb->prefix . AT_CF_TABLE_NAME;
				
			$charset_collate = $wpdb->get_charset_collate();

			$sql = "CREATE TABLE IF NOT EXISTS $table_name (
				id          INT UNSIGNED NOT NULL AUTO_INCREMENT,
				time        TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
				src_post_id BIGINT(20) UNSIGNED DEFAULT 0,
				first_name  VARCHAR(60)  NOT NULL,
				last_name   VARCHAR(30),
				phone       VARCHAR(15),
				email       VARCHAR(50)  NOT NULL,
				subject     VARCHAR(100) NOT NULL,
				message     TEXT         NOT NULL,
				PRIMARY KEY (id),
				KEY time (time), 
				KEY src_post_id (src_post_id), 
				KEY email (email)
			) $charset_collate;";

			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta( $sql );

			update_option( AT_CF_DB_VERSION, $at_contact_form_db_version );
		}		
	}
	static function uninstall() {
		global $wpdb;
		$table_name = $wpdb->prefix . AT_CF_TABLE_NAME;
		$wpdb->query( sprintf('DROP TABLE IF EXISTS %s', $table_name ) );

		delete_option( AT_CF_DB_VERSION );
		delete_option( AT_CF_OPTIONS_NAME );
	}
}	
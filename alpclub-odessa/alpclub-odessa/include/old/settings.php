<?php
add_action( 'admin_menu', 'aco_add_admin_menu' );
add_action( 'admin_init', 'aco_settings_init' );


function aco_add_admin_menu(  ) { 

	add_options_page( 'alpclub-odessa', 'alpclub-odessa', 'manage_options', 'alpclub-odessa', 'aco_options_page' );

}


function aco_settings_init(  ) { 

	register_setting( 'pluginPage', 'aco_settings' );

	add_settings_section(
		'aco_pluginPage_section', 
		__( 'Your section description', 'wordpress' ), 
		'aco_settings_section_callback', 
		'pluginPage'
	);

	add_settings_field( 
		'aco_text_field_0', 
		__( 'Settings field description', 'wordpress' ), 
		'aco_text_field_0_render', 
		'pluginPage', 
		'aco_pluginPage_section' 
	);

	add_settings_field( 
		'aco_text_field_1', 
		__( 'Settings field description', 'wordpress' ), 
		'aco_text_field_1_render', 
		'pluginPage', 
		'aco_pluginPage_section' 
	);

	add_settings_field( 
		'aco_select_field_2', 
		__( 'Settings field description', 'wordpress' ), 
		'aco_select_field_2_render', 
		'pluginPage', 
		'aco_pluginPage_section' 
	);


}


function aco_text_field_0_render(  ) { 

	$options = get_option( 'aco_settings' );
	?>
	<input type='text' name='aco_settings[aco_text_field_0]' value='<?php echo $options['aco_text_field_0']; ?>'>
	<?php

}


function aco_text_field_1_render(  ) { 

	$options = get_option( 'aco_settings' );
	?>
	<input type='text' name='aco_settings[aco_text_field_1]' value='<?php echo $options['aco_text_field_1']; ?>'>
	<?php

}


function aco_select_field_2_render(  ) { 

	$options = get_option( 'aco_settings' );
	?>
	<select name='aco_settings[aco_select_field_2]'>
		<option value='1' <?php selected( $options['aco_select_field_2'], 1 ); ?>>Option 1</option>
		<option value='2' <?php selected( $options['aco_select_field_2'], 2 ); ?>>Option 2</option>
	</select>

<?php

}


function aco_settings_section_callback(  ) { 

	echo __( 'This section description', 'wordpress' );

}


function aco_options_page(  ) { 
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

	 
		// add error/update messages
	 
		// check if the user have submitted the settings
		// wordpress will add the "settings-updated" $_GET parameter to the url
		if ( isset( $_GET['settings-updated'] ) ) {
			 // add settings saved message with the class of "updated"
			add_settings_error( 'wporg_messages', 'wporg_message', __( 'Settings Saved', $this->settings_page_name ), 'updated' );
		}
		 
		// show error/update messages
		settings_errors( 'wporg_messages' );
	?>
	<form action='options.php' method='post'>

		<h2>alpclub-odessa</h2>

		<?php
		settings_fields( 'pluginPage' );
		do_settings_sections( 'pluginPage' );
		submit_button();
		?>

	</form>
	<?php

}

?>




$my_settings = new ACOSettings();	
$my_settings = null;

class ACOSettings {
	private $settings_page_name = 'wporg';
	
	private $address_options_name = "wporg_address_options";
	private $communication_options_name = "wporg_communication_options";	
	private $social_options_name = "wporg_social_options";

    public function __construct() {
		add_action( 'admin_init', array(&$this, 'settings_init') );
		add_action( 'admin_menu', array(&$this, 'options_page') );
    }	
	
	public function settings_init() {
		
		$fields = [
				['wporg_field_street_address_1',  'Street address 1'],
				['wporg_field_street_address_2',  'Street address 2'],
				['wporg_field_city',           'City'],
				['wporg_field_postal_index',     'Postal Index'],
				['wporg_field_country',        'Country'],
			];
		$this->create_section( $fields, 
			'address_settings_section', 'Address Options', 'wporg_section_address_cb', 
			$this->address_options_name, 'address_field_text_cb', 
			'text_sanitize_cb');	

		
		$fields = [
				['wporg_field_phone1',  'Phone 1'],
				['wporg_field_phone2',  'Phone 2'],
				['wporg_field_fax',  'Fax'],
				['wporg_field_skype',  'Skype'],
				['wporg_field_email',  'E-mail'],
			];
		
		$this->create_section( $fields, 
			'communication_settings_section', 'Communication Options', 'wporg_section_communication_cb', 
			$this->communication_options_name, 'communication_field_text_cb',
			'text_sanitize_cb' );	

		$fields = [
				['wporg_field_facebook',  'Facebook'],

			];
		
		$this->create_section( $fields, 
			'social_settings_section', 'Social Options', 'wporg_section_social_cb', 
			$this->social_options_name, 'social_field_text_cb', 
			'section_social_sanitize_cb' );	
	}
 /**
 * Sanitization callback for the social options. Since each of the social options are text inputs,
 * this function loops through the incoming option and strips all tags and slashes from the value
 * before serializing it.
 *	
 * @params	$input	The unsanitized collection of options.
 *
 * @returns			The collection of sanitized values.
 */
public function section_social_sanitize_cb( $input ) {
	
	// Define the array for the updated options
	$output = array();
	// Loop through each of the options sanitizing the data
	foreach( $input as $key => $val ) {
	
		if( isset ( $input[$key] ) ) {
			$output[$key] = esc_url_raw( strip_tags( stripslashes( $input[$key] ) ) );
		} // end if	
	
	} // end foreach
	
	// Return the new collection
	return apply_filters( 'section_social_sanitize_cb', $output, $input );
} // end section_social_sanitize_cb		

public function text_sanitize_cb( $input ) {
	// Create our array for storing the validated options
	$output = array();
	
	// Loop through each of the incoming options
	foreach( $input as $key => $value ) {
		
		// Check to see if the current option has a value. If so, process it.
		if( isset( $input[$key] ) ) {
		
			// Strip all HTML and PHP tags and properly handle quoted strings
			$output[$key] = strip_tags( stripslashes( $input[ $key ] ) );
			
		} // end if
		
	} // end foreach
	
	// Return the array processing any additional functions filtered by this action
	return apply_filters( 'text_sanitize_cb', $output, $input );
} // end text_sanitize_cb
	
	
	private function create_section( $fields, $section_name, $section_title, $section_cb, $page_name, $func_cb, $func_sanitize = NULL) {
		if( false == get_option( $page_name ) ) {	
			add_option( $page_name );
		} 		
		
		add_settings_section(
			$section_name,			// ID used to identify this section and with which to register options
			$section_title,					// Title to be displayed on the administration page
			array(&$this, $section_cb),	// Callback used to render the description of the section
			$page_name		// Page on which to add this section of options
		);
		
		foreach( $fields as $item) {
			add_settings_field(
				$item[0], // ID used to identify the field throughout the theme
				$item[1], // The label to the left of the option interface element
				array(&$this, $func_cb),
				$page_name, // The page on which this option will be displayed
				$section_name, // The name of the section to which this field belongs
				 [
				 'label_for' => $item[0],
				 'class' => 'wporg_row',
				 'wporg_custom_data' => 'custom',
				 ]
			);		
		}
		
		if (is_null ($func_sanitize) )
			register_setting( $page_name, $page_name );	
		else
			register_setting( $page_name, $page_name, array(&$this, $func_sanitize) );	
	}

	public function wporg_section_address_cb( $args ) {
		$html = '<p>Input Address Data</p>';
		echo $html;
	}

	public function wporg_section_communication_cb( $args ) {
		$html = '<p>Input how to communicate</p>';
		echo $html;
	}

	public function wporg_section_social_cb( $args ) {
		$html = '<p>Links to social network</p>';
		echo $html;
	}

	public function address_field_text_cb( $args ) {
		$this->field_text_cb( $this->address_options_name, $args);
	}
	
	public function communication_field_text_cb( $args ) {
		$this->field_text_cb( $this->communication_options_name, $args);
	}	
	
	public function social_field_text_cb( $args ) {
		$this->field_text_cb( $this->social_options_name, $args);
	}
	
	private function field_text_cb( $option_name, $args ) {
		$options = get_option( $option_name );
		
		$val = '';
		if ( isset( $options[ $args['label_for'] ] ) ) {
			$val = $options[ $args['label_for'] ];
		}
		$id = esc_attr( $args['label_for'] );

		
		$html = '<input id="' . $id .'" ' .
				'data-custom="' . esc_attr( $args['wporg_custom_data'] ) . '" ' .
				'name="' . $option_name . '[' . $id . ']" ' .
				'type="text" size="40" ' .
				'value="' . $val . '">';
				
		echo $html;
	}
	
	public function options_page() {
		/*
		add_menu_page(
			'WPOrg',
			'WPOrg Options',
			'manage_options',
			$this->settings_page_name,
			array(&$this, 'wporg_options_page_html')
		);
		*/
		add_theme_page(
			'Alpclub "Odessa"', 		// The title to be displayed in the browser window for this page.
			'Alpclub "Odessa"',			// The text to be displayed for this menu item
			'manage_options',			// Which type of users can see this menu item
			$this->settings_page_name,	// The unique ID - that is, the slug - for this menu item
			array(&$this, 'wporg_options_page_html')		// The name of the function to call when rendering this menu's page
	);
	}
	/**
	 * top level menu:
	 * callback functions
	 */
	public function wporg_options_page_html(  $active_tab = '' ) {

		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

	 
		// add error/update messages
	 
		// check if the user have submitted the settings
		// wordpress will add the "settings-updated" $_GET parameter to the url
		if ( isset( $_GET['settings-updated'] ) ) {
			 // add settings saved message with the class of "updated"
			add_settings_error( 'wporg_messages', 'wporg_message', __( 'Settings Saved', $this->settings_page_name ), 'updated' );
		}
		 
		// show error/update messages
		settings_errors( 'wporg_messages' );
		?>
		<div class="wrap">
			<div id="icon-themes" class="icon32"></div>
			
			<h2><?php echo esc_html( get_admin_page_title() );?></h2>
			<?php //settings_errors(); ?>
			
			<?php 
			if( isset( $_GET[ 'tab' ] ) ) {
				$active_tab = $_GET[ 'tab' ];
			} else if( $active_tab == 'address_options' ) {
				$active_tab = 'address_options';
			} else if( $active_tab == 'communication_options' ) {
				$active_tab = 'communication_options';
			} else if( $active_tab == 'social_options' ) {
				$active_tab = 'social_options';
			} else {
				$active_tab = 'communication_options';
			} // end if/else ?>

			
			<h2 class="nav-tab-wrapper">
				<a href="?page=<?php echo $this->settings_page_name; ?>&tab=address_options" class="nav-tab <?php echo $active_tab == 'address_options' ? 'nav-tab-active' : ''; ?>">Address Options</a>
				<a href="?page=<?php echo $this->settings_page_name; ?>&tab=communication_options" class="nav-tab <?php echo $active_tab == 'communication_options' ? 'nav-tab-active' : ''; ?>">Contact Options</a>
				<a href="?page=<?php echo $this->settings_page_name; ?>&tab=social_options" class="nav-tab <?php echo $active_tab == 'social_options' ? 'nav-tab-active' : ''; ?>">Social Options</a>
			</h2>
		
			
			<form action="options.php" method="post">
				<?php
	
					if( $active_tab == 'address_options' ) {
						settings_fields( $this->address_options_name );
						do_settings_sections( $this->address_options_name );
					} else if( $active_tab == 'communication_options' ) {
						settings_fields( $this->communication_options_name );
						do_settings_sections( $this->communication_options_name );
					} else {
						settings_fields( $this->social_options_name );
						do_settings_sections( $this->social_options_name );
					} // end if/else
					
					submit_button(  );
			
				?>				
			</form>
		</div><!-- /.wrap -->
<?php		
	}
}
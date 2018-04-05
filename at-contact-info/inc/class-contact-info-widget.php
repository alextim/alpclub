<?php 
 /**
 * Contact widget
 *
 * Widget Name: Alpclub Odessa Contact Info
 * Description: Displays contact fields from theme options.
 * Author: Alex Tim
 * Author URI: 
 *
 * @package Alpclub_Odessa
 */
 
add_action( 'widgets_init', function() { 
	register_widget( 'Alpclub_Odessa_Contact_Info_Widget' ); 
});
 
class Alpclub_Odessa_Contact_Info_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'alpclub-odessa-contact-widget', // Base ID
			esc_html__( 'Alpclub Odessa: Contact', 'text_domain' ), // Name
			array( 'description' => esc_html__( 'Displays contact: address, phones, opening time', 'text_domain' ), ) // Args
		);
	}
	
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		?>
		<div class="container">
			<div class="row">
			
				<div class="column column-4">
					<?php echo AT_Contact_Info_Contact::get_address(); ?>
				</div>		
				
				<div class="column column-4">
					<?php echo AT_Contact_Info_Contact::get_communication(); ?>
				</div>
				
				<div class="column column-4">
					<?php echo AT_Contact_Info_Contact::get_opening_time(); ?>
				</div>
				
			</div>
		</div>
		<?php
		echo $args['after_widget'];
	}
}
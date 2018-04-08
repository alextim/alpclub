<?php
 /**
 * Person List widget
 *
 * Widget Name: Alpclub Odessa Person List
 * Description: Displays person list by type.
 * Author: Alex Tim
 * Author URI: 
 *
 * @package Alpclub_Odessa
 */
final class Alpclub_Odessa_Person_List_Widget extends WP_Widget {
	function __construct() {
		parent::__construct(
			'alpclub-odessa-person-list-widget', // Base ID
			esc_html__( 'ACO: Person List', 'alpclub-odessa' ), // Name
			array( 'description' => esc_html__( 'Displays persons by type', 'alpclub-odessa' ), ) // Args
		);
	}
	
	public function widget( $args, $instance ) {
		echo $args['before_widget'];

		$person_type = $instance['person_type']; 
		include( get_stylesheet_directory(). '/include/widgets/person_list/tpl/default.php' );
		
		echo $args['after_widget'];
	}
	
	public function form( $instance ) {
		$person_type = '';
		if ( isset($instance['person_type']) && !empty( $instance['person_type'] ) ) {
			$person_type = $instance['person_type'];			
		}
		
		$choices = aco_get_person_type_choices( false );

		?>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'person_type' ) ); ?>"><?php esc_attr_e( 'Person type:', 'text_domain' ); ?></label> 
		
		<select id="<?php echo $this->get_field_id('person_type'); ?>" name="<?php echo $this->get_field_name('person_type'); ?>" class="widefat" style="width:100%;">
			 
			<?php foreach($choices as $key => $item) { ?>
			<option <?php selected( $person_type, $key ); ?> value="<?php echo $key; ?>"><?php echo $item; ?></option>
			<?php } ?>      
		</select>		
		</p>
		<?php 
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['person_type'] = ( ! empty( $new_instance['person_type'] ) ) ? strip_tags( $new_instance['person_type'] ) : '';

		return $instance;
	}
}
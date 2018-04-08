<?php
/**
 * Terms List widget
 *
 * Widget Name: Alpclub Odessa Terms List
 * Description: Displays terms list by custom post type.
 * Author: Alex Tim
 * Author URI: 
 *
 * @package Alpclub_Odessa
 */
final class Alpclub_Odessa_Terms_List_Widget extends WP_Widget {
	
	public function __construct() {
		$widget_ops = array(
			'classname' => 'widget_categories',
			'description' => __( 'A list of terms by post type.' ),
			'customize_selective_refresh' => true,
		);
		parent::__construct( 'alpclub-odessa-terms-list', __( 'ACO: Terms List' ), $widget_ops );
	}

	public function widget( $args, $instance ) {
		static $first_dropdown = true;

		$title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Categories' );

		/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		$c = ! empty( $instance['count'] ) ? '1' : '0';
		$h = ! empty( $instance['hierarchical'] ) ? '1' : '0';
		
		$taxonomy = sanitize_text_field( $instance['taxonomy'] );

		echo $args['before_widget'];

		if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

		$cat_args = array(
			'orderby'      => 'name',
			'show_count'   => $c,
			'hierarchical' => $h,
			'taxonomy' => $taxonomy,
		);
?>
		<ul>
<?php
		$cat_args['title_li'] = '';

		wp_list_categories( apply_filters( 'widget_categories_args', $cat_args, $instance ) );
?>
		</ul>
<?php

		echo $args['after_widget'];
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['count'] = !empty($new_instance['count']) ? 1 : 0;
		$instance['hierarchical'] = !empty($new_instance['hierarchical']) ? 1 : 0;
		$instance['post_type'] = sanitize_text_field($new_instance['post_type']);
		$instance['taxonomy'] = sanitize_text_field($new_instance['taxonomy']);
		
		return $instance;
	}

	private function sanitize_choice($value, $choices) {
		if (empty($value)) {
			if ( !empty($choices) && count($choices) > 0) {
				$value = key(current($choices));
			}
		} else if ( !empty($choices) && count($choices) > 0) {
			if (!array_key_exists($value , $choices)) {
				$value = key(current($choices));
			}
		} else {
			$value = '';
		}	
		return $value;	
	}
	
	public function form( $instance ) {
		//Defaults
		$instance = wp_parse_args( (array) $instance, array( 'title' => '') );
		$title = sanitize_text_field( $instance['title'] );
		$count = isset($instance['count']) ? (bool) $instance['count'] :false;
		$hierarchical = isset( $instance['hierarchical'] ) ? (bool) $instance['hierarchical'] : false;
		
		$post_choices = get_post_types( ['public' => true, '_builtin' => false], 'objects' );
		$post_type = $this->sanitize_choice((isset( $instance['post_type'] ) ? sanitize_text_field($instance['post_type']) : ''), $post_choices);

		$tax_choices = get_object_taxonomies($post_type, 'objects');
		$taxonomy = $this->sanitize_choice(isset( $instance['taxonomy'] ) ? sanitize_text_field($instance['taxonomy']) : '', $tax_choices);

		?>
		<p>
		<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></p>

		<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>"<?php checked( $count ); ?> />
		<label for="<?php echo $this->get_field_id('count'); ?>"><?php _e( 'Show post counts' ); ?></label><br />

		<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('hierarchical'); ?>" name="<?php echo $this->get_field_name('hierarchical'); ?>"<?php checked( $hierarchical ); ?> />
		<label for="<?php echo $this->get_field_id('hierarchical'); ?>"><?php _e( 'Show hierarchy' ); ?></label>
		</p>
		<p>
		<label for="<?php echo $this->get_field_id('post_type'); ?>"><?php _e( 'Post type:' ); ?></label>
		<select id="<?php echo $this->get_field_id('post_type'); ?>" name="<?php echo $this->get_field_name('post_type'); ?>" class="widefat" style="width:100%;">
			<?php foreach($post_choices as $key =>$item) { ?>
			<option <?php selected( $post_type, $key); ?> value="<?php echo $key; ?>"><?php echo $item->label; ?></option>
			<?php } ?>      
		</select>	
		
		<label for="<?php echo $this->get_field_id('taxonomy'); ?>"><?php _e( 'Taxonomy:' ); ?></label>
		<select id="<?php echo $this->get_field_id('taxonomy'); ?>" name="<?php echo $this->get_field_name('taxonomy'); ?>" class="widefat" style="width:100%;">
			<?php foreach($tax_choices as $key => $item) { ?>
			<option <?php selected( $taxonomy, $key ); ?> value="<?php echo $key; ?>"><?php echo $item->label; ?></option>
			<?php } ?>      
		</select>
		</p>
		<?php
	}
}
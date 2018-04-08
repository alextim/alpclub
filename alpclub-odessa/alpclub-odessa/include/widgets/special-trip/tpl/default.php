<?php
/**
 * Widget template
 *
 * @package Alpclub_Odessa
 */
?>
<div class="section section-special-page heading-<?php echo esc_attr( $instance['heading_alignment'] ); ?>">
	<?php
	$trip_id = absint( $instance['special_trip_id'] );
	if ( $trip_id > 0 ) {
		$attr = array(
			'class' => 'align' . esc_attr( $instance['featured_image_alignment'] ),
			);
		$thumbnail = get_the_post_thumbnail( $trip_id, esc_attr( $instance['featured_image'] ), $attr );
		if ( ! empty( $thumbnail ) && 'disable' !== $instance['featured_image'] ) {
			echo wp_kses_post( $thumbnail );
		}
	}
	
	if ( ! empty( $instance['title'] ) ) {
		echo $args['before_title'] . esc_html( $instance['title'] ) . $args['after_title'];
	}

	if ( ! empty( $instance['subtitle'] ) ) {
		echo '<p class="widget-subtitle">' . esc_html( $instance['subtitle'] ). '</p>';
	}

	if ( $trip_id > 0 ) {
		
		$qargs = array(
			'post_type' => AT_TRIP_POST_TYPE,
			'posts_per_page' => 1,
			'page_id'        => $trip_id,
			'no_found_rows'  => true,
			);

		$the_query = new WP_Query( $qargs );
		
		if ( $the_query->have_posts() ) { 
		
			$enable_excerpt = absint( $instance['enable_excerpt'] );
			$enable_dates = absint( $instance['enable_dates'] );
			$enable_price = absint( $instance['enable_price'] );
			$enable_other_info = absint( $instance['enable_other_info'] );

			echo '<div class="special-page-section">';
				
				
				while ( $the_query->have_posts() ) {
					$the_query->the_post(); 
					
					if ($enable_dates || $enable_price || $enable_other_info) {
						$trip = new AT_Trip_Trip();

						echo '<div class="latest-news-meta">';
						
							if ($enable_dates) {
								$trip->print_dates_duration();
							}
							
							if ($enable_other_info) {
								$trip->print_other_info();
							}	

							if ($enable_price) {
								$trip->print_price();
							}	
							
						echo '</div><!-- .latest-news-meta -->';
					}									
						
					if ( $enable_excerpt ) {
						the_excerpt();
					} else {
						the_content();
					}
				}
				
			echo '</div><!-- .special-page-section -->';
		}
	} 
	?>
</div> <!-- .section-special-page -->
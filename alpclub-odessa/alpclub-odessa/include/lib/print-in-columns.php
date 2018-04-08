<?php
function at_print_in_columns(string $title, string $subtitle, string $cpt, array $qargs, int $items_per_row) {
	$heading_alignment = 'center';

	$before_title = '<h3 class="widget-title">';
	$afer_title = '</h3>';

	echo '<div class="section section-' .  $cpt . 's heading-' . $heading_alignment . '">';
		
	if ( ! empty( $title ) ) {
		echo $before_title . esc_html( $title ) . $afer_title; 
	}

	if ( ! empty( $subtitle ) ) {
		echo '<p class="widget-subtitle">' . esc_html( $subtitle ) . '</p>';
	}	
	
	if ( $qargs ) {
		
		$qargs['paged'] = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
		
		$the_query = new WP_Query( $qargs );
		// https://wordpress.stackexchange.com/questions/120407/how-to-fix-pagination-for-custom-loops/120408#120408
		// Pagination fix
		global $wp_query;
		$temp_query = $wp_query;
		$wp_query   = NULL;
		$wp_query   = $the_query;

		if ( $the_query->have_posts() ) {

			echo '<div class="container">';

			$column_class = 'column-' . 12/$items_per_row; 

			$item_counter = 0;
				
			while ( $the_query->have_posts() ) {
				$the_query->the_post();
				
				if ( $item_counter === $items_per_row ) {
					echo '</div><!--.row -->';
					$item_counter = 0;
				}
				if ( 0 === $item_counter ) {
					echo '<div class = "row">';
				}
			
				echo '<div class="column ' . $column_class . '">';
				get_template_part( 'template-parts/' . $cpt . '/content', $cpt );
				echo '</div><!-- .column ' .  $column_class . ' -->';
			 
				$item_counter++;

			} // while 

			if ( 0 !== $item_counter ) {
				echo '</div><!--.row -->';
			}

			echo '</div><!-- .container -->';
				
			wp_reset_postdata();

			the_posts_pagination();

			// Reset main query object
			$wp_query = NULL;
			$wp_query = $temp_query;
			
		} // $the_query->have_posts()
	}
		
	echo '</div><!-- .section -->';
}
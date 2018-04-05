<?php
/*
Theme Name: Alpclub Odessa
Template Name: Archive Trip and Person
Template Post Type: trip, person
*/
get_header();
if ( is_tax() ) {
	$queried_object = get_queried_object();
	if ( $queried_object ) {
		if (!empty($queried_object->description)) {?>

			<div class="container">
				<div class="archive-tax-description">
					<?php echo esc_html($queried_object->description); ?>
				</div>
			</div>
			
	<?php }
	}			
} 
?>
<div id="content" class="site-content">
<?php
/*
<div id="primary" class="content-area">
	<main id="main" class="site-main">
*/	
	if ( have_posts() ) :
	
		$cpt = get_post_type();
		if (AT_TRIP_POST_TYPE === $cpt) {
			$items_per_row = AT_TRIP_ITEMS_PER_ROW;
		} else if (AT_PERSON_POST_TYPE === $cpt) {
			$items_per_row = AT_PERSON_ITEMS_PER_ROW;
		} else {
			echo 'UNKNOWN post_type = "' . $cpt . '"';
			die();
		}
?>	
	<div class="section section-<?php echo $cpt; ?>s">
		<div class="container">
<?php		
		$column_class = 'column-' . 12 / $items_per_row;
		$item_counter = 0;
			
		while ( have_posts() ) : the_post(); 
			
			if ( $item_counter == $items_per_row ) {
				echo '</div><!--.row -->';
				$item_counter = 0;
			}
			if ( 0 == $item_counter ) {
				echo '<div class = "row">';
			}

			echo '<div class="column ' . $column_class . '">';
			get_template_part( 'template-parts/' . $cpt . '/content', $cpt );
			echo '</div><!-- .column ' . $column_class . '-->';

			$item_counter++;

		endwhile; 
		
		if ( 0 != $item_counter ) {
			echo '</div><!--.row -->';
		}
?>
		</div><!-- .container -->
	</div><!-- .section-trips -->
<?php		
		the_posts_pagination();
	endif;
/*
	</main>
</div>
*/
?>
</div><!-- content -->
<?php
get_footer();
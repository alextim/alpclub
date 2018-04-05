<?php
/*
Theme Name:    Alpclub Odessa
Template Name: Single Trip
Template Post Type: trip
*/
get_header(); ?>
<div id="content" class="site-content">
<!--
	<div id="primary" class="content-area">
		<main id="main" class="site-main">
-->	
		<?php while ( have_posts() ) : the_post();?>
		
<article id="trip-<?php the_ID(); ?>" <?php post_class(); ?>>
	
	<div class="entry-content">
		<div class="container">
		
			<div class="row">
				<div class="column column-12">
					<?php surya_chandra_single_post_thumbnail(); ?>	
				</div>
			</div>
			<div class="row">
				<div class="column column-12">
				
					<h2><?php the_title(); ?></h2><br />
					
					<div class="trip-brief">
						<?php
							$trip = new AT_Trip_Trip();
							$trip->print_all_info();
						?>
				

					</div><!-- .trip-brief -->

				</div>
			</div>
			
			<div class="row">
				<div class="column column-12">
					<?php $trip->print_tabs(); ?>
				</div>
			</div>
			
		</div><!-- .container -->
	</div><!-- .entry-content -->
</article>
			
			
		<?php endwhile;  ?>
		<!--
		</main>
	</div
	-->
	</div>
	
<?php
	/**
	 * Hook - surya_chandra_action_sidebar.
	 *
	 * @hooked: surya_chandra_add_sidebar - 10
	 */
	//do_action( 'surya_chandra_action_sidebar' );
	
get_footer();
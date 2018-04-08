<?php
/**
 * Widget template
 *
 * @package Alpclub_Odessa
 */
$enable_dates = absint( $instance['enable_dates'] );
$enable_price = absint( $instance['enable_price'] );

$qargs = [
	'post_type' => AT_TRIP_POST_TYPE,
	'posts_per_page'      => absint( $instance['post_number'] ),
	'no_found_rows'       => true,
];

$sticky_filter = absint($instance['sticky_filter']);
if ( 0 == $sticky_filter ) {
	//
} else  if ( 1 == $sticky_filter ) {
	$qargs['orderby']  = 'meta_value';
	$qargs['meta_key'] = 'trip_sticky';
	$qargs['order']    = 'DESC';
} else if ( 2 == $sticky_filter ) {
	 $qargs['meta_key'] = 'trip_sticky';
	 $qargs['meta_value'] = 1;
}	
else if ( 3 == $sticky_filter ) {
	 $qargs['meta_key'] = 'trip_sticky';
	 $qargs['meta_value'] = 1;
	 $qargs['meta_compare'] = '!=';
} else {
	echo 'unknown';
	die();
}


if ( absint( $instance['activity'] ) > 0 ) {
	$qargs['tax_query'] = [
		[
			'taxonomy' => 'activity',
			'field'    => 'term_id',
			'terms'    => absint( $instance['activity'] ),
		],
	];
}

$the_query = new WP_Query( $qargs );

?>

<aside class="section section-latest-news heading-<?php echo esc_attr( $instance['heading_alignment'] ); ?>">

	<?php if ( ! empty( $instance['title'] ) ) : ?>
		<?php echo $args['before_title'] . esc_html( $instance['title'] ) . $args['after_title']; ?>
	<?php endif; ?>

	<?php if ( ! empty( $instance['subtitle'] ) ) : ?>
		<p class="widget-subtitle"><?php echo esc_html( $instance['subtitle'] ); ?></p>
	<?php endif; ?>

	<?php if ( $the_query->have_posts() ) : ?>

		<div class="latest-news-section latest-news-col-<?php echo absint( $instance['post_column'] ) ?>">
				<div class="inner-wrapper">
					<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

						<div class="latest-news-item latest-news-item-1">
							<div class="latest-news-wrapper">
								<div class="latest-news-thumb">
									<a href="<?php the_permalink(); ?>">
									<?php if ( has_post_thumbnail() ) : ?>
										<?php
										$img_attributes = array( 'class' => 'aligncenter' );
										the_post_thumbnail( esc_attr( $instance['featured_image'] ), $img_attributes );
										?>
									<?php endif; ?>
									</a>
								</div><!-- .latest-news-thumb -->
								<div class="latest-news-text-content">
									<div class="news-meta-wrapper">

										<h3 class="latest-news-title">
											<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
										</h3>
										
										<?php 
										$activity = aco_get_single_trip_activity(); 
										$trip = new AT_Trip_Trip();
										?>
										
										<?php if ($enable_dates || $enable_price || ! empty( $activity )) : ?>
											<div class="latest-news-meta">
											
												<?php if ($enable_dates) : ?>
													<?php $trip->print_dates_duration(); ?>
												<?php endif; ?>

												<?php if ($enable_price) : ?>
													<?php $trip->print_price(); ?>
												<?php endif; ?>	

												<?php if ( ! empty( $activity ) ) : ?>
													<span class="latest-news-category"><a href="<?php echo esc_url( $activity['url'] ); ?>"><?php echo esc_html( $activity['name'] ); ?></a></span>
												<?php endif; ?>
												
											</div><!-- .latest-news-meta -->
										<?php endif; ?>									
		
									</div> <!-- .news-meta-wrapper -->
									
									<?php if ( absint( $instance['excerpt_length'] ) > 0 ) : ?>
										<div class="latest-news-summary">
											<?php
											$excerpt = surya_chandra_the_excerpt( absint( $instance['excerpt_length'] ) );
											echo wp_kses_post( wpautop( $excerpt ) );
											?>
										</div><!-- .latest-news-summary -->
									<?php endif; ?>

									<?php if ( ! empty( $instance['more_text'] ) ) : ?>
										<a href="<?php the_permalink(); ?>" class="more-link"><?php echo esc_html( $instance['more_text'] ); ?></a>
									<?php endif; ?>
								</div><!-- .latest-news-text-content -->
							</div><!-- .latest-news-wrapper -->
						</div><!-- .latest-news-item  -->

					<?php endwhile; ?>

					<?php if ( ! empty( $instance['explore_button_url'] ) && ! empty( $instance['explore_button_text'] ) ) : ?>
						<div class="more-wrapper">
							<a href="<?php echo aco_esc_url2( $instance['explore_button_url'] ); ?>" class="custom-button"><?php echo esc_html( $instance['explore_button_text'] ); ?></a>
						</div><!-- .more-wrapper -->
					<?php endif; ?>
				</div><!-- .inner-wrapper -->
		</div><!-- .latest-news-section -->

	<?php endif; ?>

</aside><!-- .section-latest-news -->

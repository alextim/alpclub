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


<div class="section section-recent-trips heading-<?php echo esc_attr( $instance['heading_alignment'] ); ?>">

	<?php if ( ! empty( $instance['title'] ) ) : ?>
		<?php echo $args['before_title'] . esc_html( $instance['title'] ) . $args['after_title']; ?>
	<?php endif; ?>

	<?php if ( ! empty( $instance['subtitle'] ) ) : ?>
		<p class="widget-subtitle"><?php echo esc_html( $instance['subtitle'] ); ?></p>
	<?php endif; ?>

	<?php if ( $the_query->have_posts() ) : ?>

		<div class="recent-trips-section">
			<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

				<div class="recent-trips-item">
					<div class="recent-trips-wrapper">
						<?php if ( 'disable' !== $instance['featured_image'] ) : ?>
						<?php if ( has_post_thumbnail() ) : ?>
							<div class="recent-trips-thumb">
								<a href="<?php the_permalink(); ?>">
									<?php
									$img_attributes = array(
										'style' => 'max-width:' . esc_attr( $instance['image_width'] ) . 'px;',
										);
									the_post_thumbnail( esc_attr( $instance['featured_image'] ), $img_attributes );
									?>
								</a>
							</div><!-- .recent-trips-thumb -->
						<?php endif; ?>
						<?php endif; ?>

						<div class="recent-trips-text-content">
							<div class="recent-trips-meta-wrapper">

								<h3 class="recent-trips-title">
									<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
								</h3>
								<?php if ($enable_dates || $enable_price) : $trip = new AT_Trip_Trip(); ?>
									<div class="recent-trips-meta">
									<?php 
										if ($enable_dates) {
											$trip->print_dates_duration();
										}
										if ($enable_price) {
											$trip->print_price();
										} 
									?>										
									</div><!-- .recent-trips-meta -->
								<?php endif; ?>
							</div><!-- .news-meta-wrapper -->

						</div><!-- .recent-trips-text-content -->
					</div><!-- .recent-trips-wrapper -->
				</div><!-- .recent-trips-item  -->

			<?php endwhile; ?>

		</div><!-- .recent-trips-section -->

	<?php endif; ?>

</div><!-- .section-recent-trips -->
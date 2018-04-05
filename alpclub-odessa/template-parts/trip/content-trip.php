<?php $trip = new AT_Trip_Trip(); ?>
<div class="trip-item">

<div class="thumb-summary-wrap">
	<?php if ( has_post_thumbnail() ) : ?>
		<div class="trip-thumb">
			<a href="<?php the_permalink(); ?>">
				<?php the_post_thumbnail('medium', array ('class' => 'no-classes' )); ?>
			</a>									
		</div>
	<?php endif; ?>
	

	<div class="trip-text-wrap">
		<h3 class="trip-title">
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		</h3>
		<div class="trip-info">
			<?php $trip->print_all_info(); ?>
		</div>
		<div class="trip-excerpt">
			<?php the_excerpt(); ?>
		</div>
	</div>
</div>	
</div><!-- .trip-item -->
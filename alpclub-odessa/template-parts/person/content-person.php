<?php $helper = new AT_Person_Person(); ?>
<div class="person-item">
	<div class="thumb-summary-wrap">
		<?php if ( has_post_thumbnail() ) : ?>
			<div class="person-thumb">
				<a href="<?php the_permalink(); ?>">
					<?php the_post_thumbnail('medium', array ('class' => 'no-classes' )); ?>
				</a>									
			</div><!-- .person-thumb-->
		<?php endif; ?>
	
		<div class="person-text-wrap">
			<h3 class="person-title">
				<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
			</h3>
			<p class="person-position">
				<?php echo $helper->get_position(); ?>
			</p>
			<p class="person-position">
				<?php echo $helper->get_sport_level(); ?>
			</p>
		</div><!-- .person-text-wrap -->

		<div class="social-links circle">
			<ul>
			<?php $fb = $helper->get_facebook(); ?>
			<?php if (! empty($fb) ) :?>
					<li><a target="_blank" rel="noopener nofollow" href="<?php echo $fb; ?>"><span class="sow-icon-fontawesome" data-sow-icon=""></span></a></li>
			<?php endif; ?>
				<!--
				<li><a href="http://twitter.com"><span class="sow-icon-fontawesome" data-sow-icon=""></span></a></li>
				<li><a href="http://linkedin.com"><span class="sow-icon-fontawesome" data-sow-icon=""></span></a></li>
				-->
			</ul>
		</div><!-- .social-links -->

	
	</div><!-- .thumb-summary-wrap -->
</div><!-- .person-item  -->
<?php
/*
Theme Name:    Alpclub Odessa
Template Name: Single Person
Template Post Type: person
*/
get_header(); ?>
<div id="primary" class="content-area">
	<main id="main" class="site-main">

	<?php while ( have_posts() ) : the_post();?>
		
	<article id="person-<?php the_ID(); ?>" <?php post_class(); ?>>
		
		<div class="entry-content">
			<div class="container">
			
				<div class="row">
					<div class="column column-6">
						<?php surya_chandra_single_post_thumbnail(); ?>
					</div>
					<div class="column column-6">
					
						<h2><?php the_title(); ?></h2><br />
						
						<div class="person-brief">
							<?php

								$helper = new AT_Person_Person();
								
								$person_position  	= $helper->get_position();
								$person_sport_level	= $helper->get_sport_level();

								$person_email	 = $helper->get_email();
								$person_phone	 = $helper->get_phone();
								$person_skype	 = $helper->get_skype();
								$person_facebook = $helper->get_facebook();
								
								if ( !empty($person_position) ) { 
									echo '<p>' . $person_position . '</p>';
								} 
								
								if ( !empty($person_sport_level) ) { 
									echo '<p>' . $person_sport_level . '</p>';
								} 
								
								$contact_info = new AT_Contact_Info();

								echo $contact_info->get_email_a( $person_email, '', '<p><i class="fa fa-envelope-o">&nbsp;</i>', '</p>' );
								echo $contact_info->get_tel_a(   $person_phone, '', '<p><i class="fa fa-phone">&nbsp;</i>',      '</p>' );
								echo $contact_info->get_skype_a( $person_skype, '', '<p><i class="fa fa-skype">&nbsp;</i>',      '</p>', '', $person_skype );
								
								if ( !empty($person_facebook) ) : ?>	
									<div class="social-links circle">
										<ul>
											<?php if (! empty($person_facebook) ) : ?>
												<li>
													<a target="_blank" rel="noopener nofollow" href="<?php echo $person_facebook; ?>">
														<i class="fa fa-facebook"></i>
													</a>
												</li>
											<?php endif; ?>
											<?php
	/*										
	<span class="sow-icon-fontawesome" data-sow-icon=""></span>
											<li><a href="http://twitter.com"><span class="sow-icon-fontawesome" data-sow-icon=""></span></a></li>
											<li><a href="http://linkedin.com"><span class="sow-icon-fontawesome" data-sow-icon=""></span></a></li>
	*/
	?>										
										</ul>
									</div><!-- .social-links -->
								<?php endif; ?>
						</div><!-- .person-brief -->
					</div>
				</div>
				
				<div class="row">
					<div class="column column-12">
						<?php the_content(); ?>
					</div>
				</div>
				
			</div><!-- .container -->
		</div><!-- .entry-content -->
	</article>
			
			
	<?php endwhile;  ?>
	</main><!-- #main -->
</div><!-- #primary -->
	
<?php
	/**
	 * Hook - surya_chandra_action_sidebar.
	 *
	 * @hooked: surya_chandra_add_sidebar - 10
	 */
	do_action( 'surya_chandra_action_sidebar' );
	
get_footer();
<?php
/*
Theme Name:    Alpclub Odessa
Template Name: Single Trip
Template Post Type: trip
*/
/*
if (class_exists('AT_Process_ContactForm')) {
	$at_cf = new AT_Process_ContactForm(true, true); 
	if ( $at_cf->is_submit_enabled() ) {
		wp_enqueue_style('aco-contact_form', get_stylesheet_directory_uri() . '/css/contact-form.css' );
	}
}
*/
get_header(); 

while ( have_posts() ) {
	the_post();
	$trip = new AT_Trip_Trip();
?>		
	<div class="container single-trip">
		<div class="row">
			<div class="column column-7">
				<?php surya_chandra_single_post_thumbnail(); ?>
			</div>

			<div class="column column-5">
				<div class="container">
					<h2><?php the_title(); ?></h2>
					<div class="trip-brief">
						<?php $trip->print_all_info(); ?>
					</div><!-- .trip-brief -->
					<div>
						<?php $trip->print_registration_form('Регистрация', 'reg-form-button', 'custom-button reg-form-button' ); ?>
					</div>
				</div>
			
<?php 
/*
				<div class="container">
					<div class="row">
						<div class="column column-12">
							<h2><?php the_title(); ?></h2>
						</div>
					</div>
					<div class="row">
						<div class="column column-8">
							<div class="trip-brief">
								<?php $trip->print_all_info(); ?>
							</div><!-- .trip-brief -->
						</div>
						<div class="column column-4">
							<?php $trip->print_registration_form('Регистрация', 'custom-button' ); ?>
						</div>
					</div>
				</div>
*/
?>			
			</div>
		</div>
		
<?php			
		$tabs = $trip->get_tabs();
		if ($tabs) :
/*					
			$form_is_active = false;
			
			if (class_exists('AT_Process_ContactForm')) {
				if ( $at_cf->is_submit_enabled() ) {
					if( isset($_POST['submitted'])) {
						$form_is_active = true;
					}							
					global $post;
					$at_cf->set_fixed_subject($post->post_title);
					if ($at_cf->process_data()) {

						ob_start();
						$at_cf->render_form();
						$contact_form_html = ob_get_contents();
						ob_end_clean();			
						
						$tabs[] = new AT_Trip_Tab( 'reg-form-tab', 'Записаться', $contact_form_html, 'reg-form-tab' );
						
					}
				}
			}
*/					
?>
			<div class="row">
				<div class="column column-12">
					<div class="tabs">
					<?php $is_active = true;
						foreach( $tabs as $tab ) :
							//if ($form_is_active) {
							//	$tab->render( 'reg-form-tab' === $tab->id );
							//} else {
								$tab->render( $is_active );
								if ( $is_active ) {
									$is_active = false;
								}
							//}
						endforeach;
					?>
					</div>
				</div>
			</div>
<?php 	endif;
		
		echo aco_get_social_buttons();
?>
	</div><!-- .container -->
<?php 
}
get_footer();
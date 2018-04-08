<?php
/**
 * Template Name: Contact Us
 *
 * This is the custom template that displays Contact Us page
 *
 * @package Alpclub_Odessa
 */

wp_enqueue_style('aco-contact_form', get_stylesheet_directory_uri() . '/css/contact-form.css' );
if (class_exists('AT_Process_ContactForm')) {
	$at_cf = new AT_Process_ContactForm(); 
}

get_header(); 

while ( have_posts() ) : the_post();

//the_content();?>
				
<div class="contact-us-wrap">
	<div class="container">

		<?php if (class_exists('AT_Contact_Info')) :
		    $contact_info = new AT_Contact_Info(); ?>
			<div class="row">

				<div class="column column-4">
					<div class="contact-us-column">
						<h3>Ждем Вас по адресу</h3>
						<?php echo $contact_info->get_vcard('addr'); ?>
					</div>
				</div>

				<div class="column column-4">
					<div class="contact-us-column">
						<h3>Обращайтесь к нам</h3>
						<?php echo $contact_info->get_vcard('comm'); ?>
					</div>
				</div>

				<div class="column column-4">
					<div class="contact-us-column">
						<h3>Рабочее время</h3>
						<?php echo $contact_info->get_opening_time(); ?>
					</div>
				</div>

			</div>
		<?php endif; ?>

		<?php if (class_exists('AT_Process_ContactForm')) :?>
			<?php if ( $at_cf->is_submit_enabled() ) : ?>
				<div class="row">

					<div class="column column-12">
						<div class="contact-us-column">
							<h3>Напишите нам</h3>
							<?php 
							if ($at_cf->process_data()) $at_cf->render_form();?>
						</div>
					</div>

				</div>
			<?php endif; ?>
		<?php endif; ?>

	</div><!-- container -->
</div><!-- contact-us-wrap -->			


<?php 
endwhile; 

get_footer();
<?php
/**
 * Custom Header
 *
 * @package Alpclub_Odessa
 */

if ( is_page('contact-us') ) { ?>
	<div class="contact-us-google-map">
		<iframe style="border: 0;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6257.9870828993035!2d30.73971617857689!3d46.47542264603136!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x6e1b170171f82bc7!2z0JDQu9GM0L_QutC70YPQsSAi0J7QtNC10YHRgdCwIg!5e0!3m2!1sru!2sua!4v1517951590331" width="100%" height="450" frameborder="0" allowfullscrOne Click Demo Importeen="allowfullscreen"></iframe>						
	</div>		
<?php 
	return; 
}
?>
<div id="custom-header">
	<?php
	if ( is_page() && !is_front_page() && has_post_thumbnail() ) {
		the_post_thumbnail( 'full' );
	} else {
		$banner = '';
		
		if ( is_tax() || is_category()) {
			$queried_object = get_queried_object();
			if ( $queried_object ) {
				$banner = aco_get_term_image($queried_object->term_id, 'full');
			}			
		} 
		
		if ( empty ($banner) ) {
			$banner = get_header_image(); 
		}
		if ( !empty( $banner ) ) {
			echo '<img src="' .  esc_url( $banner ) . '" alt="" />';
		}
	}

	$banner_title = apply_filters( 'surya_chandra_filter_banner_title', '' ); 
	?>
	<?php if ( ! empty( $banner_title ) ) : ?>
		<div class="custom-header-content">
			<div class="container">
			    <?php $tag = is_front_page() ? 'h2' : 'h1';	?>
				<?php echo '<' . esc_attr( $tag ) . ' class="page-title">'; ?>
				<?php echo esc_html( $banner_title ); ?>
				<?php echo '</' . esc_attr( $tag ) . '>'; ?>
				<?php
				/**
				 * Hook - surya_chandra_action_breadcrumb.
				 *
				 * @hooked surya_chandra_add_breadcrumb - 10
				 */
				if ( absint(surya_chandra_get_option( 'show_breadcrumb' ) ) ) {
					do_action( 'surya_chandra_action_breadcrumb' );
				}
				?>
			</div><!-- .container -->
		</div><!-- .custom-header-content -->
	<?php endif; ?>

</div><!-- #custom-header -->
<?php
/**
 * Footer copyright
 *
 * @package Alpclub_Odessa
 */
?>
<footer id="colophon" class="site-footer">
	<?php $social_links = surya_chandra_get_social_links();	?>
	<?php if ( has_nav_menu( 'menu-footer' ) || ! empty( $social_links ) ) : ?>
		<div class="colophon-top">
			<div class="container">
				<?php surya_chandra_render_social_links(); ?>
				<?php wp_nav_menu( array(
						'theme_location' => 'menu-footer',
						'container_id'   => 'footer-navigation',
						'depth'          => 1,
						'fallback_cb'    => false,
					) ); ?>
			</div><!-- .container -->
		</div><!-- .colophon-top -->
	<?php endif; ?>

	<?php 
	//$copyright_text  = sprintf( esc_html__( surya_chandra_get_option( 'copyright_text', 'alpclub-odessa' )), date('Y') ); 
	$copyright_text    = sprintf( esc_html__('© %s Альпклуб «Одесса». Все права защищены.', 'alpclub-odessa' ), date('Y') );
	?>
	<?php if ( ! empty( $copyright_text ) ) : ?>
		<div class="colophon-bottom">
			<div class="container">
				<div class="copyright">
					<?php echo wp_kses_post( wpautop( $copyright_text ) ); ?>
				</div><!-- .copyright -->
			</div><!-- .container -->
		</div><!-- .colophon-bottom -->
	<?php endif; ?>
</footer><!-- #colophon -->
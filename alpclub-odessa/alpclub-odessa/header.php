<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Alpclub_Odessa
 */
?>
<!doctype html>
<html lang="ru-RU" prefix="og: http://ogp.me/ns#">
	<head>
	<?php
	/*
		<meta charset="UTF-8">
		*/
		?>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<?php wp_head(); ?>
	</head>

	<body <?php body_class(); ?>>
		<div id="page" class="site">
			<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'surya-chandra-lite' ); ?></a>
			<a id="mobile-trigger" href="#mob-menu"><i class="fa fa-bars"></i><i class="fa fa-times" aria-hidden="true"></i></a>
			<div id="mob-menu">
				<?php
				wp_nav_menu( array(
					'theme_location' => 'menu-1',
					'container'      => '',
					'fallback_cb'    => 'surya_chandra_primary_navigation_fallback',
					) );
				?>
			</div><!-- #mob-menu -->
			<?php
			/**
			 * Hook - surya_chandra_action_header.
			 *
			 * @hooked surya_chandra_add_main_header - 10
			 * @hooked surya_chandra_add_custom_header - 15
			 */
			do_action( 'surya_chandra_action_header' );

			$content_additional_class = '';
				
			if ( is_single() ) {
				if ( AT_TRIP_POST_TYPE == get_post_type() ) {
					$content_additional_class = 'site-single-trip';
				}
			}
			?>

			<div id="content" class="site-content <?php echo $content_additional_class; ?>">

				<div class="container">

					<div class="inner-wrapper">
<?php
/**
 * Primary sidebar
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Alpclub_Odessa
 */

$default_sidebar = apply_filters( 'surya_chandra_filter_default_sidebar_id', 'sidebar-1', 'primary' );
?>
<div id="sidebar-primary" class="widget-area sidebar" role="complementary">
	<?php 
	if ( is_active_sidebar( $default_sidebar ) ) {
		global $post;
		if (isset($post) && $post->post_type === AT_PERSON_POST_TYPE && is_single() ) {
			//$default_sidebar = apply_filters( 'surya_chandra_filter_default_sidebar_id', 'sidebar-1', 'primary' );	
			dynamic_sidebar( 'sidebar-2' );
		} else {
			dynamic_sidebar( $default_sidebar );
		}
	} else {

			/**
			 * Hook - surya_chandra_action_default_sidebar.
			 */
			do_action( 'surya_chandra_action_default_sidebar', $default_sidebar, 'primary' );

	} ?>
</div><!-- #sidebar-primary -->

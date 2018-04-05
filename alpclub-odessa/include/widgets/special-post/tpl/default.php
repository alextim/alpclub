<?php
/**
 * Widget template
 *
 * @package Alpclub_Odessa
 */

$post_id = absint( $instance['special_post_id'] );
$enable_excerpt = absint( $instance['enable_excerpt'] );
?>

<div class="section section-special-page heading-<?php echo esc_attr( $instance['heading_alignment'] ); ?>">
	<?php
	if ( $post_id > 0 ) {
		if ( 'disable' !== $instance['featured_image'] ) {
			$attr = ['class' => 'align' . esc_attr( $instance['featured_image_alignment'] ),];
			$thumbnail = get_the_post_thumbnail( $post_id, esc_attr( $instance['featured_image'] ), $attr );
			if ( ! empty( $thumbnail ) ) {
				echo wp_kses_post( $thumbnail );
			}
		}
	}
	
	if ( ! empty( $instance['title'] ) ) {
		echo $args['before_title'] . esc_html( $instance['title'] ) . $args['after_title']; 
	}

	if ( ! empty( $instance['subtitle'] ) ) {
		echo '<p class="widget-subtitle">' . esc_html( $instance['subtitle'] ) . '</p>';
	}

	if ( $post_id > 0 ) { 
		
		$qargs = [
		'post_type' => 'post',
			'posts_per_page' => 1,
			'page_id'        => $post_id,
			'no_found_rows'  => true,
			];

		$the_query = new WP_Query( $qargs );

		if ( $the_query->have_posts() ) { ?>
			<div class="special-page-section">
				<?php 
				while ( $the_query->have_posts() ){
					$the_query->the_post();
					if ( $enable_excerpt ) {
						the_excerpt(); 
					} else {
						the_content();
					}
				} ?>
			</div><!-- .special-page-section -->
		<?php 
		}
	}?>
</div> <!-- .section-special-page -->
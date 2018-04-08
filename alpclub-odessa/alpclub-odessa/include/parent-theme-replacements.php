<?php

// don't use parent theme widgets
function surya_chandra_register_so_widgets_folder( $folders ) {
//		$folders[] = trailingslashit( get_template_directory() ) . 'inc/so-widgets/';
	return $folders;
}

function surya_chandra_add_tab_in_so_builder_widgets_panel( $tabs ) {
	return $tabs;
}
function surya_chandra_group_theme_widgets_in_so_builder( $widgets ) {
	return $widgets;
}

function surya_chandra_customize_so_widgets_status( $active ) {

	//$active['sow-google-map']             = true;
	//$active['google-map']                 = true;
	$active['sow-testimonial']            = false;
	$active['testimonial']                = false;
	$active['sow-features']               = false;
	$active['features']                   = false;
	$active['sow-hero']                   = true;
	$active['hero']                       = true;
	//$active['surya-chandra-cta']          = true;
	$active['cta']                        = true;
	//$active['surya-chandra-latest-news']  = true;
	//$active['latest-news']                = true;
	//$active['surya-chandra-recent-posts'] = true;
	//$active['recent-posts']               = true;
	//$active['surya-chandra-special-page'] = true;
	//$active['special-page']               = true;

	return $active;
}


function surya_chandra_render_contact_info() {
	$contact_info = new AT_Contact_Info();
	$contact_number  = $contact_info->get_phone_1();
	$contact_email   = $contact_info->get_email_1();
	$contact_address = $contact_info->get_address_inline();

	if ( empty( $contact_number ) && empty( $contact_email ) && empty( $contact_address ) ) {
		return;
	}
	?>
	<div id="quick-contact">
		<ul>
			<?php 
			
			if ( ! empty( $contact_number ) ) {
				echo $contact_info->get_tel_a( $contact_number, '', '<li class="quick-call">', '</li>' );
			}
			
			if ( ! empty( $contact_email ) ) { 
				echo $contact_info->get_email_a( $contact_email, '', '<li class="quick-email">', '</li>' );
			}
			
			if ( ! empty( $contact_address ) ) {
				echo '<li class="quick-address">' . esc_html( $contact_address ) . '</li>';
			}
			?>
		</ul>
	</div><!-- #quick-contact -->
	<?php
}

// Trip без хедара
function surya_chandra_add_custom_header() {

	// Hide custom header in builder template.
	if ( is_page_template( 'tpl-builders.php' ) ) {
		return;
	}
	if ( is_page_template( 'single-trip.php' ) ) {
		return;
	}

	get_template_part( 'template-parts/header/custom-header' );
}	

// Poppins нет русского
function surya_chandra_fonts_url() {

	$fonts_url = '';
	$fonts     = array();
	$subsets   = 'latin,latin-ext';

	/* translators: If there are characters in your language that are not supported by Roboto, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Roboto font: on or off', 'surya-chandra-lite' ) ) {
		$fonts[] = 'Roboto:400italic,700italic,300,400,500,600,700';
	}

	/* translators: If there are characters in your language that are not supported by Poppins, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'off', 'Poppins font: on or off', 'surya-chandra-lite' ) ) {
		$fonts[] = 'Poppins:400italic,700italic,300,400,500,600,700';
	}

	if ( $fonts ) {
		$fonts_url = add_query_arg( array(
			'family' => urlencode( implode( '|', $fonts ) ),
			'subset' => urlencode( $subsets ),
		), 'https://fonts.googleapis.com/css' );
	}

	return $fonts_url;
}

function surya_chandra_implement_read_more($more) {
	if ( is_admin() ) {
		return $more;
	}
	if ( AT_TRIP_POST_TYPE == get_post_type() ) {
		return ' <a href="' . esc_url( get_permalink() ) . '" class="more-link">' . 'Подробнее' . '</a>';
	}
	$read_more_text = surya_chandra_get_option( 'read_more_text' );

	if ( ! empty( $read_more_text ) ) {
		$more = ' <a href="' . esc_url( get_permalink() ) . '" class="more-link">' . esc_html( $read_more_text ) . '</a>';
	}

	return $more;
}

function surya_chandra_customize_banner_title( $title ) {

	if ( is_home() ) {
		$title = surya_chandra_get_option( 'blog_title' );
	} elseif ( is_singular() ) {
		$title = single_post_title( '', false );
	} elseif ( is_category() || is_tag() ) {
		$title = single_term_title( '', false );
	} elseif ( is_archive() ) {
		$post_type = get_post_type();
		if ( AT_TRIP_POST_TYPE === $post_type  || AT_PERSON_POST_TYPE === $post_type ) {
			$title = single_cat_title( '', false );
		} else {
			$title = strip_tags( get_the_archive_title() );
		}
	} elseif ( is_search() ) {
		$title = sprintf( esc_html__( 'Search Results for: %s', 'surya-chandra-lite' ),  get_search_query() );
	} elseif ( is_404() ) {
		$title = esc_html__( '404!', 'surya-chandra-lite' );
	}

	return $title;
}

function surya_chandra_render_social_links( $type = 'circle' ) {

	$social_links = surya_chandra_get_social_links();
	if ( empty( $social_links ) ) {
		return;
	}

	echo '<div class="social-links ' . esc_attr( $type ) . '">';
	echo '<ul>';
	foreach ( $social_links as $link ) {
		echo '<li><a target="_blank" rel="noopener" href="' . esc_url( $link ) . '"></a></li>';
	}
	echo '</ul>';
	echo '</div>';
}
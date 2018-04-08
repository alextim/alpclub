<?php
function aco_get_term_image($term_id, $size) {
	// image id is stored as term meta
	$image_id = get_term_meta( $term_id, 'image', true );
	if ( !empty($image_id) ) {
		// image data stored in array, second argument is which image size to retrieve
		$image_data = wp_get_attachment_image_src( $image_id, $size );

		// image url is the first item in the array (aka 0)
		return $image_data[0];
	}
}
function aco_get_social_buttons() {

	$url = urlencode(get_the_permalink());
	$title = htmlspecialchars(urlencode(html_entity_decode(get_the_title(), ENT_COMPAT, 'UTF-8')), ENT_COMPAT, 'UTF-8'); 

	$twitterURL  = 'https://twitter.com/intent/tweet?text=' . $title . '&amp;url=' . $url . '&amp;via=Crunchify';
	$facebookURL = 'https://www.facebook.com/sharer/sharer.php?u='. $url;
	$googleURL   = 'https://plus.google.com/share?url=' . $url;

	$whatsappURL = 'whatsapp://send?text=' . $title . ' ' . $url;
	$linkedInURL = 'https://www.linkedin.com/shareArticle?mini=true&url=' . $url . '&amp;title=' . $title;
 
	// Based on popular demand added Pinterest too
	$pinterestURL = '"javascript:void((function()%7Bvar%20e=document.createElement(\'script\');e.setAttribute(\'type\',\'text/javascript\');e.setAttribute(\'charset\',\'UTF-8\');e.setAttribute(\'src\',\'//assets.pinterest.com/js/pinmarklet.js?r=\'+Math.random()*99999999);document.body.appendChild(e)%7D)());"';
	
	$emailURL     = 'mailto:?subject=' . str_replace('+', ' ', $title) . '&amp;body=%20' . $url;

/*	
	$items = [
		[$twitterURL,   '_blank'  '<span>Twitter</span>',  'icon-twitter',],
		[$facebookURL,  '_blank', '<span>Facebook</span>', 'icon-fb'],
		[$googleURL,    '_blank', '<span>Google+</span>',  'icon-gplus'],
		[$whatsappURL,  '',       '<span>WhatsApp</span>', 'icon-whatsapp'],
		[$linkedInURL,  '_blank', '<span>LinkedIn</span>', 'icon-linkedin'],
		[$pinterestURL, '',       '<span>Pinterest</span>','icon-pinterest'],
		[$emailURL,     '_blank', '<span>E-mail</span>',    'icon-email'],
	];
	
    $wraper_start = '<div class="gk-social-buttons">';
	$wraper_end = '</div>';
 	$before = '';
	$after = '';  	
*/
	$items = [
		[$twitterURL,   '_blank', '<i class="fa fa-twitter"></i>',     ''],
		[$facebookURL,  '_blank', '<i class="fa fa-facebook"></i>',    ''],
		[$googleURL,    '_blank', '<i class="fa fa-google-plus"></i>', ''],
		//[$whatsappURL,  '',       '<i class="fa fa-whatsapp"></i>',    ''],
		[$linkedInURL,  '_blank', '<i class="fa fa-linkedin"></i>',    ''],
		//[$pinterestURL, '',       '<i class="fa fa-pinterst"></i>',    ''],
		//[$emailURL,     '_blank', '<i class="fa fa-envelop-o"></i>',   ''],
	];
	
	$wraper_start = '<div class="social-links circle"><ul>';
	$wraper_end = '</ul></div>';
	$before = '<li>';
	$after = '</li>';
  
	
	$output  = '';
	foreach ($items as $item) {
		$class = ( $item[3] !== '' ) ? ' class="' . $item[3] . '" ' : '';
		$target = ( $item[1] !== '' ) ? ' target="' . $item[1] . '" ' : '';
	
		$output .= $before;
		$output .= '<a rel="noopener nofollow"' . $class . $target . ' href="' . $item[0]  . '">' . $item[2]  . '</a>';
		$output .= $after;
	}	
  	
    return $wraper_start  . $output . $wraper_end ;
}
<?php

Alpclub_Odessa_Theme::get_instance();

final class Alpclub_Odessa_Theme {
	private static $instance = null;
	
	public static function get_instance() {
        if ( null === self::$instance ) {
			self::$instance = new self;
        }
        return self::$instance;
    } 	
	
	private function __construct() {
		define( 'AT_PERSON_ITEMS_PER_ROW', 4 );
		define( 'AT_PERSON_ITEMS_PER_PAGE', AT_PERSON_ITEMS_PER_ROW * 2 );
		define( 'AT_TRIP_ITEMS_PER_ROW', 3 );
		define( 'AT_TRIP_ITEMS_PER_PAGE', AT_TRIP_ITEMS_PER_ROW * 2 );	

		$this->init_scripts();
		$this->includes();
		$this->customize_loging_page();
		$this->filters();
		
		$this->init_widgets();

		if (aco_is_maintanence_mode() ) {
			add_action('get_header', function (){
				if(!current_user_can('edit_themes') || !is_user_logged_in()){
					wp_die('<h1 style="color:red">Website under Maintenance</h1><br />We are performing scheduled maintenance. We will be back online shortly!');
				}
			});	
		}
		
		add_action( 'after_setup_theme', function () {
			// поддержка языков
			load_theme_textdomain( 'surya-chandra-lite', get_stylesheet_directory() . '/languages' );
			load_child_theme_textdomain( 'alpclub-odessa', get_stylesheet_directory() . '/languages' );
		} );		

		add_action( 'pre_get_posts', [&$this, 'modify_cpt_query'] );
	}
	
	private function filters() {
		// ATPTM
		// Ограничение количества ревизий постов в базе данных: 0
		add_filter( 'wp_revisions_to_keep', function ( $num, $post ) : int { return 0; }, 10, 2 );
		add_filter( 'rest_authentication_errors', function ( $access ) {
			 return new WP_Error( 'rest_disabled', __('The WordPress REST API has been disabled.'), array( 'status' => rest_authorization_required_code()));
		} );

		
	/*	
		add_filter('wp_headers', function ($headers) : array {
			$headers['Content-Type'] = 'text/html; charset=utf-8';
			return $headers;     
		});	
		*/

		add_filter( 'emoji_svg_url', '__return_false' );	
		add_filter( 'login_errors', function () : string { return 'Wrong username or password! Please, try again.'; } );	
		
		//INCLUDE  CUSTOM TEMPLATE FILE
		add_filter( 'template_include', [&$this, 'include_template_function'], 1  );

		add_filter( 'surya_chandra_filter_default_theme_options', function( $defaults ) : array {
			return array_merge ($defaults, _get_aco_theme_default_options());
		} );
	}

	// Custom Post types: person, trip
	// Поддержка сортировки  в admin панели
	// Подстройка количества постов на странице в архивах	
	//if ( isset( $wp_query->query_vars['post_type'] ) && ( ( is_string( $wp_query->query_vars['post_type'] ) && $wp_query->query_vars['post_type'] !== '' ) || ( is_array( $wp_query->query_vars['post_type'] ) && $wp_query->query_vars['post_type'] !== array() ) ) ) {
	//	$post_type = $wp_query->query_vars['post_type'];
	function modify_cpt_query( $query ) {
		global $wp_the_query;
		if ( $query === $wp_the_query && count($query->query) > 0 && isset($query->query['post_type']) ) {
			if ( AT_TRIP_POST_TYPE === $query->query['post_type'] ) {
				if ( is_admin() ) {
					if( 'trip_price' === $query->get( 'orderby') ) {
						$query->set('meta_key','trip_price');
						$query->set('orderby','meta_value_num');								
					}						
				} else {
					$query->set( 'posts_per_page', AT_TRIP_ITEMS_PER_PAGE );
				}
				
			} else if ( AT_PERSON_POST_TYPE === $query->query['post_type'] ) {
				if ( is_admin() ) {
					if( 'person_sort_order' === $query->get( 'orderby') ) {
						$query->set('meta_key','person_sort_order');
						$query->set('orderby','meta_value_num');								
					}
				} else {
					$query->set( 'posts_per_page', AT_PERSON_ITEMS_PER_PAGE );
				}
				//add_filter('posts_orderby', function($orderby) { return '(wp_posts.person_sort_order+0) DESC'; } );
			}		
		}
		return $query;
	}
	
	function include_template_function( $template_path ) {
		$post_type = get_post_type();
		if ( AT_PERSON_POST_TYPE === $post_type || AT_TRIP_POST_TYPE === $post_type ) {
			if ( is_single() ) {
				$theme_file = locate_template( array( 'single-' . $post_type . '.php' ) );
				if ( $theme_file )
					return $theme_file;
			} elseif ( is_archive() ) {
				$theme_file = locate_template( array ( 'archive-cpt.php' ) );
				if ( $theme_file )
					return $theme_file;
			}
		}
		return $template_path;
	}	
	
	private function init_scripts() {
		
		add_action( 'wp_enqueue_scripts', function() {
			$use_cdn = false;
			$this->load_css( $use_cdn );
			$this->load_js( $use_cdn );
		}, 99);

		// Defer Javascripts
		// Defer jQuery Parsing using the HTML5 defer property
		if ( false && !is_admin() ) {
			add_filter( 'script_loader_tag', function ($tag, $handle){

				// Do not add defer or async attribute to these scripts
				$scripts_to_exclude = [
					'envira-min.js', 
					//'akismet/_inc/form.js', 
					'jquery.min.js',
					];

				foreach($scripts_to_exclude as $exclude_script) {
					if( true == strpos($tag, $exclude_script ) ) {
						return $tag; 
					}
				}
				

				//if ( 'contact-form-7' !== $handle )
				//	return $tag;

				// Defer or async all remaining scripts not excluded above
				return str_replace( ' src', ' async="async" src', $tag );
			}, 10, 2 );
		
		}

//		add_filter( 'script_loader_src', array('Alpclub_Odessa_Theme', '_remove_script_version'), 15 ); 
//		add_filter( 'style_loader_src', array('Alpclub_Odessa_Theme', '_remove_script_version'), 15 );
		
	}
	
	private function load_css( bool $use_cdn ) {
		$parent_style = 'surya-chandra-lite';
			
		wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css', null, null, 'all' );

		//WP автоматически грузит лишний раз style.css дочерней темы с номером версии и под другим именем
		wp_dequeue_style ( $parent_style );
			
		wp_enqueue_style( 'alpclub-odessa', get_stylesheet_directory_uri() . '/style.css', array( $parent_style )); //, wp_get_theme()->get('Version') );
		
		if (true) {
			
			wp_dequeue_style('font-awesome'); 
			wp_deregister_style('font-awesome');
			wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css' );
			//wp_enqueue_style('font-awesome', 'https://use.fontawesome.com/releases/v5.0.8/css/all.css' );
		}
		if ($use_cdn) {			
			wp_dequeue_style('jquery-sidr'); 
			wp_deregister_style('jquery-sidr');
			wp_enqueue_style('jquery-sidr', 'https://cdnjs.cloudflare.com/ajax/libs/sidr/2.2.1/stylesheets/jquery.sidr.dark.min.css' );
		}
	}
	
	private function load_js( bool $use_cdn ) {
		$js_in_footer = !is_admin();
		$this->reload_js( 'jquery', '1.12.4', 
				//'https://cdnjs.cloudflare.com/ajax/libs/jquery/%s/jquery.min.js',
				'https://ajax.googleapis.com/ajax/libs/jquery/%s/jquery.min.js', 
				includes_url('/js/jquery/jquery.js'), true, [], false, $js_in_footer );
				
		wp_deregister_script( 'jquery-migrate.min' );
/*
		$this->reload_js( 'jquery-migrate.min', '1.4.1',  
				'https://cdnjs.cloudflare.com/ajax/libs/jquery-migrate/%s/jquery-migrate.min.js', 
				includes_url('/js/jquery/jquery-migrate.min.js'), $use_cdn, ['jquery'], false, $js_in_footer );
*/					
			
		// Загрузка counter тодько на странице join
		if ( is_page( 'join' ) ) {
		   wp_enqueue_script('aco-counter',
				get_stylesheet_directory_uri() . '/js/counter.js', ['jquery'], null, true);
		} 
	
		if ($use_cdn) {
			$this->reload_js( 'jquery-sidr', '2.2.1',  
			'https://cdnjs.cloudflare.com/ajax/libs/sidr/%s/jquery.sidr.min.js', 
			'', true, ['jquery'], false, true );
		}
	}
/*	
	public static function _remove_script_version( $src ){ 
		if ( strpos( $src, '?ver=' ) )
			return remove_query_arg( 'ver', $src );
		return $src;
	} 
*/
	
	private function reload_js(string $script_name, string $default_ver, string $url_template, string $src_url, bool $use_cdn, array $dependacy, bool $with_ver = false, bool $in_footer = true ) {
		if ( !$use_cdn && !$in_footer ) {
			return;
		}
		if ( $use_cdn ) {
			global $wp_scripts;
			
			if (isset($wp_scripts->registered[$script_name]->ver)) {
				$ver = $wp_scripts->registered[$script_name]->ver;
			} else {
				$ver = $default_ver;
			}
			$url = sprintf( $url_template, $ver );		

		} else {
			$url = $src_url;
			$ver = $default_ver;
		}
		
		wp_deregister_script( $script_name );
		wp_register_script( $script_name, $url, $dependacy, ($with_ver ? $ver : null),  $in_footer );
		wp_enqueue_script( $script_name );
	}
	
	
	private function includes() {
		$items = [
			// не хочу выводить автора
			// переопределяю функцию surya_chandra_posted_on
			'template-tags.php', 
			// прочие замены
			'parent-theme-replacements.php',
			
			'customizer/defaults.php',
			'core.php',
			'template-functions.php',
			'lib/print-in-columns.php',
			
			'class-shortcode.php',
		];
		
		if ( is_customize_preview() ) {
			$items[] = 'class-customizer.php';
			//AT_Contact_Info_Customizer::get_instance();
		}
		
		if (is_admin() ) {
			$items[] = 'site-origin.php';
		}	
		
		$include_dir = get_stylesheet_directory() . '/include/';

		foreach($items as $item) {
			require_once ($include_dir . $item);
		}
		/*
		$items = [ 
			'core.php',
			'customizer/default.php',
		];
		$include_dir = get_template_directory() . '/inc/';

		foreach($items as $item) {
			require_once ($include_dir . $item);
		}
*/		
	}
	
	
	private function init_widgets() {
		add_action( 'widgets_init', function() {
			
			$include_dir = get_stylesheet_directory() . '/include/widgets/';
			
			$widget_names = [
				['special-post',  'Alpclub_Odessa_Special_Post_Widget'], 

				['person-list',   'Alpclub_Odessa_Person_List_Widget'], 
				
				['recent-trips',  'Alpclub_Odessa_Recent_Trips_Widget'], 
				['latest-trips',  'Alpclub_Odessa_Latest_Trips_Widget'], 
				['special-trip',  'Alpclub_Odessa_Special_Trip_Widget'],
				['latest-news',   'Alpclub_Odessa_Latest_News_Widget'],	
				['terms-list',    'Alpclub_Odessa_Terms_List_Widget'],				
				['cta',           'Alpclub_Odessa_CTA_Widget'],				
			];
			
			foreach($widget_names as $item) {
				require_once ($include_dir . $item[0] . '/' . $item[0] . '.php');
				register_widget ($item[1]);
			}
			
		});
	}
	
	private function customize_loging_page() {
		// Меняем картинку логотипа WP на странице входа 
		add_action('login_head', function (){
			$width = 109;
			$height = 86;
			echo '<style type="text/css">' . 
				'#login h1 a {background:url(' . get_stylesheet_directory_uri() . '/img/login-logo.png) no-repeat 0 0 !important;' .
				'width:' . $width . 'px !important;' . 
				'height:' . $height . 'px !important;' . 
				'-webkit-background-size:' . $width . 'px ' . $height . 'px;' . 
				'background-size:' . $width . 'px ' . $height . 'px;}' . 
			'</style>';
		} );
		
		// Ставим ссылку с логотипа на наш сайт, а не на wordpress.org 
		add_filter( 'login_headerurl', function() : string { return get_home_url(); } );
		
		// убираем title в логотипе "сайт работает на wordpress" 
		add_filter( 'login_headertitle', function() : bool { return false; } );
	}
	
/*
		// удаляем все стили для person with $attr = array ('class' => 'no-classes')
		// modify_post_thumbnail_html
		add_filter('post_thumbnail_html', function ($html, $post_id, $post_thumbnail_id, $size, $attr) {
			if ( !$attr || !isset($attr['class']) || strpos($attr['class'], 'no-classes') === false) {
				return $html;
			}
		

			return preg_replace( '/class=(["\'])[^\1]*?\1/i', '',$html, -1 );
		}, 99, 5);
*/		
		
/*		
		add_action( 'after_setup_theme', function() {

			remove_filter( 'excerpt_more', 'surya_chandra_implement_read_more' );
			add_filter( 'excerpt_more', function($more) {
				if ( is_admin() ) {
					return $more;
				}
				
				if ( AT_TRIP_POST_TYPE == get_post_type() ) {
					return ' <a href="' . esc_url( get_permalink() ) . '" class="more-link">' . 'Подробнее' . '</a>';
				}
				return surya_chandra_implement_read_more($more);
				
			} );
			

			remove_filter( 'surya_chandra_filter_banner_title', 'surya_chandra_customize_banner_title' );	
			add_filter( 'surya_chandra_filter_banner_title', function ($title) {
				if ( is_archive() ) {
				
					if ( AT_TRIP_POST_TYPE == get_post_type() ) {
						//$title = strip_tags( get_the_archive_title() );
						return single_cat_title( '', false );
					}
				}
				
				return surya_chandra_customize_banner_title( $title );
			});	
			
		} );	
*/		

/*
# Finding script handle for your plugins 
add_action( 'wp_print_scripts', function () {
    global $wp_scripts;
	//if(current_user_can('manage_options') && is_admin()){ # Only load when user is admin
		echo '<table border=1 colostyle="margin:200px;">';
		foreach( $wp_scripts->queue as $handle ) :
			echo '<tr>';
			 $obj = $wp_scripts->registered [$handle];
			 echo '<td>' . $filename = $obj->src . '</td>';
			 echo '<td>'.$handle.'</td>';
			echo '</tr>';
		endforeach;
		echo '</table>';
	//}	
} ,999);
*/

/*
add_action('wp_enqueue_scripts', 'show_all_styles');
function show_all_styles()
{
    // use global to call variable outside function
    global $wp_styles;
     
    // arrange the queue based on its dependency
    $wp_styles->all_deps($wp_styles->queue);  
     
    // The result
    $handles = $wp_styles->to_do;
     
    echo '<pre><p>Styles</p>'; print_r($handles); echo '</pre>';
}
*/	
}
/*
function remove_json_api () {

    // Remove the REST API lines from the HTML Header
    remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
    remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 10 );

    // Remove the REST API endpoint.
    remove_action( 'rest_api_init', 'wp_oembed_register_route' );

    // Turn off oEmbed auto discovery.
    add_filter( 'embed_oembed_discover', '__return_false' );

    // Don't filter oEmbed results.
    remove_filter( 'oembed_dataparse', 'wp_filter_oembed_result', 10 );

    // Remove oEmbed discovery links.
    remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );

    // Remove oEmbed-specific JavaScript from the front-end and back-end.
    remove_action( 'wp_head', 'wp_oembed_add_host_js' );

   // Remove all embeds rewrite rules.
   add_filter( 'rewrite_rules_array', 'disable_embeds_rewrites' );

}
add_action( 'after_setup_theme', 'remove_json_api' );
function disable_json_api () {

  // Filters for WP-API version 1.x
  add_filter('json_enabled', '__return_false');
  add_filter('json_jsonp_enabled', '__return_false');

  // Filters for WP-API version 2.x
  add_filter('rest_enabled', '__return_false');
  add_filter('rest_jsonp_enabled', '__return_false');
  
add_filter('rest_enabled', '__return_false');

// Отключаем фильтры REST API
remove_action( 'xmlrpc_rsd_apis',            'rest_output_rsd' );
remove_action( 'wp_head',                    'rest_output_link_wp_head', 10, 0 );
remove_action( 'template_redirect',          'rest_output_link_header', 11, 0 );
remove_action( 'auth_cookie_malformed',      'rest_cookie_collect_status' );
remove_action( 'auth_cookie_expired',        'rest_cookie_collect_status' );
remove_action( 'auth_cookie_bad_username',   'rest_cookie_collect_status' );
remove_action( 'auth_cookie_bad_hash',       'rest_cookie_collect_status' );
remove_action( 'auth_cookie_valid',          'rest_cookie_collect_status' );
remove_filter( 'rest_authentication_errors', 'rest_cookie_check_errors', 100 );

// Отключаем события REST API
remove_action( 'init',          'rest_api_init' );
remove_action( 'rest_api_init', 'rest_api_default_filters', 10, 1 );
remove_action( 'parse_request', 'rest_api_loaded' );

// Отключаем Embeds связанные с REST API
remove_action( 'rest_api_init',          'wp_oembed_register_route'              );
remove_filter( 'rest_pre_serve_request', '_oembed_rest_pre_serve_request', 10, 4 );

remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
// если собираетесь выводить вставки из других сайтов на своем, то закомментируйте след. строку.
remove_action( 'wp_head', 'wp_oembed_add_host_js' );  
  
  
  

}
add_action( 'after_setup_theme', 'disable_json_api' );
*/
/*
if (absint(surya_chandra_get_option( 'ga_active' ))) {
	add_action( absint(surya_chandra_get_option( 'ga_active' )) ? 'wp_footer' : 'wp_head', function (){
		$trackingID = surya_chandra_get_option( 'ga_tracking_id' );
		if (empty($trackingID)) {
			return;
		}
		if (absint(surya_chandra_get_option( 'ga_async' ))) { ?>			
<!-- Google Analytics -->
<script>
window.ga=window.ga||function(){(ga.q=ga.q||[]).push(arguments)};ga.l=+new Date;
ga('create', '<?php echo $trackingID; ?>', 'auto');
ga('send', 'pageview');
</script>
<script async src='https://www.google-analytics.com/analytics.js'></script>
<!-- End Google Analytics -->
<?php } else { ?>			
<!-- Google Analytics -->
<script>
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

ga('create', '<?php echo $trackingID; ?>', 'auto');
ga('send', 'pageview');
</script>
<!-- End Google Analytics -->
<?php		
		}
	});
}
*/

function aco_write_log ( $log )  {
	if ( true === WP_DEBUG ) {
		if ( is_array( $log ) || is_object( $log ) ) {
			error_log( print_r( $log, true ) );
		} else {
			error_log( $log );
		}
	}
}
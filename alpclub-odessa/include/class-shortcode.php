<?php
/**
 * Shortcode callbacks.
 *
 * @package alpclub-odessa\include
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
new Alpclub_Odessa_Shortcodes();
/**
 * Alpclub Odessa Shortcode class.
 *
 * 
 * @version	1.0.0
 */
final class Alpclub_Odessa_Shortcodes {
	public function __construct() {
		add_shortcode( 'alpclub_odessa_member_count',  [&$this, 'get_member_count_short_code'] ); 
		add_shortcode( 'alpclub_odessa_person_list',   [&$this, 'get_person_list_short_code'] ); 
		add_shortcode( 'alpclub_odessa_trip_list',     [&$this, 'get_trip_list_short_code'] ); 
		add_shortcode( 'alpclub_odessa_benefits_list', [&$this, 'get_benefits_list_short_code'] );
	}
	
	public static function get_person_list_short_code($atts = []) {
		$items_per_row = AT_PERSON_ITEMS_PER_ROW;
		$rows_per_page = AT_PERSON_ITEMS_PER_PAGE / AT_PERSON_ITEMS_PER_ROW; 
		// normalize attribute keys, lowercase
		$atts = array_change_key_case((array)$atts, CASE_LOWER);	

		// override default attributes with user attributes
		$wporg_atts = shortcode_atts([
										 'person_type' => '',
										 'items_per_row' => '',
										 'rows_per_page' => '',
									 ], $atts);
		
		$n = absint($wporg_atts['items_per_row']);	
		if ($n > 0) {
			$items_per_row = $n;
		}
		
		$n = absint($wporg_atts['rows_per_page']);	
		if ($n > 0) {
			$rows_per_page = $n;
		}

		$qargs = [
			'post_type' => AT_PERSON_POST_TYPE,
			'posts_per_page' => $items_per_row * $rows_per_page,
			'orderby' => 'meta_value_num',
			'meta_key' => 'person_sort_order',
			'order' => 'DESC',			
			];
		
		if ( !empty ($wporg_atts['person_type']) ) {
		
			$term = get_term_by('slug', $wporg_atts['person_type'], 'person_type');
		
			if ( $term ) {
				$qargs['tax_query'] = [
						[
							'taxonomy' => 'person_type',
							'field'    => 'term_id',
							'terms'    => $term->term_id,
						],
				];
			}
		}
		
		ob_start();
		at_print_in_columns( '', '', AT_PERSON_POST_TYPE, $qargs, $items_per_row);
		return ob_get_clean();
	}
	
	public static function get_trip_list_short_code($atts = []) {
		$items_per_row = AT_TRIP_ITEMS_PER_ROW;
		$rows_per_page = AT_TRIP_ITEMS_PER_PAGE / AT_TRIP_ITEMS_PER_ROW; 
		// normalize attribute keys, lowercase
		$atts = array_change_key_case((array)$atts, CASE_LOWER);	

		// override default attributes with user attributes
		$wporg_atts = shortcode_atts([
										 'activity' => '',
										 'items_per_row' => '',
										 'rows_per_page' => '',
									 ], $atts);
		
		$n = absint($wporg_atts['items_per_row']);	
		if ($n > 0) {
			$items_per_row = $n;
		}
		
		$n = absint($wporg_atts['rows_per_page']);	
		if ($n > 0) {
			$rows_per_page = $n;
		}

		$qargs = [
			'post_type' => AT_TRIP_POST_TYPE,
			'posts_per_page' => $items_per_row * $rows_per_page,
			];
		
		if ( !empty ($wporg_atts['activity']) ) {
		
			$term = get_term_by('slug', $wporg_atts['activity'], 'activity');
		
			if ( $term ) {
				$qargs['tax_query'] = [
						[
							'taxonomy' => 'activity',
							'field'    => 'term_id',
							'terms'    => $term->term_id,
						],
				];
			}
		}
		
		ob_start();
		at_print_in_columns( '', '', AT_TRIP_POST_TYPE, $qargs, $items_per_row);
		return ob_get_clean();
	}

	
	public static function get_member_count_short_code($atts = []) {
		$member_count = absint(surya_chandra_get_option( 'member_count' ));
		if ( $member_count <= 0 ) {
			return '';
		}	
		// normalize attribute keys, lowercase
		$atts = array_change_key_case((array)$atts, CASE_LOWER);	
		
		// override default attributes with user attributes
		$wporg_atts = shortcode_atts([
										 'title' => '',
									 ], $atts);
		
		$title_html = '';							 

		if ( !empty ($wporg_atts['title']) ) {
			$title_html = '<div class="mc-caption">' . esc_html__($wporg_atts['title'], 'alpclub-odessa') . '</div>';
		}
	$html = '<div class = "mc-wrapper">
	<div class="mc-container">
	  <div class="mc-content">

		<div class="mc-centerhoriz">'.
			$title_html .        
		   '<div class="mc-circle">
				<div class="mc-content mc-count">' .
					$member_count .          
	'       	</div>
			</div>
		</div>
	  </div>
	</div>
	</div>';	
		return $html;
	}
	
	public static function get_benefits_list_short_code($atts = []) {
		$atts = array_change_key_case((array)$atts, CASE_LOWER);	

		$wporg_atts = shortcode_atts([
										 'title' => '',
										 'subtitle' => '',

									 ], $atts);
									 
		$title = $wporg_atts['title'];	
		$subtitle = $wporg_atts['subtitle'];	
		
		$items = [
			[
				'Экономия', 
				'С нами ездить в горы выгодно и просто', 
				'fa-eur', 
				'#3281db',
			],
			[
				'Безопасность', 
				'Сертифицированные инструктора ФАиС', 
				'fa-thumbs-o-up', 
				'forestgreen',
				'/alp-staff',
			],
			[
				'Путешествия', 
				'Альпинизм, скалолазание и ледолазание в горах', 
				'fa-map-signs', 
				'blue',
				'/trips',
			],
			[
				'Настоящий спорт', 
				'Наши сборы - официальные, можно выполнить спортивный разряд', 
				'fa-trophy', 
				'gold',
			],
			[
				'Скидки', 
				'Для членов клуба скидки в магазинах, спортзалах и хижинах', 
				'fa-percent',
				'black',
			],
			[
				'Хорошая компания', 
				'В горах вы найдете лучших друзей на всю жизнь', 
				'fa-heart-o', 
				'crimson',
			],
		];


		ob_start();
		self::render_feature_list($title, $subtitle, $items, 3, 2);
		return ob_get_clean();		
	}

	private static function render_feature_list($title, $subtitle, $items, $cols, $rows) {
		$n = 0;
		$count = count($items);
?>	
<div class="siteorigin-panels-stretch panel-row-style-full-width panel-row-style aco-benefits-wrapper">
	<div class="section section-services heading-center">

	<?php if (!empty($title)) : ?>
		<h3 class="widget-title"><?php echo esc_html($title);?></h3>	
	<?php endif; ?>	

	<?php if (!empty($subtitle)) : ?>
		<p class="widget-subtitle"><?php echo esc_html($subtitle);?></p>
	<?php endif; ?>		

		<div class="service-block-list service-layout-1 service-col-3">
			<div class="inner-wrapper">
				
				<?php foreach ($items as $item ) : ?>
				<?php $a_prefix = '';
					  $a_suffix = '';
		
	     			  if (isset($item[4]) && !empty($item[4]) ) {
						$a_prefix = sprintf('<a href="%s%s">', get_home_url(), esc_url($item[4]));
						$a_suffix = '</a>';		
					 }
				?>
					<div class="service-block-item">
						<div class="service-block-inner">
							<div class="service-icon-wrap">
								<?php echo $a_prefix; ?>
									<i class="fa <?php echo $item[2];?>" style="color: <?php echo $item[3];?>"></i>
								<?php echo $a_suffix; ?>
							</div><!-- .service-icon-wrap -->
							
							<div class="service-block-inner-content">
								<h3 class="service-item-title">
									<?php echo $a_prefix; ?>
									<?php echo $item[0];?>
									<?php echo $a_suffix; ?>							
								</h3>
								<div class="service-block-item-excerpt">
									<p><?php echo esc_html($item[1]);?></p>
								</div><!-- .service-block-item-excerpt -->
							</div><!-- .service-block-inner-content -->
						</div> <!-- .service-block-inner -->
					</div> <!-- .service-block-item -->	
					
					<?php endforeach; ?>	
				</div><!-- .inner-wrapper -->
			
			</div><!-- .service-block-list -->
		
	</div><!-- .section section-services -->				
</div>

	<?php	
	}
}
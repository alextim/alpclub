<?php
/**
 * Metabox for Trip fields.
 *
 * @package ap-trip\inc\admin
 */

/**
 * AT_Trip_Admin_Metaboxes Class.
 */
class AT_Trip_Admin_Metaboxes {

	public function __construct() {
		add_action( 'add_meta_boxes_' . AT_TRIP_POST_TYPE, [&$this, 'register_metaboxes'], 10, 2 );
		add_action( 'do_meta_boxes', [&$this, 'remove_metaboxes' ], 10, 2 );
		add_action( 'save_post',     [&$this, 'save_meta_data' ] );
	}

	function register_metaboxes() {
		add_meta_box( 'trip_meta_box1', 'Trip Info',          [&$this, 'render_info_callback' ],              AT_TRIP_POST_TYPE, 'normal', 'high' );
		add_meta_box( 'trip_meta_box4', 'Trip Registration',  [&$this, 'render_registration_form_callback' ], AT_TRIP_POST_TYPE, 'normal', 'default' );
		add_meta_box( 'trip_meta_box2', 'Trip Price',         [&$this, 'render_price_callback'],              AT_TRIP_POST_TYPE, 'normal', 'default' );
		add_meta_box( 'trip_meta_box3', 'Trip Tabs',          [&$this, 'render_tabs_callback' ],              AT_TRIP_POST_TYPE, 'normal', 'default' );
	}
	
	function render_info_callback( $post ) {
		wp_nonce_field( 'at_trip_save_data_process', 'trip_noncename' );
		
		$helper = new AT_Trip_Trip( $post );
		
		$trip_sticky 	           = $helper->get_sticky();

		$trip_fixed_departure 	   = $helper->get_fixed_departure();

		$trip_start_date 	       = $helper->get_start_date();
		$trip_end_date 	           = $helper->get_end_date();
		
		$trip_duration_days        = $helper->get_duration_days();
		$trip_duration_nights      = $helper->get_duration_nights();
		
		$trip_highest_point 	   = $helper->get_highest_point();
		$trip_technical_difficulty = $helper->get_technical_difficulty();
		$trip_fitness_level        = $helper->get_fitness_level();
		$trip_group_size		   = $helper->get_group_size();
		?>
		
		<table>
			<tr>
				<td><label for="trip_sticky">Sticky</label></td>
				<td><input type="checkbox" name="trip_sticky" value="yes" <?php echo $trip_sticky ? 'checked' : ''; ?>></td>
			</tr>
		
		
			<tr>
				<td><label for="trip_fixed_departure">Фиксированные даты</label></td>
				<td><input type="checkbox" name="trip_fixed_departure" id="trip-fixed-departure" value="yes" <?php echo $trip_fixed_departure ? 'checked' : ''; ?>></td>
			</tr>
			
			<tr class="trip-fixed-departure-row" style="display:<?php echo ( 1 === $trip_fixed_departure ) ? 'table-row' : 'none'; ?>">
				<td><label for="trip_start_date">Дата начала</label></td>
				<td><input type="text" name="trip_start_date" id="trip-start-date" value="<?php echo $trip_start_date; ?>"></td>
			</tr>
			<tr class="trip-fixed-departure-row" style="display:<?php echo ( 1 === $trip_fixed_departure ) ? 'table-row' : 'none'; ?>">
				<td><label for="trip_end_date">Дата окончания</label></td>
				<td><input type="text" name="trip_end_date" id="trip-end-date" value="<?php echo $trip_end_date; ?>"></td>
			</tr>
			
			<tr class="trip-duration-row" style="display:<?php echo ( 0 === $trip_fixed_departure ) ? 'table-row' : 'none'; ?>">
				<td><label for="trip_duration_days">Продолжительность</label></td>
				<td>
					<input type="number" name="trip_duration_days" value="<?php echo $trip_duration_days; ?>" min="0" step="1">Дней&nbsp;
					<input type="number" name="trip_duration_nights" value="<?php echo $trip_duration_nights; ?>" min="0" step="1">Ночей
				</td>
			</tr>
			
			<tr>
				<td><label for="trip_highest_point">Высшая точка</label></td>
				<td><input type="number" name="trip_highest_point" value="<?php echo $trip_highest_point; ?>" min="0" max="8848">м</td>
			</tr>
			
			<tr>
				<td><label for="trip_technical_difficulty">Техническая сложность</label></td>
				<td>
					<select name="trip_technical_difficulty">
						<option value="0" <?php echo selected( 0, $trip_technical_difficulty ); ?>>--</option> 
						<option value="1" <?php echo selected( 1, $trip_technical_difficulty ); ?>>Low</option> 
						<option value="2" <?php echo selected( 2, $trip_technical_difficulty ); ?>>Medium</option> 
						<option value="3" <?php echo selected( 3, $trip_technical_difficulty ); ?>>High</option> 
						<option value="4" <?php echo selected( 4, $trip_technical_difficulty ); ?>>Very high</option> 
					</select>
				</td>
			</tr>
			<tr>
				<td><label for="trip_fitness_level">Физическая подготовка</label></td>
				<td>
					<select style="width: 100px" name="trip_fitness_level">
						<option value="0" <?php echo selected( 0, $trip_fitness_level ); ?>>--</option> 
						<option value="1" <?php echo selected( 1, $trip_fitness_level ); ?>>Low</option> 
						<option value="2" <?php echo selected( 2, $trip_fitness_level ); ?>>Medium</option> 
						<option value="3" <?php echo selected( 3, $trip_fitness_level ); ?>>High</option> 
						<option value="4" <?php echo selected( 4, $trip_fitness_level ); ?>>Very high</option> 
					</select>
				</td>
			</tr>
			
			<tr>
				<td><label for="trip_group_size">Размер группы</label></td>
				<td><input type="number" name="trip_group_size" value="<?php echo $trip_group_size; ?>" min="0" max="100"></td>
			</tr>
		</table>
		<?php
	}
	
	function render_registration_form_callback( $post ) {
		$helper = new AT_Trip_Trip( $post );
		$trip_registration_form	   = $helper->get_registration_form();
		?>
		
		<table>
			<tr>
				<td><label for="trip_registration_form">Ссылка</label></td>
				<td><input size="80" maxlength="128" type="url" name="trip_registration_form" value="<?php echo $trip_registration_form; ?>"><br/><i>Допускаются ссылки только на Google Forms</i></td>
			</tr>

		</table>
		<?php
	}
	
	function render_price_callback( $post ) {
	
		$helper = new AT_Trip_Trip( $post );

		$trip_price = $helper->get_price();
		$trip_currency = $helper->get_currency();
		
		$currency_list = at_trip_get_currency_list();
		$currency_args = [
			'id'		=> 'trip_currency',
			'class'		=> 'trip_currency',
			'name'		=> 'trip_currency',
			'selected'	=> $trip_currency,
			'option'	=> 'Select Currency',
			'options'	=> $currency_list,
		];
		
		$trip_sale_price = $helper->get_sale_price();
		$trip_enable_sale = $helper->get_enable_sale();
		
		?>
		
		<table>
			<tr>
				<td><label for="trip_price">Цена</label></td>
				<td><input type="number" name="trip_price" id="trip_price" value="<?php echo $trip_price; ?>" min="0" max="1000000"/></td>
			</tr>
			<tr>
				<td><label for="trip_currency">Валюта</label></td>
				<td>
					<?php echo at_trip_get_dropdown_currency_list( $currency_args ); ?>
				</td>
			</tr>

			<tr>
				<td><label for="trip_enable_sale">Разрешить распродажу</label></td>
				<td><input type="checkbox" name="trip_enable_sale" id="trip-enable-sale" value="yes" <?php echo $trip_enable_sale ? 'checked' : ''; ?> /></td>
			</tr>
			
			<tr class="trip-sale-price-row" style="display:<?php echo ( 1 === $trip_enable_sale ) ? 'table-row' : 'none'; ?>">
				<td><label for="trip_sale_price">Цена распродажи</label></td>
				<td><input type="number" name="trip_sale_price" value="<?php echo $trip_sale_price; ?>" min="0" max="1000000"/></td>
			</tr>
		</table>
		
		<?php
	}
	
	
	function render_tabs_callback( $post ) {
		
		$helper = new AT_Trip_Trip( $post );

		$trip_outline 	= $helper->get_outline();
	
		$trip_include 	= $helper->get_include();
		$trip_exclude 	= $helper->get_exclude();
		
		$trip_price_details = $helper->get_price_details();
		
		$trip_equipment = $helper->get_equipment();
		
		$trip_additional_info = $helper->get_additional_info();

		$trip_gallery = $helper->get_gallery();
		
		?>
		
		
		<div class="tabs">
			<input type="radio" name="tabs" id="tabone" checked="checked">
			<label for="tabone">Описание</label>
			<div class="tab">
				<?php wp_editor( $post->post_content, 'at_trip_editor' ); ?>
			</div>

			<input type="radio" name="tabs" id="tabtwo">
			<label for="tabtwo">Программа по дням</label>
			<div class="tab">
				<?php wp_editor( $trip_outline, 'trip_outline' ); ?>
			</div>
			
			<input type="radio" name="tabs" id="tabthree">
			<label for="tabthree">Услуги</label>
			<div class="tab">
				<div>
					<label for="trip_include">Включено</label>
					<?php wp_editor( $trip_include, 'trip_include' ); ?>
				</div>
			
				<div>
					<label for="trip_exclude">Не включено</label>
					<?php wp_editor( $trip_exclude, 'trip_exclude' ); ?>
				</div>

			</div>
			
			<input type="radio" name="tabs" id="tabfour">
			<label for="tabfour">Стоимость</label>
			<div class="tab">
				<?php wp_editor( $trip_price_details, 'trip_price_details' ); ?>
			</div>

			<input type="radio" name="tabs" id="tabfive">
			<label for="tabfive">Снаряжение</label>
			<div class="tab">
				<?php wp_editor( $trip_equipment, 'trip_equipment' ); ?>
			</div>
			
			<input type="radio" name="tabs" id="tabsix">
			<label for="tabsix">Доп.информация</label>
			<div class="tab">
				<?php wp_editor( $trip_additional_info, 'trip_additional_info' ); ?>
			</div>

			<input type="radio" name="tabs" id="tabseven">
			<label for="tabseven">Галерея</label>
			<div class="tab">
				<?php wp_editor( $trip_gallery, 'trip_gallery' ); ?>
			</div>
		</div>
		<?php
	}	
	
	function remove_metaboxes() {
		$object_type = AT_TRIP_POST_TYPE;
		//remove_meta_box( 'authordiv',$object_type,'normal' ); // Author Metabox
		remove_meta_box( 'commentstatusdiv', $object_type, 'normal' ); // Comments Status Metabox
		remove_meta_box( 'commentsdiv',$object_type,'normal' ); // Comments Metabox
		//remove_meta_box( 'postcustom',$object_type,'normal' ); // Custom Fields Metabox
		//remove_meta_box( 'postexcerpt',$object_type,'normal' ); // Excerpt Metabox
		//remove_meta_box( 'revisionsdiv', $object_type, 'normal' ); // Revisions Metabox
		//remove_meta_box( 'slugdiv',$object_type,'normal' ); // Slug Metabox
		//remove_meta_box( 'trackbacksdiv', $object_type, 'normal' ); // Trackback Metabox
	}

	function save_meta_data( $post_id ) {
		// если это автосохранение ничего не делаем
		if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
			return;
		}
		
		// проверяем права юзера
		if( ! current_user_can( 'edit_post', $post_id ) ){
			return;	
		}
		
		// If this isn't a 'trip' post, don't update it.
		if ( AT_TRIP_POST_TYPE !== get_post_type($post_id) ) {
			return;  
		}
		
		if ( empty( $_POST ) ) {
			return;
		}

		if ( ! isset( $_POST['trip_noncename'] ) ) {
			return;
		}
		
		// проверяем nonce нашей страницы, потому что save_post может быть вызван с другого места.
		if (! wp_verify_nonce( $_POST['trip_noncename'], 'at_trip_save_data_process' ) ) {
			return;
		}
		
		$sticky = 0;
		if ( isset( $_POST['trip_sticky'] ) ) {
			$sticky = sanitize_text_field( wp_unslash( $_POST['trip_sticky'] ) );
			if ( 'yes' === $sticky ) {
				$sticky = 1;
			}
		}
		update_post_meta( $post_id, 'trip_sticky', $sticky );
		
		
		$fixed_departure = 0;
		if ( isset( $_POST['trip_fixed_departure'] ) ) {
			$fixed_departure = sanitize_text_field( wp_unslash( $_POST['trip_fixed_departure'] ) );
			if ( 'yes' === $fixed_departure ) {
				$fixed_departure = 1;
			}
		}
		update_post_meta( $post_id, 'trip_fixed_departure', $fixed_departure );

		$enable_sale = 0;
		if ( isset( $_POST['trip_enable_sale'] ) ) {
			$enable_sale = sanitize_text_field( wp_unslash( $_POST['trip_enable_sale'] ) );
			if ( 'yes' === $enable_sale ) {
				$enable_sale = 1;
			}
		}
		update_post_meta( $post_id, 'trip_enable_sale', $enable_sale );

		
		$fields = [
			['trip_start_date', 'time'],
			['trip_end_date',   'time'],

			['trip_duration_days',   'int'],
			['trip_duration_nights', 'int'],
			
			['trip_price',		'int'],
			['trip_currency',   ''],
			['trip_sale_price',	'int'],
			
			['trip_outline',    'html'],
			['trip_include',    'html'],
			['trip_exclude',	'html'],
			['trip_price_details',	'html'],
			['trip_equipment',		'html'],
			['trip_additional_info','html'],
			['trip_gallery','html'],
			
			
			['trip_highest_point',			'int'],
			['trip_technical_difficulty',	'int'],
			['trip_fitness_level',			'int'],
			['trip_group_size',		    	'int'],
			
			['trip_registration_form',	   	'reg_form_url'],
			
		];
		// Store data in post meta table if present in post data
		
		foreach ( $fields as $item ) {
			$field = $item[0];
			if ( isset( $_POST[$field] ) ) {
				switch ( $item[1] ) {
					case 'email':
						$sanitized_value = sanitize_email($_POST[$field]);
						break;
					case 'int':
						$sanitized_value = absint($_POST[$field]);
						break;
					case 'time':
						$sanitized_value = strtotime($_POST[$field]);
						break;
					case 'url':
						$sanitized_value = esc_url($_POST[$field]);
						break;					
					case 'reg_form_url':
						$sanitized_value = esc_url($_POST[$field]);
						if ( strpos($sanitized_value, 'https://docs.google.com/forms') === false && 
						     strpos($sanitized_value, 'https://goo.gl/forms') === false) {
							$sanitized_value = '';
						}
						break;
					case 'html':
						$allowed_html = $this->get_allowed_html();
						$sanitized_value = wp_kses($_POST[$field], $allowed_html);					
						break;
					default:
						$sanitized_value = sanitize_text_field($_POST[$field]);
						break;
				}	
				update_post_meta( $post_id, $field,  $sanitized_value );
			}
		}
	
		if ( isset( $_POST['at_trip_editor'] ) ) {
			$new_content = $_POST['at_trip_editor'];
			$old_content = get_post_field( 'post_content', $post_id );
			if ( ! wp_is_post_revision( $post_id ) && $old_content !== $new_content ) {
				$args = [
					'ID' => $post_id,
					'post_content' => $new_content,
				];

				// Unhook this function so it doesn't loop infinitely.
				remove_action( 'save_post', [&$this, 'save_meta_data'] );
				// Update the post, which calls save_post again.
				wp_update_post( $args );
				// Re-hook this function.
				add_action( 'save_post', [&$this, 'save_meta_data'] );
			}
		}
	}
	function get_allowed_html() : array {
		return [
			'a' => array(
				'class' => [],
				'href'  => [],
				'rel'   => [],
				'title' => [],
				'target'=> [],
			),
			'abbr' => array(
				'title' => [],
			),
			'b' => [],
			'blockquote' => array(
				'cite'  => [],
			),
			'cite' => array(
				'title' => [],
			),
			'code' => [],
			'del' => array(
				'datetime' => [],
				'title' => [],
			),
			'dd' => [],
			'div' => array(
				'class' => [],
				'title' => [],
				'style' => [],
			),
			'dl' => [],
			'dt' => [],
			'em' => [],
			'h1' => [],
			'h2' => [],
			'h3' => [],
			'h4' => [],
			'h5' => [],
			'h6' => [],
			'i' => [],
			'img' => array(
				'alt'    => [],
				'class'  => [],
				'height' => [],
				'src'    => [],
				'width'  => [],
			),
			'li' => array(
				'class' => [],
			),
			'ol' => array(
				'class' => [],
			),
			'p' => array(
				'class' => [],
			),
			'q' => array(
				'cite' => [],
				'title' => [],
			),
			'span' => array(
				'class' => [],
				'title' => [],
				'style' => [],
			),
			'strike' => [],
			'strong' => [],
			'table' => [],
			'tbody' => [],
			'thead' => [],
			'th' => [],
			'tr' => [],
			'td' => [],
			'ul' => array(
				'class' => [],
			),
		];
	}
}
<?php
declare(strict_types=1);
/**
 * AT Trip Tab class
 *
 * @package AT Trip
 */
final class AT_Trip_Tab {
	public $id;
	private $title;
	private $content;
	private $label_class;
	
	public function __construct(string $id, string $title, string $content, string $label_class = '') {
		$this->id = $id;
		$this->title = $title;
		$this->content = $content;
		$this->label_class = $label_class;		
	}
	public function render(bool $is_active) {
		if ( empty( $this->content ) ) {
			return;
		}
		$label_class = $this->label_class;
		if(!empty($label_class)) {
			$label_class = 'class="' . $label_class . '" ';
		}
		?>
		<input type="radio" name="tabs" id="<?php echo $this->id; ?>"<?php if ($is_active) echo  ' checked="checked"'; ?>>
		<label <?php echo $label_class;?>for="<?php echo $this->id; ?>"><?php echo $this->title; ?></label>
		<div class="tab">
			<?php echo apply_filters('the_content', $this->content); ?>
		</div>
		<?php 
	}
}
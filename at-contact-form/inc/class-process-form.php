<?php
final class AT_Process_ContactForm { 
	private $enable_phone;
	private $enable_last_name;
	private $fixed_subject;
	private $subject_choices;
	
	private $hasError = false;

	private $info_message = '';
	
	private $fields = [
		'src_post_id' => [0],
		'first_name'  => ['' , 60, ''],
		'last_name'   => ['',  30, ''],
		'phone'       => ['',  15, ''],
		'email'       => ['',  50, ''],
		'subject'     => ['', 100, ''],
		'message'     => ['', 512, ''],
	];
	
	private $options;
	
	private $reCAPTCHA;
	
	public function is_submit_enabled() {
		return ($this->enable_db() || ($this->enable_email() && !empty($this->get_email())) || $this->enable_admin_email() );
	}
	
	public function __construct($enable_last_name = false, $enable_phone = false, $fixed_subject = '', $subject_choices  = []) {
		$this->options          = get_option( AT_CF_OPTIONS_NAME );
		$this->enable_last_name = $enable_last_name;
		$this->enable_phone     = $enable_phone;
		$this->fixed_subject    = $fixed_subject;
		$this->subject_choices  = $subject_choices;
		
		if ( $this->is_submit_enabled() ) {
			$this->reCAPTCHA = new reCAPTCHA();
			$this->reCAPTCHA->setSiteKey( $this->get_sitekey() );
			$this->reCAPTCHA->setSecretKey( $this->get_secret_key() );
			add_action('wp_head', function() { echo $this->reCAPTCHA->getScript();});
		}
	}
	public function set_fixed_subject($value) {
		$this->fixed_subject = $value;
	}
	private function enable_db() { 
		return (isset( $this->options['enable_db'] ) && absint($this->options['enable_db']));
	}
	
	private function enable_email() { 
		return (isset( $this->options['enable_email'] ) && absint($this->options['enable_email']));
	}
	private function enable_admin_email() { 
		return (isset( $this->options['enable_admin_email'] ) && absint($this->options['enable_admin_email']));
	}
	public function use_captcha() { 
		return  (isset( $this->options['use_captcha'] ) && absint($this->options['use_captcha'] )); 
	}
	private function get_email() { 
		return isset( $this->options['email'] ) ? $this->options['email'] : '';
	}
	private function get_sitekey() { 
		return isset( $this->options['site_key'] ) ? $this->options['site_key'] : '';
	}
	private function get_secret_key() { 
		return isset( $this->options['secret_key'] ) ? $this->options['secret_key'] : '';
	}
	
	static private function get_message_text(string $key) : string {
		$messages = [
			'success'            => 'Спасибо! Ваше сообщение отправлено!',
			'fault'              => 'Ошибка! Ваше сообщение не отправлено! Попробуйте повторить позже.',
			'nonce_not_valid'    => 'Ошибка! Bad nonce!',
			'empty_capture'      => 'Пожалуйста введите Captcha!',
			'ivalid_capture'     => 'Captсha введена неправильно!',
			'first_name_required'=> 'Пожалуйста введите Ваше имя!',
			'last_name_required' => 'Пожалуйста введите Вашу фамилию!',
			'email_required'     => 'Пожалуйста введите Ваш e-mail!',
			'email_not_valid'    => 'Вы ввели неверный e-mail!',
			'phone_required'     => 'Пожалуйста введите Ваш номер телефона!',
			'phone_not_valid'    => 'Вы ввели неверный номер телефона!',
			'subject_required'   => 'Пожалуйста введите тему сообщения!',
			'message_error'      => 'Пожалуйста введите сообщение!',
		]; 
		return $messages[$key];
		
	}
	
	private function set_field_value(string $key, $value)      { $this->fields[$key][0] = $value; }
	
	private function get_field_value(string $key)      { return $this->fields[$key][0]; }
	private function get_field_max_length(string $key)      { return $this->fields[$key][1]; }
	
	private function set_field_error(string $key, string $msg_key) { $this->fields[$key][2] = self::get_message_text($msg_key); }
	private function print_field_error(string $key) {
		if (!empty($this->fields[$key][2]) ) {
			echo '<div class="error">' . esc_html($this->fields[$key][2]) . '</div>';
		}
	}
	function process_data() : bool {
		if (!$this->is_submit_enabled()) {
			return false;
		}

		if( isset($_POST['submitted'])) {
			if ( $this->validate() ) {
				$this->after_sanitize();
				$this->submit();
			}
		}
		return true;
	}
	
	private function validate() {
		if (! wp_verify_nonce( $_POST['_wpnonce'], '_contact_form_submit' ) ) {
			$this->info_message  = self::get_message_text('nonce_not_valid');
			$this->hasError = true;
			return false;
		}
		
		$this->set_field_value('first_name', sanitize_text_field($_POST['first_name']));		
		if( empty($this->get_field_value('first_name') ) ) {
			$this->set_field_error('first_name', 'first_name_required');
			$this->hasError = true;
		}
		
		if ($this->enable_last_name) {
		   $this->set_field_value('last_name',  sanitize_text_field($_POST['last_name']));
		}

		$email = $_POST['email'];
		if( empty( $email ) ) {
			$this->set_field_error('email', 'email_required');
			$this->hasError = true;
		} elseif ( !is_email($email) ) {
			$this->set_field_error('email', 'email_not_valid');
			$this->hasError = true;
		} else {
			$this->set_field_value('email', sanitize_email($email));
		}
			
		if ($this->enable_phone) {
		    $this->set_field_value('phone', sanitize_text_field($_POST['phone']));
			$tel = $this->get_field_value('phone');
			if( empty( $tel ) ) {
				$this->set_field_error('phone', 'phone_required');
				$this->hasError = true;
			} else {
				$tel = preg_replace('/[^0-9+]/', '', $tel);
				$tel_length = strlen($tel);
				if ($tel_length < 7 || $tel_length > 13 ) {
					$this->set_field_error('phone', 'phone_not_valid');
					$this->hasError = true;
				}
			}
			$this->set_field_value('phone', $tel);			
		}

		if ( empty($this->fixed_subject)) {
			$this->set_field_value('subject', sanitize_text_field($_POST['subject']));
			if( empty($this->get_field_value('subject')) ) {
				$this->set_field_error('subject', 'subject_required');			
				$this->hasError = true;
			}
		} else {
			$this->set_field_value('subject', sanitize_text_field($this->fixed_subject));
		}
			
		$this->set_field_value('message', sanitize_text_field($_POST['messageText']));
		if( empty($this->get_field_value('message')) ) {
			$this->set_field_error('message', 'message_required');					
			$this->hasError = true;
		}
			
		if ($this->use_captcha()) {
			
			$recaptcha_response = isset($_POST['g-recaptcha-response']) ? $_POST['g-recaptcha-response'] : '';
			
			if ( empty($recaptcha_response) ) {
				$this->info_message = self::get_message_text('empty_capture');	
				$this->hasError = true;
			} elseif ( !$this->reCAPTCHA->isValid($recaptcha_response) ) {
				$this->info_message = self::get_message_text('ivalid_capture');	
				$this->hasError = true;	
				var_dump( $this->reCAPTCHA->getErrorCodes() );				
			}

		}
		return !$this->hasError;
	}
	private function after_sanitize() {
		global $post;
		$post_id = $post->ID;
		
		if ( $post_id > 0 ) {
			$this->set_field_value( 'src_post_id', $post_id);
		}
		
		foreach ($this->fields as $key => $field) {
			if ($key !== 'src_post_id') {
				$field[0] = substr($field[0], $field[1]);
			}
		}
	}
	
	private function submit() {
		$sent  = false;
		$saved = false;
		
		if ($this->enable_admin_email()) {
			$emailTo = get_option('admin_email');
			if ( $this->send_email( $emailTo ) ) {
				$sent = true;
			}
		}
		
		if ($this->enable_email()) {
			$emailTo = $this->get_email();
			if ( $this->send_email( $emailTo ) ) {
				$sent = true;				
			}
		}
		
		if ($this->enable_db()) {
			$saved = $this->save_message_to_db();
		}
		
		if ( $this->enable_db() ) {
			$this->hasError = !$saved;
		} else {
			$this->hasError = !$sent;
		}
		
		if ( $this->hasError ) {
			$this->info_message = self::get_message_text('fault');			
		} else {
			$this->info_message = self::get_message_text('success');			
		}
	}
	private function send_email( $emailTo ) {
		if (!is_email($emailTo)) {
			return false;
		}
		$name = $this->get_field_value('first_name');
		If (!empty($this->get_field_value('last_name'))) {
			$name .= ' ' . $this->get_field_value('last_name');
		}
				
		$email   =  $this->get_field_value('email');
		$message =  $this->get_field_value('message');
		
		$url = get_site_url();
		
		$to_remove = ['http://', 'https://' ];
		foreach ( $to_remove as $item ) {
			$url = str_replace($item, '', $url); // to: www.example.com
		}
		$headers = 'Content-type: text/plain;charset=utf-8' . "\r\n";
		$headers .= sprintf('From: %s %s <%s>',  $url, $name, $email) . "\r\n";
		$headers .= 'Reply-To: ' . $email;
		 

		$subject = sprintf('Contact Form Submission from %s, visitor of %s', $name, $url);
		
		$body = 'Name: ' . $name . "\n\n";
		$body .= 'Email: ' . $email . "\n\n";
		$body .= 'Comments: ' . $message;
		 
		//mail($emailTo, $subject, $body, $headers);
		return wp_mail($emailTo, $subject, $body, $headers);
	} 
	
	
	private function save_message_to_db() {
		$data = [];
		foreach ($this->fields as $key => $field) {
			$data[$key] = $field[0];
		}		
        global $wpdb;
        $table_name = $wpdb->prefix . AT_CF_TABLE_NAME;
        $wpdb->insert($table_name, $data); 
        $rowid = $wpdb->insert_id;

	    return $rowid !== 0;
	}
	
	public function render_form() {
	?>	
	<div class="atcf-wrapper">
	
		<?php if (!empty($this->info_message) ) : ?>
			<div class="atcf-message-wrapper">
				<span class="<?php echo($this->hasError ? 'errormsg': 'successmsg'); ?>"><?php echo esc_html($this->info_message);?></span>
			</div>
		<?php endif; ?>

		<form action="<?php the_permalink(); ?>" id="contactForm" method="post">
			<ul class="atcf-fields">
				<li class="atcf-i-field atcf-i-first-name">
					<input required type="text" name="first_name" id="first_name" maxlength="<?php echo $this->get_field_max_length('first_name'); ?>" pattern="[A-Za-zА-Яа-яЁё ]+" placeholder="Ваше имя" value="<?php if(isset($_POST['first_name'])) echo esc_attr($_POST['first_name']);?>" class="required requiredField first_name" />
					<?php $this->print_field_error('first_name'); ?>
				</li>
				
				<?php if ($this->enable_last_name) : ?>
				<li class="atcf-i-field">
					<input required type="text" name="last_name" id="last_name" maxlength="<?php echo $this->get_field_max_length('last_name'); ?>" pattern="[A-Za-zА-Яа-яЁё]+" placeholder="Ваша фамилия" value="<?php if(isset($_POST['last_name'])) echo esc_attr($_POST['last_name']);?>" class="required requiredField last_name" />
					<?php $this->print_field_error('last_name'); ?>
				</li>				
				<?php endif; ?>

				<?php if ($this->enable_phone) : ?>
				<li class="atcf-i-field atcf-i-phone">
					<input required type="tel" name="phone" id="phone" maxlength="<?php echo $this->get_field_max_length('phone'); ?>" placeholder="Ваш телефон" value="<?php if(isset($_POST['phone'])) echo esc_attr($_POST['phone']);?>" class="required requiredField phone" />
					<?php $this->print_field_error('phone'); ?>
				</li>				
				<?php endif; ?>

				<li class="atcf-i-field atcf-i-email">
					<input required type="email" name="email" id="email" maxlength="<?php echo $this->get_field_max_length('email'); ?>" placeholder="Ваш e-mail" value="<?php if(isset($_POST['email']))  echo esc_attr($_POST['email']);?>" class="required requiredField email" />
					<?php $this->print_field_error('email'); ?>
				</li>
				
				<?php if ( empty($this->fixed_subject)) :?>
				<li class="atcf-i-field atcf-i-subject">
					<?php if ( empty($this->subject_choices) ) : ?>
						<input required type="text" name="subject" id="subject" maxlength="<?php echo $this->get_field_max_length('subject'); ?>" placeholder="Тема сообщения" value="<?php if(isset($_POST['subject']))  echo esc_attr($_POST['subject']);?>" class="required requiredField subject" />
					<?php else : ?>
						<label for="subject">Тема сообщения</label>
						<select required name="subject" id="subject" class="required requiredField subject">
						<?php foreach($this->subject_choices as $item) : ?>
							<option value="<?php echo $item ?>" <?php selected( $item, isset($_POST['subject']) ? esc_attr($_POST['subject'] ) : ''); ?>><?php echo $item ?></option>
						<?php endforeach; ?>
						</select>
					<?php endif; ?>
					<?php $this->print_field_error('subject'); ?>
				</li>
				<?php endif; ?>
				
				<li>
					<textarea required name="messageText" id="messageText" rows="10" cols="40" maxlength="<?php echo $this->get_field_max_length('message'); ?>" placeholder="Ваше сообщение" class="required requiredField"><?php if(isset($_POST['messageText'])) echo esc_attr($_POST['messageText']); ?></textarea>
					<?php $this->print_field_error('message'); ?>
				</li>
				
				<?php if ($this->use_captcha()) : ?>
					<li>
						<?php echo $this->reCAPTCHA->getHtml();?>
					</li>
				<?php endif; ?>
				
				<li>
					<input type="submit" value="Отправить"/>
				</li>

			</ul>
			<input type="hidden" name="submitted" id="submitted" value="true" />
			<?php echo wp_nonce_field( '_contact_form_submit' ) ?>
		</form>
	</div>
	<?php	
	} 
}
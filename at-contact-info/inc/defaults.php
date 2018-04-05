<?php 
function at_contact_info_default_options() : array {	
	$defaults = [];
	
	// Address.
	$defaults['company_name']     = 'Альпклуб "Одесса"';
	$defaults['street_address_1'] = 'ул.Базарная, 84';
	$defaults['street_address_2'] = '';
	$defaults['city']          	  = 'Одесса';
	$defaults['postal_index']     = '65011';
	$defaults['country']          = 'Украина';

	// Contact.
	$defaults['phone_1']          = '380487256913';
	$defaults['phone_2']          = '380487227360';
	$defaults['phone_3']          = '380673780431';
	$defaults['fax']          	  = '';
	$defaults['email_1']          = 'alpineclubodessa@gmail.com';
	$defaults['email_2']          = '';		
	
	$defaults['skype']            = '';	
	$defaults['whatsapp']         = '';	
	$defaults['tg']               = '';	
	$defaults['viber']            = '';	
	
	$defaults['url']              = 'http://alp.od.ua';	

	//Opening time
	$defaults['opening_time_1']   = 'ПН, ВТ, ЧТ, ПТ 10:00-18:00';
	$defaults['opening_time_2']   = 'СР 10:00-21:00';
	$defaults['opening_time_3']   = 'СБ, ВС выходной';
	$defaults['opening_time_4']   = '';		
	$defaults['opening_time_5']   = '';		
	$defaults['opening_time_6']   = '';		
	$defaults['opening_time_7']   = '';		
	
	return $defaults;
}
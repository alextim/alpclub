<?php
function _get_aco_theme_default_options() : array {	
	$defaults = [];

	$defaults['member_count']                  = 0;		
	$defaults['show_breadcrumb']               = true;
	$defaults['maintenance_mode']              = false;
/*	
	$defaults['ga_active']                    = false;
	$defaults['ga_tracking_id']               = 'UA-116898406-1';
	$defaults['ga_in_footer']                 = false;	
	$defaults['ga_async']                     = true;
*/	
	return $defaults + at_contact_info_default_options();
}
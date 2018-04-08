<?php
/**
 * Load files
 *
 * @package Surya_Chandra
 */

/**
 * Include default theme options.
 */
require_once trailingslashit( get_template_directory() ) . 'inc/customizer/default.php';

/**
 * Load helpers.
 */
require_once trailingslashit( get_template_directory() ) . 'inc/helper/common.php';
require_once trailingslashit( get_template_directory() ) . 'inc/helper/options.php';

/**
 * Load theme core functions.
 */
require_once trailingslashit( get_template_directory() ) . 'inc/core.php';

/**
 * Load libraries.
 */
// ATPTM require_once trailingslashit( get_template_directory() ) . 'lib/tgm/class-tgm-plugin-activation.php';

/**
 * Load hooks.
 */
require_once trailingslashit( get_template_directory() ) . 'inc/hook/basic.php';
require_once trailingslashit( get_template_directory() ) . 'inc/hook/custom.php';
// ATPTM require_once trailingslashit( get_template_directory() ) . 'inc/hook/tgm.php';

/**
 * Load metabox.
 */
require_once trailingslashit( get_template_directory() ) . 'inc/metabox.php';

/**
 * Custom template tags for this theme.
 */
require_once trailingslashit( get_template_directory() ) . 'inc/template-tags.php';

/**
 * Customizer additions.
 */ // ATPTM
if (is_customize_preview()) { require_once trailingslashit( get_template_directory() ) . 'inc/customizer.php'; }

/**
 * Load site origin.
 */
require_once trailingslashit( get_template_directory() ) . 'inc/site-origin.php'; 

/**
 * Load OCDI Support.
 */
// ATPTM require_once trailingslashit( get_template_directory() ) . 'inc/supports/ocdi.php';

/**
 * Load info.
 */
// ATPTM if ( is_admin() ) {
// ATPTM 	require_once trailingslashit( get_template_directory() ) . 'lib/info/class.info.php';
// ATPTM 	require_once trailingslashit( get_template_directory() ) . 'lib/info/info.php';
// ATPTM }

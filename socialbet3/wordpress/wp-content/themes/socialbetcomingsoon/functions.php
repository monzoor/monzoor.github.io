<?php
/**
 * Functions file
 *
 * @development 2014
 * @version 1.0
 */

/** simple security check */
if( ! defined('ABSPATH') ) exit;

if ( ! isset( $content_width ) ) 
	$content_width = 535;

if( ! defined('SBSOON_VERSION') ) define('SBSOON_VERSION', '1.2.2' );

/**
 * The main class
 *
 * @since version 1.0
 */
require_once( get_template_directory() . '/inc/class-socbet-soon.php' );

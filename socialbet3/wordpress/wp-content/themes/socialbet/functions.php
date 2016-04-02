<?php
/**
 * Functions file
 *
 * @development 2014
 * @version 1.0
 */

/** simple security check */
if ( ! defined('ABSPATH') )
	exit;

if ( ! isset( $content_width ) )
	$content_width = 800;

/**
 * prefix for any post meta, options, etc
 * just to make sure we are save if we use any 3rd plugins or modules
 */
if ( ! defined('SOCIALBET_NAME') )
	define('SOCIALBET_NAME', 'socbet' );

if ( ! defined('SOCIALBET_VERSION') )
	define('SOCIALBET_VERSION', '1.0' );

/**
 * The main class
 *
 * @since version 1.0
 */
require_once( get_template_directory() . '/inc/class-socbet-theme.php' );
// db helper
require_once( get_template_directory() . '/inc/class-sbdb.php' );
<?php
/**
 * Installation file
 *
 */

if( ! defined('ABSPATH') )
	exit;

/**
 * create a table to store email data
 *
 * @return void
 */
function socbet_soon_install_db() {
	global $wpdb;

	$wpdb->hide_errors();

	$subbscribeTable = $wpdb->prefix . "socbet_subscribes";

	if ( $wpdb->get_var( "SHOW TABLES like '$subbscribeTable'" ) != $subbscribeTable ) {
		$wpdb->query( $wpdb->prepare(
			"CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}socbet_subscribes` (
			  `id` bigint(20) UNSIGNED NOT NULL auto_increment,
			  `email` varchar(100),
			  `email_activation_key` varchar(60),
			  `registered` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
			  `email_status` int(11) NOT NULL DEFAULT '0',
			  PRIMARY KEY (`id`) )"
		  ) );

      $wpdb->query( $sql );

	  update_option( 'sobet_soon_installed', 'yes' );
	}

	return false;
}
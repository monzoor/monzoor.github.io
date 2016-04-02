<?php
/**
 * Class to handle user messages
 *
 * @version 1.0
 */

if ( ! defined( 'ABSPATH' ) )
	exit;

class Socbet_Umessage {

	private $_run;

	private $_table;

	private $_reply_table;

	private $_user_id;

	public function __construct() {
		global $wpdb, $current_user;
		get_currentuserinfo();

		if ( is_own_profile() && is_socbet_user_settings_page() == 'moi-soobshcheniya' ) {
			$this->_run = true;
		} else {
			$this->_run = false;
		}

		$this->_table = $wpdb->prefix . 'socbet_messages';
		$this->_reply_table = $wpdb->prefix . 'socbet_message_replies';
		$this->_user_id = $current_user->ID;

	}

	public function message_query() {
		global $wp_query, $wpdb;

		if ( $this->_run ) {
	    	$paged = 1;
	    	if ( isset( $wp_query->query_vars['paged'] ) ) {
	    		$paged = absint( $wp_query->query_vars['paged'] );
	    	}
	    	if ( $paged < 1 )
	    		$paged = 1;

	        $diff = (int) ( ( $paged - 1 ) * 20 );
	    	$limits = "LIMIT $diff, 20";
	    	$messages = $wpdb->get_results( "SELECT * FROM {$this->_table} WHERE user_id = $this->_user_id OR user_id_to = $this->_user_id ORDER BY id DESC $limits" );

	    	if ( $messages )
	    		return $messages;

	    }

	    return false;
	}

	public function get_details( $msg_id ) {
		global $wpdb;

		$msg = $wpdb->get_row("SELECT * FROM $this->_table WHERE id = $msg_id");
		if ( is_null($msg) )
			return false;

		return $msg;
	}


	public function get_replies( $msg_id ) {
		global $wpdb;

		$msg_id = esc_sql($msg_id);
		$messages = $wpdb->get_results( "SELECT * FROM {$this->_reply_table} WHERE message_id = $msg_id ORDER BY id ASC" );

		if ( $messages )
			return $messages;

		return false;
	}

	public function marked_read( $msg_id ) {
		global $wpdb;

		$wpdb->update( 
			$this->_table, 
			array( 'status' => '0' ), 
			array( 'id' => $msg_id, 'status' => '1' ), 
			array( '%d' ), 
			array( '%d', '%d' ) 
		);

		return true;
	}

	public function marked_reply_read( $msg_id, $user_id ) {
		global $wpdb;

		$wpdb->query(
			"
			UPDATE $this->_reply_table 
			SET status = 0
			WHERE message_id = $msg_id AND status = '1' AND user_id <> $user_id
			"
		);

		return true;
	}

	public function remove_message( $msg_id ) {
		global $wpdb;

		$wpdb->update( 
			$this->_table, 
			array( 'status' => '3' ), 
			array( 'id' => $msg_id, 'status' => '0' ), 
			array( '%d' ), 
			array( '%d', '%d' ) 
		);

		return true;
	}

	public function reactivate_message( $msg_id ) {
		global $wpdb;

		$wpdb->update( 
			$this->_table, 
			array( 'status' => '0' ), 
			array( 'id' => $msg_id, 'status' => '3' ), 
			array( '%d' ), 
			array( '%d', '%d' ) 
		);

		return true;
	}

}
<?php
/**
 * Create some custom pages under the event post type
 *
 * @since ver 1.0
 */

if ( ! defined('ABSPATH') ) 
	exit;

if ( ! class_exists('Socbet_Admin_Custompages') ) {

class Socbet_Admin_Custompages {

	public function __construct() {
		add_action( 'admin_menu', array($this, 'add_market_pages') );
	}

	/**
	 * Register our new admin pages
	 *
	 * @return void
	 */
	public function add_market_pages() {
		// listing page
		add_submenu_page(
			null,
			__('Available Markets', 'socialbet'),
			__('Available Markets', 'socialbet'),
			'manage_options',
			'show-markets',
			array($this, 'market_page_content')
			);

		// manually market creation
		// only if we needed this
		add_submenu_page(
			null,
			__('Add New Market', 'socialbet'),
			__('Add New Market', 'socialbet'),
			'manage_options',
			'create-market',
			array($this, 'market_add_new')
			);

		add_submenu_page(
			null,
			__('Edit Market', 'socialbet' ),
			__('Edit Market', 'socialbet' ),
			'manage_options',
			'edit-market',
			array($this, 'market_edit')
			);
	}


	/**
	 * Template of market listing on admin
	 * 
	 * @return void
	 */
	public function market_page_content() {
		global $wpdb, $sbdb;

		$eid = isset( $_GET['event'] ) ? absint($_GET['event']) : false;

		if ( !$eid ) {
			wp_redirect( admin_url('edit.php?post_type=event') );
			exit;
		}

		$event = get_post($eid);

		if ( is_wp_error($event) ) {
			wp_redirect( admin_url('edit.php?post_type=event') );
			exit;
		}

		if ( isset( $_GET['action'] ) && $_GET['action'] == 'delete' ) {
			// check for security
	    	if ( empty( $_GET['_wpnonce'] ) || ! wp_verify_nonce( $_GET['_wpnonce'], 'socbet-remove-market' ) ) {
				wp_redirect( admin_url('edit.php?post_type=event&page=show-markets&event='.$event->ID.'&message=6') );
				exit;   		
	    	}

	    	$market_id = isset( $_GET['market_id'] ) ? absint( $_GET['market_id'] ) : '0';

	    	//remove odds
	    	$wpdb->delete( $wpdb->socbet_odds, array('market_id' => esc_sql($market_id)), array('%d') );
	    	// remove market
	    	$wpdb->delete( $wpdb->socbet_market, array('event_id' => esc_sql($event->ID)), array('%d') );

			wp_redirect( admin_url('edit.php?post_type=event&page=show-markets&event='.$event->ID.'&message=3') );
			exit; 
		}

		$markets = $sbdb->get_results( 'socbet_market', 'event_id', $event->ID );

		compact( array(
			'markets' => $markets
			) 
		);

		include( get_template_directory() . '/inc/admin/templates/admin-markets.phtml' );
	}


	/**
	 * Add new market
	 * 
	 * @return void
	 */
	public function market_add_new() {
		global $wpdb, $sbdb;

		$errors = new WP_Error();
		$eid = isset( $_GET['event'] ) ? absint($_GET['event']) : false;

		if ( ! $eid ) {
			wp_redirect( admin_url('edit.php?post_type=event') );
			exit;
		}

		$event = get_post($eid);

		if ( is_wp_error($event) ) {
			wp_redirect( admin_url('edit.php?post_type=event') );
			exit;
		}

		if ( 'POST' == $_SERVER['REQUEST_METHOD'] ) {
			$redirect = isset( $_POST['_wp_http_referer'] ) ? $_POST['_wp_http_referer'] : '';

			// wpnonce check
	    	if ( empty( $_POST['_wpnonce'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], 'socbet-new-market' ) )
	    		$errors->add( 'null_security', __('Action failed. Security check is failed.', 'socialbet') );

	    	$market_name = isset( $_POST['market_name'] ) ? $_POST['market_name'] : '';

	    	if ( empty($market_name) )
	    		$errors->add( 'blank_title', __('Action failed. Please Enter the Market Name.', 'socialbet') );


			if ( $errors->get_error_code() ) {
				include( get_template_directory() . '/inc/admin/templates/new-market.phtml' );
				return;
			}


			// insert the market
			if ( $wpdb->insert( $wpdb->socbet_market, array('event_id' => esc_sql($event->ID), 'name' => esc_sql($market_name), 'slug' => sanitize_title($market_name)), array('%d','%s','%s') ) ) {
				//get the id from market table
				$mid = $wpdb->insert_id;

				if ( isset( $_POST['mentry_name'] ) ) {
					foreach( (array) $_POST['mentry_name'] as $key => $hpost ) {

						$wpdb->insert( $wpdb->socbet_odds, array(
							'market_id' => $mid,
							'name' => esc_sql( $_POST['mentry_name'][$key] ),
							'slug' => sanitize_title( $_POST['mentry_name'][$key] ),
							'odds' => esc_sql( $_POST['mentry_odds'][$key] ),
							'decimal_odds'=> esc_sql( $_POST['mentry_decimal_odds'][$key] ),
							'price' => esc_sql( $_POST['mentry_price'][$key] )
							), array('%d', '%s', '%s', '%s', '%s', '%d') );

					}
					unset($key);
					unset($hpost);
				}

				wp_redirect( admin_url('edit.php?post_type=event&page=show-markets&event='.$event->ID) );
				exit;

			} else {

				$errors->add( 'wpdb_error', __('Error: Cannot save the data to database.', 'socialbet') );
				include( get_template_directory() . '/inc/admin/templates/new-market.phtml' );
				return;

			}

		} else {
			include( get_template_directory() . '/inc/admin/templates/new-market.phtml' );
		}

	}

	function market_edit() {
		global $wpdb, $sbdb;

		$errors = new WP_Error();
		$eid = isset( $_GET['event'] ) ? absint($_GET['event']) : false;
		$mid = isset( $_GET['market_id'] ) ? absint($_GET['market_id']) : false;

		if ( ! $eid ) {
			wp_redirect( admin_url('edit.php?post_type=event') );
			exit;
		}

		if ( ! $mid ) {
			wp_redirect( admin_url('edit.php?post_type=event') );
			exit;
		}

		$event = get_post($eid);

		if ( is_wp_error($event) ) {
			wp_redirect( admin_url('edit.php?post_type=event') );
			exit;
		}

		$mid = esc_sql($mid);
		$market = $sbdb->get_row( 'socbet_market', "id={$mid}");

		if ( $market == null ) {
			wp_redirect( admin_url('edit.php?post_type=event') );
			exit;
		}

		$odds = $sbdb->get_results( 'socbet_odds', 'market_id', $market->id );

		if ( 'POST' == $_SERVER['REQUEST_METHOD'] ) {
			$redirect = isset( $_POST['_wp_http_referer'] ) ? $_POST['_wp_http_referer'] : '';

			// wpnonce check
	    	if ( empty( $_POST['_wpnonce'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], 'socbet-edit-market' ) )
	    		$errors->add( 'null_security', __('Action failed. Security check is failed.', 'socialbet') );

	    	$market_name = isset( $_POST['market_name'] ) ? $_POST['market_name'] : '';

	    	if ( empty($market_name) )
	    		$errors->add( 'blank_title', __('Action failed. Please Enter the Market Name.', 'socialbet') );

			if ( $errors->get_error_code() ) {
				include( get_template_directory() . '/inc/admin/templates/edit-market.phtml' );
				return;
			}

			if ( $market_name != $market->name ) {
				//changed, update the data
				$wpdb->update( $wpdb->socbet_market, array('name' => esc_sql($market_name), 'slug' => sanitize_title($market_name)), array('id' => $market->id), array('%s','%s'), array('%d') );
			}

			if ( !empty($odds) ) {
				foreach( $odds as $o ) {
					//remove them
					$wpdb->delete( $wpdb->socbet_odds, array('id' => $o->id), array('%d') );
				}
				unset( $o );
			}

			if ( isset( $_POST['mentry_name'] ) ) {
				
				foreach( (array) $_POST['mentry_name'] as $key => $hpost ) {
					$wpdb->insert( $wpdb->socbet_odds, array(
						'market_id' => $market->id,
						'name' => esc_sql( $_POST['mentry_name'][$key] ),
						'slug' => sanitize_title( $_POST['mentry_name'][$key] ),
						'odds' => esc_sql( $_POST['mentry_odds'][$key] ),
						'decimal_odds'=> esc_sql( $_POST['mentry_decimal_odds'][$key] ),
						'price' => esc_sql( $_POST['mentry_price'][$key] )
						), array('%d', '%s', '%s', '%s', '%s', '%d') );

				}
				unset( $key );
				unset( $hpost );
			}

			wp_redirect( admin_url("edit.php?post_type=event&page=edit-market&event={$event->ID}&market_id={$market->id}&message=1") );
			exit;

		} else {
			include( get_template_directory() . '/inc/admin/templates/edit-market.phtml' );
		}

	}

}

$GLOBALS['Socbet_Admin_Custompages'] = new Socbet_Admin_Custompages();

}
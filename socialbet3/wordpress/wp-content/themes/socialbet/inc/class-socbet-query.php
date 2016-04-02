<?php
/**
 * WordPress queries handler
 *
 * @ver 1.0
 */

if ( ! defined( 'ABSPATH' ) )
	exit;

class Socbet_Query {

	private $_user;

	public function __construct() {

		add_filter( 'pre_get_posts', array( $this, 'pre_get_posts' ) );
		add_filter( 'the_posts', array( $this, 'get_the_posts' ), 11, 2 );
		add_filter( 'wp', array( $this, 'remove_socbet_query' ) );

	}


	public function pre_get_posts( $q ) {
		
		//only filter the main query
		if ( ! $q->is_main_query() )
			return;

		//user profile/index page
		if ( is_socbet_user_page() && !isset( $q->query['user_page'] ) ) {

			$this->remove_socbet_query();

			$var_user = get_user_by('login', $q->get('user') );

			//not match with any users, sent them to 404 page
			if ( ! $var_user ) {
				$q->is_404 = true;
				return $q;
			}

			$q->set( 'post_type', 'timeline' );
			$q->set( 'author_name', $q->get('user') );
			$q->set( 'page_id', '' );
			// read the normal pagination query
			if ( isset( $q->query['paged'] ) )
				$q->set( 'paged', $q->query['paged'] );

			global $wp_post_types;


			$q->is_page 	= false;

			$wp_post_types['timeline']->ID 			= $var_user->ID;
			$wp_post_types['timeline']->post_title 	= $var_user->display_name;
			$wp_post_types['timeline']->post_name 	= $var_user->nicename;

			$q->is_singular = false;
			$q->is_home = false;
			$q->is_front_page = false;
			$q->is_post_type_archive = true;
			$q->is_archive = true;

			$this->make_query( $q );

			$this->remove_socbet_query();
		}
	}


	/** 
	 * Hook into before loops fuction, the_posts
	 *
	 * @access public
	 * @return void
	 */
	public function get_the_posts( $posts, $query = false ){

		if ( ! $query )
			return $posts;

		//this is not forum looping?
		if ( ! empty( $query->socbet_query ) )
			return $posts;

		//not forum related loops
		if 	( ! $query->is_post_type_archive( 'timeline' ) )
	   		return $posts;

		// Shorthand.
		$q = &$query->query_vars;

		// Fill again in case pre_get_posts unset some vars.
		$q = $query->fill_query_vars($q);

		// pagination var
		$page = absint($q['paged']);
		if ( !$page )
			$page = 1;

		if ( empty($q['nopaging']) && !$query->is_singular ) {
			$page = absint($q['paged']);
			if ( !$page )
				$page = 1;
		}

		$filtered_posts = array();

		// posts is original post lists found by WordPress
		foreach ( $posts as $post ) {
			$filtered_posts[] = $post;
		}
		unset($post);

		$query->posts = $filtered_posts;
		$query->post_count = count( $filtered_posts );
		
		//debuging debuging, see how sql code is generated
		//var_dump( $query->request);
		
		return $filtered_posts;
	}

	public function make_query( $q ) {
		$q->set( 'socbet_query', true );
	}


	public function remove_socbet_query() {
		remove_filter( 'pre_get_posts', array($this, 'pre_get_posts') );
	}

}
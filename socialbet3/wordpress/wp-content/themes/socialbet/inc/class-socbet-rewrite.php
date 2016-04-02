<?php
/**
 * Some custom permalink used with this theme
 * - market, will be set after the even permalink
 *   e.g /football/england/premier-league/manchester-united-vs-chelsea/{winner}/
 *   for odds we need adding a more path or WP will ignored our query
 *   e.g /football/england/premier-league/manchester-united-vs-chelsea/{winner}/o/{draw}
 *
 * - custom user rewrite
 *   base of user page will use 'user/' <----- can be changed later
 *   adding custom query vars for custom user pages
 *
 * @since ver 1.0
 */

if ( ! defined('ABSPATH') )
	exit;

if ( ! class_exists('Socbet_Rewrite') ) {

	class Socbet_Rewrite {

		private $user_base = 'user';

		public function __construct() {
			add_action( 'init', array($this, 'init') );
		}

		public function init() {
			$this->add_rewrite_tags();
			$this->add_rewrite_rules();
			$this->add_user_permastruct();

			add_filter( 'query_vars', array($this, 'register_vars') );
			add_filter( 'author_link', array($this, 'filter_author_link'), 10, 3 );
			add_action( 'template_redirect', array($this, 'template_redirect_user') );
		}


		/**
		 * Registering custom permastruct, for user profile page
		 * example your_site/user/%user%
		 *
		 * @access public
		 * @return void
		 */
		public function add_user_permastruct() {		
			$permastruct_args = array(
				'with_front' 	=> true,
				'ep_mask'		=> 'EP_NONE'
				);
			add_permastruct( 'user', $this->user_base . '/%user%', $permastruct_args );
		}

		public function add_rewrite_tags() {
			// custom base user permalink
			// for now will use 'user' instead 'author' (can change this later)
			add_rewrite_tag( '%user%', '([^/]+)', 'user=' );
			// fix the '%sport_type%' event permalink
			add_rewrite_tag( '%sport_type%', '(.+?)', 'sport_type=' );

		}

		/**
		 * @see wp_rewrite::rewrite_rules
		 * add new permalink rules with custom query
		 *
		 * @access public
		 * @return void
		 */
		public function add_rewrite_rules() {
			global $wpdb;

			// odds
			add_rewrite_rule( "^event/(.+?)/([^/]+)/m/([^/]+)/o/([^/]+)/?$", 'index.php?sport_type=$matches[1]&event=$matches[2]&market=$matches[3]&odds=$matches[4]', 'top' );
			// markets
			add_rewrite_rule( "^event/(.+?)/([^/]+)/m/([^/]+)/?$", 'index.php?sport_type=$matches[1]&event=$matches[2]&market=$matches[3]', 'top' );

			// add pagination rules, incase we need it later
			add_rewrite_rule( "^".$this->user_base."/([^/]+)/(?:(?!page)+)([^/]+)/page/?([0-9]+)/?", 'index.php?user=$matches[1]&user_page=$matches[2]&paged=$matches[3]', 'top' );
			add_rewrite_rule( "^".$this->user_base."/([^/]+)/(?:(?!page)+)([^/]+)/dialog/?([0-9]+)/?", 'index.php?user=$matches[1]&user_page=$matches[2]&dialog=$matches[3]', 'top' );
			// user special pages, will get the query with $wp_query->query_vars['user_page'] and define the outputs
			add_rewrite_rule( "^".$this->user_base."/([^/]+)/(?:(?!page)+)([^/]+)/?", 'index.php?user=$matches[1]&user_page=$matches[2]', 'top' );
			// add pagination rules, for ajax or other purpose
			add_rewrite_rule( "^".$this->user_base."/([^/]+)/page/?([0-9]+)/?", 'index.php?user=$matches[1]&paged=$matches[2]', 'top' );
			// inject users rewrite
			add_rewrite_rule( "^".$this->user_base."/([^/]+)/?", 'index.php?user=$matches[1]', 'top' );
		}

		/**
		 * @see wp:query_vars
		 * filtering query_vars, let wordpress know our custom queries
		 *
		 * @access public
		 * @return void
		 */
		public function register_vars( $vars ) {
			// register the market
			array_push($vars, 'market');
			// register odds
			array_push($vars, 'odds');
			// user
			array_push($vars, 'user');
			array_push($vars, 'user_page');
			array_push($vars, 'dialog');
			
			return $vars;
		}

		public function filter_author_link( $link, $author_id, $author_nicename ) {
			global $wp_rewrite;

			$link = $wp_rewrite->get_extra_permastruct('user');
			//var_dump($link);
			if ( empty($link) ) {
				$file = home_url( '/' );
				$link = $file . '?user=' . $author_nicename;
			} else {
				if ( '' == $author_nicename ) {
					$user = get_userdata($author_id);
					if ( !empty($user->user_nicename) )
						$author_nicename = $user->user_nicename;
				}
				$link = str_replace( '%user%', $author_nicename, $link );
				$link = home_url( user_trailingslashit( $link ) );
			}

			return $link;
		}

		/**
		 * prevent any users to access site.com/author/author-nicename
		 * and redirect them to new user permalink site.com/user/author-nicename
		 *
		 * @access public
		 * @return void
		 */
		public function template_redirect_user() {
			global $wp_query;

			if ( is_author() ) {
				$autID = absint($wp_query->query_vars['author']);
				$authName = $wp_query->query_vars['author_name'];
				$link_to = get_author_posts_url( $autID, $authName );

				wp_redirect( $link_to );
				exit;
			}
		}

	}

}
<?php
/**
 * WP login helper class
 *
 * @since ver 1.0
 */

if ( ! defined('ABSPATH') )
	exit;

if ( ! class_exists('SocbetWpLogin') ) {

	class SocbetWpLogin {

		private $login_php;

		private $login_slug = 'login';

		public function __construct() {
			add_action( 'init', array($this, 'init_loaded') );
			add_action( 'wp_loaded', array($this, 'wp_loaded') );
			add_filter( 'site_url', array($this, 'site_url'), 10, 4 );
			add_filter( 'network_site_url', array($this, 'network_site_url'), 10, 3 );
			add_filter( 'wp_redirect', array($this, 'wp_redirect'), 10, 2 );
			// remove the default redirection
			remove_action( 'template_redirect', 'wp_redirect_admin_locations', 1000 );
		}

		private function template_loader() {
			global $pagenow;

			$pagenow = 'index.php';

			if ( ! defined('WP_USE_THEMES') ) {
				define('WP_USE_THEMES', true);
			}

			wp();

			if ( $_SERVER['REQUEST_URI'] === $this->user_trailingslashit( str_repeat('-/', 10) ) ) {
				$_SERVER['REQUEST_URI'] = $this->user_trailingslashit( '/wp-login-php/' );
			}

			require_once( ABSPATH . WPINC . '/template-loader.php' );
			die;
		}

		private function use_trailing_slashes() {
			return ( '/' === substr( get_option( 'permalink_structure' ), -1, 1 ) );
		}

		private function user_trailingslashit( $string ) {
			return $this->use_trailing_slashes() ? trailingslashit( $string ) : untrailingslashit( $string );
		}

		/**
		 * get login URL
		 * defined by permalink setting
		 *
		 * @return string
		 */
		public function login_url( $scheme ) {
			// pretty permalink is active?
			if ( get_option( 'permalink_structure' ) ) {
				return $this->user_trailingslashit( home_url('/', $scheme) . $this->login_slug );
			} else {
				return home_url('/', $scheme) . '?' . $this->login_slug;
			}	
		}

		public function init_loaded() {
			global $pagenow;

			/**
			 * not multisite but people try to open wp-activate?
			 * break the process
			 */
			if ( ! is_multisite() && ( strpos($_SERVER['REQUEST_URI'], 'wp-signup') !== false || strpos($_SERVER['REQUEST_URI'], 'wp-activate') ) !== false ) {
				wp_die( __( 'This feature is not enabled.', 'socialbet') );
			}

			$request = parse_url( $_SERVER['REQUEST_URI'] );

			if ( ! is_admin() && ( strpos($_SERVER['REQUEST_URI'], 'wp-login.php') !== false || untrailingslashit( $request['path'] ) === site_url('wp-login', 'relative') ) ) {
				$this->login_php = true;

				$_SERVER['REQUEST_URI'] = $this->user_trailingslashit( '/' . str_repeat('-/', 10) );
				$pagenow = 'index.php';

			} elseif ( untrailingslashit( $request['path'] ) === home_url($this->login_slug, 'relative') || ( ! get_option( 'permalink_structure' ) && isset( $_GET[$this->login_slug] ) && empty( $_GET[$this->login_slug] ) ) ) {

				$pagenow = 'wp-login.php';

			}

		}

		public function wp_loaded() {
			global $pagenow;

			/** allow only ajax action */
			if ( is_admin() && ! is_user_logged_in() && ! defined('DOING_AJAX') ) {
				wp_die( __( 'You must log in to access the admin area.', 'socialbet' ) );
			}

			$request = parse_url( $_SERVER['REQUEST_URI'] );

			if ( $pagenow === 'wp-login.php' && $request['path'] !== $this->user_trailingslashit($request['path']) && get_option( 'permalink_structure' ) ) {

				wp_safe_redirect( $this->user_trailingslashit( $this->login_url() ) . ( ! empty($_SERVER['QUERY_STRING']) ? '?' . $_SERVER['QUERY_STRING'] : '' ) );
				die;

			} elseif ( $this->login_php ) {

				if ( ( $referer = wp_get_referer() ) && strpos( $referer, 'wp-activate.php' ) !== false && ( $referer = parse_url( $referer ) ) && ! empty( $referer['query'] ) ) {
					parse_str( $referer['query'], $referer );

					if ( ! empty( $referer['key'] ) && ( $result = wpmu_activate_signup( $referer['key'] ) ) && is_wp_error( $result ) && ( $result->get_error_code() === 'already_active' || $result->get_error_code() === 'blog_taken' ) ) {

						wp_safe_redirect( $this->login_url() . ( ! empty( $_SERVER['QUERY_STRING'] ) ? '?' . $_SERVER['QUERY_STRING'] : '' ) );
						die;

					}

				}

				$this->template_loader();

			} elseif ( $pagenow === 'wp-login.php' ) {

				// redirect any logged in user
				if ( is_user_logged_in() ) {
					if( !isset( $_GET['action'] ) || ( isset( $_GET['action'] ) && $_GET['action'] !== 'logout' ) ) {
						wp_safe_redirect( admin_url() );
						die;		
					}
				}

				require_once( get_template_directory() . '/inc/login/login-handler.php' );
				die;
			}

		}

		public function filter_wp_login_php( $url, $scheme = null ) {
			if ( strpos( $url, 'wp-login.php' ) !== false ) {

				if ( is_ssl() ) {
					$scheme = 'https';
				}

				$args = explode( '?', $url );

				if ( isset( $args[1] ) ) {
					parse_str( $args[1], $args );
					$url = add_query_arg( $args, $this->login_url( $scheme ) );
				} else {
					$url = $this->login_url( $scheme );
				}

			}

			return $url;
		}

		public function site_url( $url, $path, $scheme, $blog_id ) {
			return $this->filter_wp_login_php( $url, $scheme );
		}

		public function network_site_url( $url, $path, $scheme ) {
			return $this->filter_wp_login_php( $url, $scheme );
		}

		public function wp_redirect( $location, $status ) {
			return $this->filter_wp_login_php( $location );
		}
	}

	new SocbetWpLogin();
}
<?php
/**
 * Theme main class
 *
 * @version 1.0
 */

if ( ! defined('ABSPATH') ) 
	exit;

if ( ! class_exists('SocBet_Theme') ) {

class SocBet_Theme {

	// @var theme_url
	public $theme_url;
	// @var theme_path
	public $theme_path;
	public $query;
	public $rewrite;
	public $countries;
	public $mailer;

	/**
	 * Class contructor
	 *
	 * @return void
	 */
	public function __construct() {
		// call all required files
		$this->filesIncluded();

		$this->socbet_register_tables_db();
		
		add_action( 'init', array($this, 'init'), 5 );
		add_filter( 'cron_schedules', 'cron_add_more_schedules');
		add_action( 'after_setup_theme', array($this, 'theme_setup') );
		add_filter( 'wp_loaded', array($this, 'flushRules') );
		add_action( 'admin_init', array($this, 'installBoost'), 10, 0 );
		add_action( 'switch_theme', array($this, 'roleback_datas') );

	}

	/**
	 * init handler
	 *
	 * @return void
	 */
	public function init() {
		do_action( 'before_socbet_init' );

		$this->theme_url = get_template_directory_uri();	
		$this->theme_path = get_template_directory();
		$this->first_install();
		$this->rewrite = new Socbet_Rewrite();
		$this->countries = new Socbet_Countries();
		$this->mailer = new Socbet_Mailer();
		/**
		 * these post types should call before init
		 * or they get ignored by WP
		 */
		$custom_cpt = new Socbet_Custom_Cpt();
		$custom_cpt->register_custom_post_types();	

		add_filter('wp_unique_post_slug', array($this, 'inner_unique_post_slug'), 10, 4);
		add_filter('sanitize_title', array($this, 'inner_sanitize_title'), 10, 3);

		if ( ! is_admin() ) {
			$this->query = new Socbet_Query();
			
			add_filter( 'template_include', 'socbet_output_template' );
			add_filter( 'template_redirect', 'socbet_global_template_redirect' );
			add_action( 'wp_enqueue_scripts', array($this, 'load_frontend_assets'), 5 );
		}

		add_action( 'login_enqueue_scripts', 'socbet_remove_login_styles' );
		add_action( 'login_enqueue_scripts', 'socbet_add_login_styles' );

		do_action( 'socbet_init' );
	}

	/**
	 * Flush rules!!!!
	 * we call only at wp_loaded
	 */
	public function flushRules() {
		global $wp_rewrite;
	   	flush_rewrite_rules();
	}

	public function mailer() {
		return $this->mailer;
	}

	/**
	 * Call require files
	 *
	 * @return void
	 */
	public function filesIncluded() {
		// custom login handler
		// move the wp-login.php to /login/ (can change with any slug later)
		// only work if pretty permalink is active
		require_once( get_template_directory() . '/inc/login/class-socbet-login.php' );
		// auto custom post types creation!
		require_once( get_template_directory() . '/inc/class-socbet-custom-post-types.php' );
		require_once( get_template_directory() . '/inc/class-socbet-query.php' );
		require_once( get_template_directory() . '/inc/class-socbet-json.php' );
		require_once( get_template_directory() . '/inc/class-socbet-rewrite.php' );
		require_once( get_template_directory() . '/inc/class-socbet-mailer.php' );
		require_once( get_template_directory() . '/helpers/class-socbet-countries.php' );
		require_once( get_template_directory() . '/helpers/transliteration/transliteration.inc.php' );
		// core functions
		require_once( get_template_directory() .'/inc/core-functions.php' );

		if ( is_admin() ) {
			//admin init
			require_once( get_template_directory() . '/inc/admin/admin-init.php' );
			require_once( get_template_directory() . '/inc/lists/admin/class-socbet-admin.php' );
			require_once( get_template_directory() . '/inc/admin/write-box.php' );
		
		}

		// functions related to user
 		require_once( get_template_directory() .'/inc/user-template.php' );
 		// menu templates
 		require_once( get_template_directory() .'/inc/menu-template.php' );

	}

	public function first_install() {
		require_once( get_template_directory() .'/inc/install.php' );

		socbet_20141029_installation();
	}

	public function socbet_register_tables_db() {
		  global $wpdb;
		  
		  $markettab = 'socbet_markets';
		  $oddstab = 'socbet_odds';
		  $wpdb->socbet_market = $wpdb->prefix.$markettab;
		  $wpdb->socbet_odds = $wpdb->prefix.$oddstab;

		  $wpdb->tables[] = 'socbet_markets';
		  $wpdb->tables[] = 'socbet_odds';
	}

	/**
	 * Load js and css files for front-end
	 *
	 * @return void
	 */
	public function load_frontend_assets() {
		/** loads jquery */
		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ui-tabs');
		wp_enqueue_script('jquery-ui-accordion');
		
		/** 
		 * place all js (except) jQuery in footer
		 */
		wp_enqueue_script( 'socialbet-mdnzr', $this->theme_url . '/assets/js/lib/modernizr.custom.js', array('jquery'), SOCIALBET_VERSION, true );
		wp_enqueue_script( 'socialbet-selectivizr', $this->theme_url . '/assets/js/lib/selectivizr-min.js', array('jquery', 'socialbet-mdnzr'), SOCIALBET_VERSION, true );
		wp_enqueue_script( 'socialbet-classie', $this->theme_url . '/assets/js/lib/classie.js', array('jquery', 'socialbet-mdnzr'), SOCIALBET_VERSION, true );
		wp_enqueue_script( 'socialbet-me', $this->theme_url . '/assets/js/lib/modalEffects.js', array('jquery', 'socialbet-mdnzr'), SOCIALBET_VERSION, true );
		wp_enqueue_script( 'socialbet-treeview', $this->theme_url . '/assets/js/lib/jquery.treeview.min.js', array('jquery', 'socialbet-mdnzr'), SOCIALBET_VERSION, true );
		wp_enqueue_script( 'socialbet-cookie', $this->theme_url . '/assets/js/lib/jquery.cookie.js', array('jquery', 'socialbet-mdnzr'), SOCIALBET_VERSION, true );
		wp_enqueue_script( 'socialbet-countdown', $this->theme_url . '/assets/js/lib/jquery.countdown.min.js', array('jquery', 'socialbet-mdnzr'), SOCIALBET_VERSION, true );
		wp_enqueue_script( 'socialbet-icheck', $this->theme_url . '/assets/js/lib/icheck.min.js', array('jquery', 'socialbet-mdnzr'), SOCIALBET_VERSION, true );
		wp_enqueue_script( 'socialbet-form', $this->theme_url . '/assets/js/lib/jquery.form.min.js', array('jquery', 'socialbet-mdnzr'), SOCIALBET_VERSION, true );
		wp_enqueue_script( 'socialbet-select', $this->theme_url . '/assets/js/lib/select.js', array('jquery', 'socialbet-mdnzr'), SOCIALBET_VERSION, true );
		wp_enqueue_script( 'socialbet-select2', $this->theme_url . '/assets/js/lib/select2.min.js', array('jquery', 'socialbet-mdnzr'), SOCIALBET_VERSION, true );
		wp_enqueue_script( 'socialbet-user', $this->theme_url . '/assets/js/common/user.js', array('jquery', 'socialbet-mdnzr'), SOCIALBET_VERSION, true );

		wp_localize_script('socialbet-user', 'socbet',
            array( 
            	'ajax_url' => admin_url( 'admin-ajax.php' ),
            	'add_poll' => socbet_first_poll_creation(),
            	'add_poll_field' => sobcet_poll_add_option_field(),
            	'preloader'	=> get_template_directory_uri() . '/assets/images/ajaxload.gif',
            	'messages' => array(
            		'unsupported_browser' => esc_html__('Пожалуйста, обновите ваш браузер, потому что ваш текущий браузер не хватает некоторых новых функций нам нужны!', 'socialbet'),
            		'file_too_big' => esc_html__('Этот файл слишком велик. Максимальный размер загрузки является 500 кб', 'socialbet'),
            		'unsupported_file_type' => esc_html__('Не поддерживается тип файла!', 'socialbet'),
            		'onprocess' => esc_html__('Пожалуйста, подождите, мы по-прежнему загрузки вашего изображения', 'socialbet'),
            		'upload_error' => esc_html__('К сожалению, не можем обработать ваш запрос сейчас. Пожалуйста, повторите попытку позже', 'socialbet')
            		)
            )
		);
		
		/** css file(s) */
		wp_enqueue_style( 'socialbet-main', $this->theme_url .'/assets/css/main.css', false, SOCIALBET_VERSION );
		wp_enqueue_style( 'socialbet-helpers', $this->theme_url .'/assets/css/helpers.css', array('socialbet-main'), SOCIALBET_VERSION );

		if ( is_socbet_user_page() ) {
			wp_enqueue_style( 'socialbet-dashboard', $this->theme_url .'/assets/css/dashboard.css', array('socialbet-main'), SOCIALBET_VERSION );
		}
	
	}


	/**
	 * Set Up theme defaults and registers the various WordPress features that this theme supports.
	 *
	 * @since version 1.0
	 * @access public
	 * @return void
	 */
	public function theme_setup() {
		# Available for translation.
		load_theme_textdomain( 'socialbet', get_template_directory() . '/langs' );
		add_theme_support( 'html5', array('search-form', 'comment-form', 'comment-list') );
		add_theme_support( 'automatic-feed-links' );

		register_nav_menus( 
			array(
				'top'	 => __('Top Menu', 'socialbet'),
				'left'	 => __('Left Menu', 'socialbet'),
			) 
		);

		add_theme_support( 'post-thumbnails', array('post', 'competition') );

		add_image_size( 'user_profile', 175, 175, true );

		//disable admin bar
		add_filter( 'show_admin_bar', '__return_false' );

		/** create new capabilities for admin */
		$this->push_new_capabilities();

	}

	/**
	 * New capablities settings for admin
	 *
	 * @since version 1.0
	 * @access private
	 * @return array
	 */
	private function admin_capabilities_settings() {
		$capabilities = array(
			"edit_event",
			"read_event",
			"delete_event",
			"edit_events",
			"edit_others_events",
			"publish_events",
			"read_private_events",
			"delete_events",
			"delete_private_events",
			"delete_published_events",
			"delete_others_events",
			"edit_private_events",
			"edit_published_events",
			"edit_competition",
			"read_competition",
			"delete_competition",
			"edit_competitions",
			"edit_others_competitions",
			"publish_competitions",
			"read_private_competitions",
			"delete_competitions",
			"delete_private_competitions",
			"delete_published_competitions",
			"delete_others_competitions",
			"edit_private_competitions",
			"edit_published_competitions",
			"edit_timeline",
			"read_timeline",
			"delete_timeline",
			"edit_timelines",
			"edit_others_timelines",
			"publish_timelines",
			"read_private_timelines",
			"delete_timelines",
			"delete_private_timelines",
			"delete_published_timelines",
			"delete_others_timelines",
			"edit_private_timelines",
			"edit_published_timelines",
			"edit_grouppost",
			"read_grouppost",
			"delete_grouppost",
			"edit_groupposts",
			"edit_others_groupposts",
			"publish_groupposts",
			"read_private_groupposts",
			"delete_groupposts",
			"delete_private_groupposts",
			"delete_published_groupposts",
			"delete_others_groupposts",
			"edit_private_groupposts",
			"edit_published_groupposts",
			"manage_event_terms",
			"edit_event_terms",
			"delete_event_terms",
			"assign_event_terms",
			"manage_grouppost_terms",
			"edit_grouppost_terms",
			"delete_grouppost_terms",
			"assign_grouppost_terms"
		);

		return $capabilities;
	}


	public function member_statuses(){

		// only read for now
		$capabilities = array(
			"edit_timeline",
			"read_timeline",
			"edit_timelines",
			"publish_timelines",
			"edit_published_timelines",
			"edit_grouppost",
			"read_grouppost",
			"edit_groupposts",
			"publish_groupposts",
			"edit_published_groupposts",
			"manage_grouppost_terms",
			"edit_grouppost_terms",
			"delete_grouppost_terms",
			"assign_grouppost_terms"
		);

		return $capabilities;
	}
	/**
	 * add more capabilities to admin
	 *
	 * @return void
	 */
	public function push_new_capabilities() {
		global $wp_roles;

		if ( class_exists('WP_Roles') )
			if ( ! isset( $wp_roles ) )
				$wp_roles = new WP_Roles();

		if ( is_object( $wp_roles ) ) {

			add_role( 'member', __( 'Member', 'socialbet' ), array(
			    'read' 						=> true,
			    'edit_posts' 				=> false,
			    'delete_posts' 				=> false
			));

			$admin_cap = $this->admin_capabilities_settings();
			$member_cap = $this->member_statuses();

			foreach( $member_cap as $mcap ) {
				$wp_roles->add_cap( 'member', $mcap );
			}
			unset( $mcap );

			foreach( $admin_cap as $acap ) {
				$wp_roles->add_cap( 'administrator', $acap );
			}
			unset( $acap );
			$wp_roles->add_cap( 'administrator', 'manage_socialbet' );
		}

	}

	/**
	 * remove event capabilities from admin
	 *
	 * @return void
	 */
	public function remove_event_capabilities() {
		global $wp_roles;

		if ( class_exists('WP_Roles') )
			if ( ! isset( $wp_roles ) )
				$wp_roles = new WP_Roles();

		if ( is_object( $wp_roles ) ) {
			$admin_cap = $this->admin_capabilities_settings();

			foreach( $admin_cap as $acap ) {
				$wp_roles->remove_cap( 'administrator', $acap );
			}
			unset( $acap );
			$wp_roles->remove_cap( 'administrator', 'manage_socialbet' );
		}
	}

	/**
	 * Helper for site speed
	 *
	 * @return void
	 */
	public function installBoost() {
		if ( is_admin() && !get_option('socialbet_optimation_installed') ) {
			$home_path = get_home_path();
			$htaccess_file = $home_path.'.htaccess';

			if ( ( !file_exists($htaccess_file) && is_writable($home_path) ) || is_writable($htaccess_file) ) {
				$optimation = explode( "\n", socbet_admin_speed_boost() );
				update_option( 'socialbet_optimation_installed', 'true' );
				return insert_with_markers( $htaccess_file, 'SocialbetOptimation', $optimation );
			}
		}
	}

	/**
	 * Reset the optimation in .htaccess file
	 *
	 * @return void
	 */
	public function roleback_datas() {
		if ( is_admin() ) {
			$home_path = get_home_path();
			$htaccess_file = $home_path.'.htaccess';

			if ( !file_exists($htaccess_file) ) {
				delete_option('socialbet_optimation_installed');
				return true;
			}

			if ( is_writable($htaccess_file) ) {
				delete_option('socialbet_optimation_installed');
				insert_with_markers( $htaccess_file, 'SocialbetOptimation', '' );
			}

		}

		$this->remove_event_capabilities();
	}

	/**
	 * echoing the error/message if any
	 *
	 * @access public
	 * @return string
	 */
	public function print_messages( $wp_error = '' ) {
		global $error;

		if ( empty($wp_error) )
			$wp_error = new WP_Error();
	
		if ( !empty( $error ) ) {
			$wp_error->add('error', $error);
			unset($error);
		}

		if ( !empty($wp_error) ) {
			if ( $wp_error->get_error_code() ) {
				$errors = '';
				$messages = '';
				
				foreach( $wp_error->get_error_codes() as $code ) {
					$severity = $wp_error->get_error_data($code);
					
					foreach( $wp_error->get_error_messages($code) as $error ) {
						
						if ( 'message' == $severity )
							$messages .= '	' . $error . "<br />\n";
						else
							$errors .= '<li>' . $error . '</li>' . "\n";		
					}
					
				}
				
				if ( !empty($errors) )
					echo '<ul class="socbet-alert alert-danger">' . apply_filters('notice_errors', $errors) . "</ul>\n";
				
				if ( !empty($messages) )
					echo '<div class="socbet-alert alert-success">' . apply_filters('notice_messages', $messages) . "</div>\n";
			
			}
		}
	}


	public function inner_unique_post_slug( $slug, $post_ID, $post_status, $post_type ) {
        if ( in_array( $post_status, array( 'draft', 'pending', 'auto-draft' ) ) || ( 'inherit' == $post_status && 'revision' == $post_type ) )
        	return $slug;

		//$lang_code = socbet_get_language_code();
		$lang_code = 'ru';
		
		//error_log('slug is '. $slug );
		
		$check_slug = explode('-', $slug);
		$suffix = '';
		if ( isset($check_slug[1]) ) {

			$number = intval( $check_slug[0] );
			if( $number )
				$suffix = '-'.$check_slug[0];
		}

		$string = urldecode( $slug );
		$transliteration_slug = _transliteration_process( esc_html($string), '?', $lang_code );
		$slug = $transliteration_slug.$suffix;
		
		//error_log('slug after filter is '. $slug );
		
		return $slug;
	}


	public function inner_sanitize_title( $title, $raw_title, $context ) {

		//$lang_code = socbet_get_language_code();
		$lang_code = 'ru';
		$title = urldecode( $title );
		$transliteration_title = _transliteration_process( esc_html($title), '?', $lang_code );

		return $transliteration_title;
	}

}
/** end class SocBetTheme */

$GLOBALS['SocBet_Theme'] = new SocBet_Theme();

}
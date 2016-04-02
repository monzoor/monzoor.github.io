<?php
/**
 * Main class
 *
 */

if ( ! defined('ABSPATH') )
	exit;

if ( ! class_exists('Socbet_Soon') ) {

class Socbet_Soon {
	public $mailer;

	private $login_php;

	private $login_slug = 'login';

	public function __construct() {
		$this->file_includes();

		// create a table to store the emails data
		add_filter( 'wp_loaded', array($this, 'install') );
		add_action( 'wp_loaded', array($this, 'wp_loaded') );

		add_action( 'init', array($this,'init') );
		add_action( 'init', array($this, 'init_loaded') );

		add_filter( 'site_url', array($this, 'site_url'), 10, 4 );
		add_filter( 'network_site_url', array($this, 'network_site_url'), 10, 3 );
		add_filter( 'wp_redirect', array($this, 'wp_redirect'), 10, 2 );
		remove_action( 'template_redirect', 'wp_redirect_admin_locations', 1000 );

		add_action( 'after_setup_theme', array($this,'theme_setup') );
	}

	public function init() {
		$this->mailer = new Socbet_Mailer();

		if ( ! is_admin() ) {
			add_action( 'get_header', array($this,'check_is_phone'), 1 );
			add_action( 'wp_enqueue_scripts', array($this,'load_frontend_assets') );
			add_filter( 'body_class', array($this,'body_classes') );
		}

        add_action( 'wp_ajax_socbet_mailinglist_callback', array(&$this,'ajax_save_email_callback') );
        add_action( 'wp_ajax_nopriv_socbet_mailinglist_callback', array(&$this,'ajax_save_email_callback') );

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

			$this->render_comingsoon_page();
			
			die;
		}

	}

	private function file_includes() {
		require_once( get_template_directory() .'/inc/class-socbet-mailer.php' );

		if ( is_admin() )
			require_once( get_template_directory() .'/inc/admin/class-socbet-admin.php' );
	}


	public function theme_setup() {
		load_theme_textdomain( 'socialbet', get_template_directory() . '/langs' );
	}

	public function body_classes( $classes ) {
		global $sobet_theme_is_phone;

		if ( $sobet_theme_is_phone ) {
			$classes[] = 'ismobile';
		}

		return $classes;
	}


	public function render_comingsoon_page() {
		global $wpdb;

		// login page, keep them a live
        //if ( preg_match("/login/i",$_SERVER['REQUEST_URI']) > 0 ) {
            //return false;
        //}

		if ( is_feed() )
			return;

		if ( isset($_GET['process']) && $_GET['process'] == 'request-invite' ) {
			if ( ! empty( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) == 'xmlhttprequest' ) {
				$this->ajax_save_email_callback();
			}
		}

		if ( empty( $_GET['confirm'] ) ) {
			if ( ! empty( $_GET['subscribed'] ) ) {
				$file = get_template_directory() .'/templates/thankyou.php';
				//$activation_complete = false;
			} else {
				$file = get_template_directory() .'/templates/coming-soon.php';
			}

			include( $file );
			exit;
		}

		$confirm_code = $_GET['confirm'];

		$db_id = isset( $_GET['id'] ) ? intval( $_GET['id'] ) : false;
		if ( ! $db_id ) {
			wp_redirect( esc_url( wp_registration_url() ) );
			exit;
		}


		$tablename = $wpdb->prefix . "socbet_subscribes";
		$db_id = esc_sql($db_id);
		$confirm_code = esc_sql($confirm_code);
		$sql = $wpdb->get_row("SELECT * FROM $tablename WHERE email_activation_key='{$confirm_code}' AND id='{$db_id}'");

		if ( is_null( $sql ) ) {
			wp_redirect( esc_url( wp_registration_url() ) );
			exit;
		}

		$wpdb->update(
			$tablename,
			array(
				'email_activation_key' => '',
				'email_status' => '1'
			),
			array( 'ID' => esc_sql( $sql->id ) ),
			array( '%s', '%d' ),
			array( '%d' )
		);

		wp_redirect( add_query_arg('subscribed','1', esc_url( wp_registration_url() ) ) );
		exit;
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

	/**
	 * print js and css files
	 *
	 * @return void
	 */
	public function load_frontend_assets() {
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'socialbet-vkontakte', 'http://vk.com/js/api/share.js?90', array('jquery'), SBSOON_VERSION, false );
		wp_enqueue_script( 'socialbet-libary', get_template_directory_uri() . '/assets/js/library.js', array('jquery'), SBSOON_VERSION, true );
		wp_enqueue_script( 'socialbet-helper', get_template_directory_uri() . '/assets/js/global.js', array('jquery', 'socialbet-libary'), SBSOON_VERSION, true );
		wp_localize_script( 'socialbet-helper', 'socbet',
            array( 
            	'main_bg' => get_template_directory_uri() . '/assets/images/main-bg.jpg',
            	'bg_width' => '1366',
            	'bg_height' => '768',
            	'ajax_url' => admin_url( 'admin-ajax.php' ),
            	'email_required' => __('Пожалуйста, введите Ваш e-mail', 'socialbet'),
            	'email_invalid' => __('Пожалуйста, введите Ваш действующий e-mail!', 'socialbet'),
            	'email_duplicated' => __('К сожалению, этот email уже используется, пожалуйста, введите другой e-mail!', 'socialbet'),
            	'fatal' => __('К сожалению, мы не можем обработать Ваш запрос, пожалуйста, попробуйте еще раз чуть позже.', 'socialbet')
            )
		);

		wp_enqueue_style( 'socialbet-main', get_template_directory_uri() .'/assets/css/main.css', false, SBSOON_VERSION );
	}


	public function ajax_save_email_callback() {
		global $wpdb;

		if ( empty( $_POST['_wpnonce'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], 'socbet-user-subscribes' ) ) {
			header('HTTP/1.1 403 Forbidden',true,403);
			exit;
		}

		if ( ! isset( $_POST['subscribe_email'] ) )
			die( '300' );

		$email = sanitize_email( $_POST['subscribe_email'] );
		if ( ! is_email( $email ) )
			die('400');

		$select_result = $wpdb->get_var( $wpdb->prepare(
			"SELECT `email` FROM {$wpdb->prefix}socbet_subscribes WHERE email = %s",
			$email
		) );

		if ( $select_result == $email )
			die( '150' );

		$newkey = wp_generate_password( 20, false );

		$values = array(
			'email' => esc_sql( $email ),
			'email_activation_key' => $newkey,
			'registered' => date( 'Y-m-d H:i:s' ),
		);
		$format_values = array( '%s', '%s', '%s' );

		$insert_result = $wpdb->insert(
			"{$wpdb->prefix}socbet_subscribes",
			$values,
			$format_values
		);

		if ( false == $insert_result )
			die( '250' );

		// sucess save the email
		// lets sent an email and ask the user to verify the email
		$link_to_verify = add_query_arg( array('confirm'=>$newkey, 'id'=>$wpdb->insert_id), esc_url( wp_registration_url() ) );
		$this->mailer->sent_subscribtion_verify( $email, $link_to_verify );

		die('200');
	}


	/**
	 * Check the devices
	 * @return void
	 */
	function check_is_phone() {
		global $sobet_theme_is_phone;

		$useragent = $_SERVER['HTTP_USER_AGENT'];

		$sobet_theme_is_phone = false;

		if ( preg_match( '/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent ) || 
			preg_match( '/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr( $useragent,0,4 ) )
			) {

			$sobet_theme_is_phone = true;
		}

		return true;
	}

	/** 
	 * Database install on activation
	 *
	 * @return void
	 */
	public function install() {
		if ( get_option('sobet_soon_installed') == 'yes' )
			return false;

		require_once( get_template_directory() .'/inc/install.php' );
		socbet_soon_install_db();
	}

}

$GLOBAL['socbet_soon'] = new Socbet_Soon;

}


add_filter( 'wp_title', 'socbet_filtered_wp_title',  10, 2 );

function socbet_filtered_wp_title( $title, $sep ) {
	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );

	$title = "$title $sep $site_description";

	return $title;
}
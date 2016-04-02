<?php
/**
 * WordPress User Page
 *
 * @package WordPress
 */
global $error, $interim_login, $action, $user_login;

// Redirect to https login if forced to use SSL
if ( force_ssl_admin() && ! is_ssl() ) {
	if ( 0 === strpos($_SERVER['REQUEST_URI'], 'http') ) {
		wp_redirect( set_url_scheme( $_SERVER['REQUEST_URI'], 'https' ) );
		exit();
	} else {
		wp_redirect( 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] );
		exit();
	}
}

/**
 * Output the login page header.
 *
 * @param string   $title    Optional. WordPress Log In Page title to display in <title> element. Default 'Log In'.
 * @param string   $message  Optional. Message to display in header. Default empty.
 * @param WP_Error $wp_error Optional. The error to pass. Default empty.
 */
function login_header( $title = 'Log In', $message = '', $wp_error = '' ) {
	global $error, $interim_login, $action;

	// Don't index any of these forms
	add_action( 'login_head', 'wp_no_robots' );

	if ( wp_is_mobile() )
		add_action( 'login_head', 'wp_login_viewport_meta' );

	if ( empty($wp_error) )
		$wp_error = new WP_Error();

	// Shake it!
	$shake_error_codes = array( 'empty_password', 'empty_email', 'invalid_email', 'invalidcombo', 'empty_username', 'invalid_username', 'incorrect_password', 'empty_firstname', 'empty_lastname', 'password_missmatch', 'error' );
	
	/**
	 * Filter the error codes array for shaking the login form.
	 *
	 * @since 3.0.0
	 *
	 * @param array $shake_error_codes Error codes that shake the login form.
	 */
	$shake_error_codes = apply_filters( 'shake_error_codes', $shake_error_codes );

	if ( $shake_error_codes && $wp_error->get_error_code() && in_array( $wp_error->get_error_code(), $shake_error_codes ) )
		add_action( 'login_head', 'wp_shake_js', 12 );

	?><!DOCTYPE html>
	<!--[if IE 8]>
		<html xmlns="http://www.w3.org/1999/xhtml" class="ie8" <?php language_attributes(); ?>>
	<![endif]-->
	<!--[if !(IE 8) ]><!-->
		<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
	<!--<![endif]-->
	<head>
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<title><?php bloginfo('name'); ?> &rsaquo; <?php echo $title; ?></title>
	<?php

	//wp_admin_css( 'login', true );

	/*
	 * Remove all stored post data on logging out.
	 * This could be added by add_action('login_head'...) like wp_shake_js(),
	 * but maybe better if it's not removable by plugins
	 */
	if ( 'loggedout' == $wp_error->get_error_code() ) {
		?>
		<script>if("sessionStorage" in window){try{for(var key in sessionStorage){if(key.indexOf("wp-autosave-")!=-1){sessionStorage.removeItem(key)}}}catch(e){}};</script>
		<?php
	}

	wp_head();

	/**
	 * Enqueue scripts and styles for the login page.
	 *
	 * @since 3.1.0
	 */
	do_action( 'login_enqueue_scripts' );
	/**
	 * Fires in the login page header after scripts are enqueued.
	 *
	 * @since 2.1.0
	 */
	do_action( 'login_head' );

	if ( is_multisite() ) {
		$login_header_url   = network_home_url();
		$login_header_title = get_current_site()->site_name;
	} else {
		$login_header_url   = get_template_directory_uri() . '/assets/images/logo.jpg';
		$login_header_title = __( 'Powered by WordPress' );
	}

	/**
	 * Filter link URL of the header logo above login form.
	 *
	 * @since 2.1.0
	 *
	 * @param string $login_header_url Login header logo URL.
	 */
	$login_header_url = apply_filters( 'login_headerurl', $login_header_url );
	/**
	 * Filter the title attribute of the header logo above login form.
	 *
	 * @since 2.1.0
	 *
	 * @param string $login_header_title Login header logo title attribute.
	 */
	$login_header_title = apply_filters( 'login_headertitle', $login_header_title );

	$classes = array( 'login-action-' . $action, 'wp-core-ui' );
	if ( wp_is_mobile() )
		$classes[] = 'mobile';
	if ( is_rtl() )
		$classes[] = 'rtl';
	if ( $interim_login ) {
		$classes[] = 'interim-login';
		?>
		<style type="text/css">html{background-color: transparent;}</style>
		<?php

		if ( 'success' ===  $interim_login )
			$classes[] = 'interim-login-success';
	}
	$classes[] =' locale-' . sanitize_html_class( strtolower( str_replace( '_', '-', get_locale() ) ) );

	/**
	 * Filter the login page body classes.
	 *
	 * @since 3.5.0
	 *
	 * @param array  $classes An array of body classes.
	 * @param string $action  The action that brought the visitor to the login page.
	 */
	$classes = apply_filters( 'login_body_class', $classes, $action );

	?>
	</head>
	<body class="socbet-login <?php echo esc_attr( implode( ' ', $classes ) ); ?>">

	<div class="content-wrapper">

	<?php 
	/** call the left sidebar */
	get_template_part( 'layouts/left', 'sidebar' );
	?>

	<div class="content-sub-wrapper">

		<div class="left-gutter only-mob-hide">&nbsp;</div>

	<?php
	/** cal the top container */
	get_template_part( 'layouts/top', 'container' );
	?>

	<div class="main-container">
		
		<div class="middle-container-wrapper-1col index">
		
		<div id="login" class="login">
		


	<?php

	unset( $login_header_url, $login_header_title );

	/**
	 * Filter the message to display above the login form.
	 *
	 * @since 2.1.0
	 *
	 * @param string $message Login message text.
	 */
	$message = apply_filters( 'login_message', $message );
	if ( !empty( $message ) )
		echo $message . "\n";

	// In case a plugin uses $error rather than the $wp_errors object
	if ( !empty( $error ) ) {
		$wp_error->add('error', $error);
		unset($error);
	}

	if ( $wp_error->get_error_code() ) {
		$errors = '';
		$messages = '';
		foreach ( $wp_error->get_error_codes() as $code ) {
			$severity = $wp_error->get_error_data( $code );
			foreach ( $wp_error->get_error_messages( $code ) as $error_message ) {
				if ( 'message' == $severity )
					$messages .= '	' . $error_message . "<br />\n";
				else
					$errors .= '	' . $error_message . "<br />\n";
			}
		}
		if ( ! empty( $errors ) ) {
			/**
			 * Filter the error messages displayed above the login form.
			 *
			 * @since 2.1.0
			 *
			 * @param string $errors Login error message.
			 */
			echo '<div id="login_error">' . apply_filters( 'login_errors', $errors ) . "</div>\n";
		}
		if ( ! empty( $messages ) ) {
			/**
			 * Filter instructional messages displayed above the login form.
			 *
			 * @since 2.5.0
			 *
			 * @param string $messages Login messages.
			 */
			echo '<p class="message">' . apply_filters( 'login_messages', $messages ) . "</p>\n";
		}
	}
} // End of login_header()

/**
 * Outputs the footer for the login page.
 *
 * @param string $input_id Which input to auto-focus
 */
function login_footer($input_id = '') {
	global $interim_login;
	?>

		</div>
		
		</div>

	</div>

<?php
if ( !is_user_logged_in() ) {
	get_template_part( 'layouts/modal', 'register' );
}
?>

			<!-- search popup -->
			<div class="md-modal md-effect-1" id="modal-1">
				<div class="md-content">
					<div class="search-popup">
						<span class="icon-close close-abs md-close"></span>
						<p><?php esc_html_e('Поиск по сайту', 'socialbet'); ?></p>
						<form method="get" class="from" action="<?php echo home_url('/'); ?>">
							<input type="text" placeholder="<?php esc_attr_e('Введите любое слово', 'socialbet'); ?>">
							<button type="submit" class="fill-balance"><?php esc_html_e('искать', 'socialbet'); ?></button>
						</form>
					</div>
				</div>
			</div>

			<div class="md-overlay"></div><!-- the overlay element -->
		

		</div><!-- .content-sub-wrapper -->

		<div class="overlay"></div><!-- the overlay element -->

	</div><!-- .content-wrapper -->

	<?php if ( !empty($input_id) ) : ?>
	<script type="text/javascript">
	try{document.getElementById('<?php echo $input_id; ?>').focus();}catch(e){}
	if(typeof wpOnload=='function')wpOnload();
	</script>
	<?php endif; ?>

	<?php
	/**
	 * Fires in the login page footer.
	 *
	 * @since 3.1.0
	 */
	do_action( 'login_footer' ); ?>
	<div class="clear"></div>

	</body>
	</html>
	<?php
	exit();
}

function wp_shake_js() {
	if ( wp_is_mobile() )
		return;
?>
<script type="text/javascript">
addLoadEvent = function(func){if(typeof jQuery!="undefined")jQuery(document).ready(func);else if(typeof wpOnload!='function'){wpOnload=func;}else{var oldonload=wpOnload;wpOnload=function(){oldonload();func();}}};
function s(id,pos){g('#login').left=pos+'px';}
function g(id){return document.getElementById('login').style;}
function shake(id,a,d){c=a.shift();s(id,c);if(a.length>0){setTimeout(function(){shake(id,a,d);},d);}else{try{g(id).position='static';wp_attempt_focus();}catch(e){}}}
addLoadEvent(function(){ var p=new Array(15,30,15,0,-15,-30,-15,0);p=p.concat(p.concat(p));var i=document.forms[0].id;g(i).position='relative';shake(i,p,20);});
</script>
<?php
}

function wp_login_viewport_meta() {
	?>
	<meta name="viewport" content="width=device-width" />
	<?php
}

/**
 * Handles sending password retrieval email to user.
 *
 * @uses $wpdb WordPress Database object
 *
 * @return bool|WP_Error True: when finish. WP_Error on error
 */
function retrieve_password() {
	global $wpdb, $wp_hasher, $SocBet_Theme;

	$errors = new WP_Error();

	if ( empty( $_POST['user_login'] ) ) {
		$errors->add('empty_username', __('<strong>ERROR</strong>: Enter a username or e-mail address.'));
	} else if ( strpos( $_POST['user_login'], '@' ) ) {
		$user_data = get_user_by( 'email', trim( $_POST['user_login'] ) );
		if ( empty( $user_data ) )
			$errors->add('invalid_email', __('<strong>ERROR</strong>: There is no user registered with that email address.'));
	} else {
		$login = trim($_POST['user_login']);
		$user_data = get_user_by('login', $login);
	}

	/**
	 * Fires before errors are returned from a password reset request.
	 *
	 * @since 2.1.0
	 */
	do_action( 'lostpassword_post' );

	if ( $errors->get_error_code() )
		return $errors;

	if ( !$user_data ) {
		$errors->add('invalidcombo', __('<strong>ERROR</strong>: Invalid username or e-mail.'));
		return $errors;
	}

	// Redefining user_login ensures we return the right case in the email.
	$user_login = $user_data->user_login;
	$user_email = $user_data->user_email;

	/**
	 * Fires before a new password is retrieved.
	 *
	 * @since 1.5.0
	 * @deprecated 1.5.1 Misspelled. Use 'retrieve_password' hook instead.
	 *
	 * @param string $user_login The user login name.
	 */
	do_action( 'retreive_password', $user_login );

	/**
	 * Fires before a new password is retrieved.
	 *
	 * @since 1.5.1
	 *
	 * @param string $user_login The user login name.
	 */
	do_action( 'retrieve_password', $user_login );

	/**
	 * Filter whether to allow a password to be reset.
	 *
	 * @since 2.7.0
	 *
	 * @param bool true           Whether to allow the password to be reset. Default true.
	 * @param int  $user_data->ID The ID of the user attempting to reset a password.
	 */
	$allow = apply_filters( 'allow_password_reset', true, $user_data->ID );

	if ( ! $allow )
		return new WP_Error('no_password_reset', __('Password reset is not allowed for this user'));
	else if ( is_wp_error($allow) )
		return $allow;

	// Generate something random for a password reset key.
	$key = wp_generate_password( 20, false );

	/**
	 * Fires when a password reset key is generated.
	 *
	 * @since 2.5.0
	 *
	 * @param string $user_login The username for the user.
	 * @param string $key        The generated password reset key.
	 */
	do_action( 'retrieve_password_key', $user_login, $key );

	// Now insert the key, hashed, into the DB.
	if ( empty( $wp_hasher ) ) {
		require_once ABSPATH . WPINC . '/class-phpass.php';
		$wp_hasher = new PasswordHash( 8, true );
	}
	$hashed = $wp_hasher->HashPassword( $key );
	$wpdb->update( $wpdb->users, array( 'user_activation_key' => $hashed ), array( 'user_login' => $user_login ) );

	$message = __('Someone requested that the password be reset for the following account:') . "\r\n\r\n";
	$message .= network_home_url( '/' ) . "\r\n\r\n";
	$message .= sprintf(__('Username: %s'), $user_login) . "\r\n\r\n";
	$message .= __('If this was a mistake, just ignore this email and nothing will happen.') . "\r\n\r\n";
	$message .= __('To reset your password, visit the following address:') . "\r\n\r\n";
	$message .= '<' . network_site_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user_login), 'login') . ">\r\n";

	if ( is_multisite() )
		$blogname = $GLOBALS['current_site']->site_name;
	else
		/*
		 * The blogname option is escaped with esc_html on the way into the database
		 * in sanitize_option we want to reverse this for the plain text arena of emails.
		 */
		$blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);

	$title = sprintf( __('[%s] Password Reset'), $blogname );

	/**
	 * Filter the subject of the password reset email.
	 *
	 * @since 2.8.0
	 *
	 * @param string $title Default email title.
	 */
	$title = apply_filters( 'retrieve_password_title', $title );
	/**
	 * Filter the message body of the password reset mail.
	 *
	 * @since 2.8.0
	 *
	 * @param string $message Default mail message.
	 * @param string $key     The activation key.
	 */
	$message = apply_filters( 'retrieve_password_message', $message, $key );

	$mailer = $SocBet_Theme->mailer();
	$mailer->password_reset_email( $message, wp_specialchars_decode( $title ), $user_email );

	return true;
}

/**
 * Check the verify link (after registration process)
 * @return void
 */
function socbet_check_confirmation_emailkey( $key, $login ) {
	global $wpdb, $wp_hasher;

	$key = preg_replace('/[^a-z0-9]/i', '', $key);

	if ( empty( $key ) || !is_string( $key ) )
		return new WP_Error('invalid_key', __('Invalid key'));

	if ( empty($login) || !is_string($login) )
		return new WP_Error('invalid_key', __('Invalid key'));

	$row = $wpdb->get_row( $wpdb->prepare( "SELECT ID, user_activation_key FROM $wpdb->users WHERE user_login = %s AND user_status = '2'", $login ) );	

	if ( ! $row )
		return new WP_Error('invalid_key', __('Invalid key'));

	if ( empty( $wp_hasher ) ) {
		require_once ABSPATH . WPINC . '/class-phpass.php';
		$wp_hasher = new PasswordHash( 8, true );
	}

	if ( $wp_hasher->CheckPassword( $key, $row->user_activation_key ) )
		return get_userdata( $row->ID );


	return new WP_Error( 'invalid_key', __( 'Invalid key' ) );
}


function socbet_verified_this_user( $user ) {
	global $wpdb;

	$make_verified = $wpdb->update( $wpdb->users, array( 'user_status' => '0', 'user_activation_key' => '' ), array( 'ID' => $user->ID ) );

	$redirect_to = 'wp-login.php?signup=complete';
	wp_safe_redirect( $redirect_to );
	exit();
}


function is_valid_invitation( $key, $email ) {
	global $wpdb, $wp_hasher;

	$table = $wpdb->prefix . 'socbet_invitation';

	$key = preg_replace('/[^a-z0-9]/i', '', $key);

	if ( empty( $key ) || !is_string( $key ) )
		return false;

	$row = $wpdb->get_row( $wpdb->prepare( "SELECT ID, invitation_key FROM $table WHERE email = %s AND status = '0'", sanitize_email($email) ) );

	if ( !$row )
		return false;

	if ( empty( $wp_hasher ) ) {
		require_once ABSPATH . WPINC . '/class-phpass.php';
		$wp_hasher = new PasswordHash( 8, true );
	}

	if ( $wp_hasher->CheckPassword( $key, $row->invitation_key ) ) {
		return true;
	}

	return false;
}

function ivitation_email_is_processed( $email ) {
	global $wpdb;

	$table = $wpdb->prefix . 'socbet_invitation';
	$make_verified = $wpdb->update( $table, array( 'status' => '1', 'invitation_key' => '' ), array( 'email' => sanitize_email($email) ) );

	return true;
}

//
// Main
//

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'login';
$errors = new WP_Error();

if ( isset($_GET['key']) )
	$action = 'resetpass';

// validate action so as to default to the login screen
if ( !in_array( $action, array( 'postpass', 'logout', 'lostpassword', 'retrievepassword', 'resetpass', 'rp', 'register', 'invitation', 'login', 'emailconfirmation' ), true ) && false === has_filter( 'login_form_' . $action ) )
	$action = 'login';

nocache_headers();

header('Content-Type: '.get_bloginfo('html_type').'; charset='.get_bloginfo('charset'));

if ( defined( 'RELOCATE' ) && RELOCATE ) { // Move flag is set
	if ( isset( $_SERVER['PATH_INFO'] ) && ($_SERVER['PATH_INFO'] != $_SERVER['PHP_SELF']) )
		$_SERVER['PHP_SELF'] = str_replace( $_SERVER['PATH_INFO'], '', $_SERVER['PHP_SELF'] );

	$url = dirname( set_url_scheme( 'http://' .  $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] ) );
	if ( $url != get_option( 'siteurl' ) )
		update_option( 'siteurl', $url );
}

//Set a cookie now to see if they are supported by the browser.
$secure = ( 'https' === parse_url( site_url(), PHP_URL_SCHEME ) && 'https' === parse_url( home_url(), PHP_URL_SCHEME ) );
setcookie( TEST_COOKIE, 'WP Cookie check', 0, COOKIEPATH, COOKIE_DOMAIN, $secure );
if ( SITECOOKIEPATH != COOKIEPATH )
	setcookie( TEST_COOKIE, 'WP Cookie check', 0, SITECOOKIEPATH, COOKIE_DOMAIN, $secure );

/**
 * Fires when the login form is initialized.
 *
 * @since 3.2.0
 */
do_action( 'login_init' );
/**
 * Fires before a specified login form action.
 *
 * The dynamic portion of the hook name, $action, refers to the action
 * that brought the visitor to the login form. Actions include 'postpass',
 * 'logout', 'lostpassword', etc.
 *
 * @since 2.8.0
 */
do_action( 'login_form_' . $action );

$http_post = ('POST' == $_SERVER['REQUEST_METHOD']);
$interim_login = isset($_REQUEST['interim-login']);

switch ($action) {

case 'postpass' :
	require_once ABSPATH . WPINC . '/class-phpass.php';
	$hasher = new PasswordHash( 8, true );

	/**
	 * Filter the life span of the post password cookie.
	 *
	 * By default, the cookie expires 10 days from creation. To turn this
	 * into a session cookie, return 0.
	 *
	 * @since 3.7.0
	 *
	 * @param int $expires The expiry time, as passed to setcookie().
	 */
	$expire = apply_filters( 'post_password_expires', time() + 10 * DAY_IN_SECONDS );
	$secure = ( 'https' === parse_url( home_url(), PHP_URL_SCHEME ) );
	setcookie( 'wp-postpass_' . COOKIEHASH, $hasher->HashPassword( wp_unslash( $_POST['post_password'] ) ), $expire, COOKIEPATH, COOKIE_DOMAIN, $secure );

	wp_safe_redirect( wp_get_referer() );
	exit();

case 'logout' :

	check_admin_referer('log-out');
	wp_logout();

	$redirect_to = !empty( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : 'wp-login.php?loggedout=true';
	wp_safe_redirect( $redirect_to );
	exit();

case 'emailconfirmation':
	
	$user = socbet_check_confirmation_emailkey( $_GET['emailkey'], $_GET['login'] );

	if ( is_wp_error($user) ) {
		if ( is_user_logged_in() ) {
			
			$redirect_to = home_url('/');
			wp_redirect( $redirect_to );
			exit();

		} else {
			
			wp_redirect( 'wp-login.php?error=invalidemailkey' );
			exit();
			
		}
	}

	socbet_verified_this_user( $user );

	exit();

case 'lostpassword' :
case 'retrievepassword' :

	if ( $http_post ) {

		if ( empty( $_POST['_wpnonce'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], 'socbet-user-lostpass' ) ) {
			wp_die( __('Security check failed!', 'socialbet') );
		}

		$errors = retrieve_password();
		if ( !is_wp_error($errors) ) {
			$redirect_to = !empty( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : 'wp-login.php?checkemail=confirm';
			wp_safe_redirect( $redirect_to );
			exit();
		}
	}

	if ( isset( $_GET['error'] ) ) {
		if ( 'invalidkey' == $_GET['error'] )
			$errors->add( 'invalidkey', __( 'Sorry, that key does not appear to be valid.' ) );
		elseif ( 'expiredkey' == $_GET['error'] )
			$errors->add( 'expiredkey', __( 'Sorry, that key has expired. Please try again.' ) );
	}

	$lostpassword_redirect = ! empty( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : '';
	/**
	 * Filter the URL redirected to after submitting the lostpassword/retrievepassword form.
	 *
	 * @since 3.0.0
	 *
	 * @param string $lostpassword_redirect The redirect destination URL.
	 */
	$redirect_to = apply_filters( 'lostpassword_redirect', $lostpassword_redirect );

	/**
	 * Fires before the lost password form.
	 *
	 * @since 1.5.1
	 */
	do_action( 'lost_password' );

	login_header(__('Lost Password'), '<p class="message">' . __('Please enter your username or email address. You will receive a link to create a new password via email.') . '</p>', $errors);

	$user_login = isset($_POST['user_login']) ? wp_unslash($_POST['user_login']) : '';

?>

<div class="log-reg-wrapper">
	<div class="form-body light-gray-bg md-content">
		<form name="lostpasswordform" id="lostpasswordform" action="<?php echo esc_url( network_site_url( 'wp-login.php?action=lostpassword', 'login_post' ) ); ?>" method="post">
			<?php wp_nonce_field( 'socbet-user-lostpass', '_wpnonce', true, true ); ?>
			<div class="form form-box">

				<div class="col-wop">
					<input type="text" name="user_login" id="user_login" value="<?php echo esc_attr($user_login); ?>" />
					<div class="form-icon"><span class="icon-userlogin"></span></div>
				</div>
				<?php
				/**
				 * Fires inside the lostpassword <form> tags, before the hidden fields.
				 *
				 * @since 2.1.0
				 */
				do_action( 'lostpassword_form' ); ?>
				<input type="hidden" name="redirect_to" value="<?php echo esc_attr( $redirect_to ); ?>" />
				<button type="submit" name="wp-submit" id="wp-submit" class="fill-balance md-top"><?php esc_html_e('Получить новый пароль', 'socialbet'); ?></button>
			</div>
		</form>
	</div>
</div>

<?php
login_footer('user_login');
break;

case 'resetpass' :
case 'rp' :
	list( $rp_path ) = explode( '?', wp_unslash( $_SERVER['REQUEST_URI'] ) );
	$rp_cookie = 'wp-resetpass-' . COOKIEHASH;

	if ( $http_post && ( empty( $_POST['_wpnonce'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], 'socbet-user-resetpass' ) ) ) {
		wp_die( __('Security check failed!', 'socialbet') );
	}

	if ( isset( $_GET['key'] ) ) {
		$value = sprintf( '%s:%s', wp_unslash( $_GET['login'] ), wp_unslash( $_GET['key'] ) );
		setcookie( $rp_cookie, $value, 0, $rp_path, COOKIE_DOMAIN, is_ssl(), true );
		wp_safe_redirect( remove_query_arg( array( 'key', 'login' ) ) );
		exit;
	}

	if ( isset( $_COOKIE[ $rp_cookie ] ) && 0 < strpos( $_COOKIE[ $rp_cookie ], ':' ) ) {
		list( $rp_login, $rp_key ) = explode( ':', wp_unslash( $_COOKIE[ $rp_cookie ] ), 2 );
		$user = check_password_reset_key( $rp_key, $rp_login );
	} else {
		$user = false;
	}

	if ( ! $user || is_wp_error( $user ) ) {
		setcookie( $rp_cookie, ' ', time() - YEAR_IN_SECONDS, $rp_path, COOKIE_DOMAIN, is_ssl(), true );
		if ( $user && $user->get_error_code() === 'expired_key' )
			wp_redirect( site_url( 'wp-login.php?action=lostpassword&error=expiredkey' ) );
		else
			wp_redirect( site_url( 'wp-login.php?action=lostpassword&error=invalidkey' ) );
		exit;
	}

	$errors = new WP_Error();

	if ( isset($_POST['pass1']) && $_POST['pass1'] != $_POST['pass2'] )
		$errors->add( 'password_reset_mismatch', __( 'The passwords do not match.' ) );

	/**
	 * Fires before the password reset procedure is validated.
	 *
	 * @since 3.5.0
	 *
	 * @param object           $errors WP Error object.
	 * @param WP_User|WP_Error $user   WP_User object if the login and reset key match. WP_Error object otherwise.
	 */
	do_action( 'validate_password_reset', $errors, $user );

	if ( ( ! $errors->get_error_code() ) && isset( $_POST['pass1'] ) && !empty( $_POST['pass1'] ) ) {
		reset_password($user, $_POST['pass1']);
		setcookie( $rp_cookie, ' ', time() - YEAR_IN_SECONDS, $rp_path, COOKIE_DOMAIN, is_ssl(), true );
		login_header( __( 'Password Reset' ), '<p class="message reset-pass">' . __( 'Your password has been reset.' ) . ' <a href="' . esc_url( wp_login_url() ) . '">' . __( 'Log in' ) . '</a></p>' );
		login_footer();
		exit;
	}

	wp_enqueue_script('utils');
	wp_enqueue_script('user-profile');

	login_header(__('Reset Password'), '<p class="message reset-pass">' . __('Enter your new password below.') . '</p>', $errors );

?>
<div class="log-reg-wrapper">
	<div class="form-body light-gray-bg md-content">
		<form name="resetpassform" id="resetpassform" action="<?php echo esc_url( network_site_url( 'wp-login.php?action=resetpass', 'login_post' ) ); ?>" method="post" autocomplete="off">
			<?php wp_nonce_field( 'socbet-user-resetpass', '_wpnonce', true, true ); ?>
			<input type="hidden" id="user_login" value="<?php echo esc_attr( $rp_login ); ?>" autocomplete="off" />
			<div class="form form-box">

				<div class="col-wop">
					<input type="password" name="pass1" id="pass1" value="" autocomplete="off" />
					<div class="form-icon"><span class="icon-password"></span></div>
				</div>

				<div class="col-wop">
					<input type="password" name="pass2" id="pass2" value="" autocomplete="off" />
					<div class="form-icon"><span class="icon-password"></span></div>
				</div>

				<div class="col-wop">
					<div class="border"></div>
				</div>

				<div id="pass-strength-result" class="hide-if-no-js"><?php _e('Strength indicator'); ?></div>
				
				<div class="col-wop pd-top pd-bottom">
					<p class="brand-blue"><?php esc_html_e('Подсказка: Пароль должен содержать не менее семи символов. Чтобы сделать его сильнее, использовать верхний и нижний регистр букв, цифр и символов, как ! " ? $ % ^ &amp; ).', 'socialbet'); ?></p>
				</div>

				<?php
				/**
				 * Fires following the 'Strength indicator' meter in the user password reset form.
				 *
				 * @since 3.9.0
				 *
				 * @param WP_User $user User object of the user whose password is being reset.
				 */
				do_action( 'resetpass_form', $user );
				?>
				<button type="submit" name="wp-submit" id="wp-submit" class="fill-balance md-top"><?php esc_html_e('Сброс пароля', 'socialbet'); ?></button>
			</div>
		</form>
	</div>
</div>

<?php
login_footer('user_pass');
break;

case 'register' :
case 'invitation' :
	if ( is_multisite() ) {
		/**
		 * Filter the Multisite sign up URL.
		 *
		 * @since 3.0.0
		 *
		 * @param string $sign_up_url The sign up URL.
		 */
		wp_redirect( apply_filters( 'wp_signup_location', network_site_url( 'wp-signup.php' ) ) );
		exit;
	}

	if ( !get_option('users_can_register') ) {
		wp_redirect( site_url('wp-login.php?registration=disabled') );
		exit();
	}

	$invitation = false;

	if ( $action == 'invitation' ) {
		$invitation = true;
	}

	if ( $invitation && !$http_post && ( !isset($_GET['invitekey']) || !isset($_GET['invite_email']) || !is_valid_invitation( $_GET['invitekey'], $_GET['invite_email'] ) ) ) {
		wp_redirect( site_url('wp-login.php?invitation=invalid') );
		exit();
	}

	$form_url = esc_url( site_url('wp-login.php?action=register', 'login_post') );
	if ( $invitation ) {
		$array_qry = array(
			'action' => 'invitation',
			'invitekey' => $_GET['invitekey'],
			'invite_email' => sanitize_email($_GET['invite_email'])
			);
		$form_url = esc_url( add_query_arg( $array_qry, site_url('wp-login.php', 'login_post') ) );
	}

	$reg_username = '';
	$reg_firstname = '';
	$reg_lastname = '';
	$reg_email = ($invitation) ? $_GET['invite_email'] : '';
	if ( $http_post ) {

		if ( empty( $_POST['_wpnonce'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], 'socbet-user-register' ) ) {
			wp_die( __('Security check failed!', 'socialbet') );
		}

		$errors = new WP_Error();
		$reg_errors = false;

		$reg_username = $_POST['reg_username'];
		$reg_email = ($invitation) ? $_GET['invite_email'] : $_POST['reg_email'];
		$reg_firstname = $_POST['reg_firstname'];
		$reg_lastname = $_POST['reg_lastname'];
		// new user no need to be hashed, will automatically hashed by WordPress
		$reg_pass = $_POST['reg_pwd'];
		$reg_pass_match = $_POST['reg_pwdc'];

		if ( empty($reg_username) ){
			$errors->add( 'empty_username', esc_html__('Пожалуйста, введите имя пользователя!', 'socialbet') );
			$reg_errors = true;
		}

		if ( empty($reg_email) ){
			$errors->add( 'empty_email', esc_html__('Пожалуйста, введите адрес электронной почты!', 'socialbet') );
			$reg_errors = true;
		}

		if( ! is_email( sanitize_email($reg_email) ) ) {
			$errors->add( 'empty_email', esc_html__('Пожалуйста, введите верный адрес!', 'socialbet') );
			$reg_errors = true;
		}

		if ( empty($reg_firstname) ){
			$errors->add( 'empty_firstname', esc_html__('Пожалуйста, введите ваше имя!', 'socialbet') );
			$reg_errors = true;
		}

		if ( empty($reg_lastname) ){
			$errors->add( 'empty_lastname', esc_html__('Пожалуйста, введите свои фамилию!', 'socialbet') );
			$reg_errors = true;
		}

		if( empty($reg_pass) ) {
			$errors->add( 'empty_password', esc_html__('Пожалуйста, введите пароль для учетной записи!', 'socialbet') );
			$reg_errors = true;
		}

		if ( isset($_POST['reg_pwd']) && $_POST['reg_pwd'] != $_POST['reg_pwdc'] ) {
			$errors->add( 'password_missmatch', esc_html__( 'Пароли не совпадают.', 'socialbet' ) );
			$reg_errors = true;
		}

		if ( !empty($reg_username) && username_exists( sanitize_user($reg_username) ) ) {
			$errors->add( 'empty_username', esc_html__('Имя пользователя уже существует!', 'socialbet') );
			$reg_errors = true;
		}

		if ( !empty($reg_email) && email_exists( sanitize_email($reg_email) ) ) {
			$errors->add( 'empty_email', esc_html__('E-mail уже существует!', 'socialbet') );
			$reg_errors = true;
		}

		if ( !$reg_errors ) {

			$new_user_args = array(
				'user_pass' => $reg_pass,
				'user_login' => sanitize_user($reg_username),
				'user_email' => sanitize_email($reg_email),
				'first_name' => $reg_firstname,
				'last_name' => $reg_lastname
			);

			$user = wp_insert_user( $new_user_args );

			if ( !is_wp_error($user) ) {
				global $SocBet_Theme, $wpdb, $wp_hasher;

				if ( $invitation ) {
					ivitation_email_is_processed( sanitize_email($reg_email) );

					$wpdb->update( $wpdb->users, array( 'user_status' => '0', 'user_activation_key' => '' ), array( 'ID' => $user ) );

					$redirect_to = 'wp-login.php?signup=complete';
					wp_safe_redirect( $redirect_to );
					exit();

				} else {
					$key = wp_generate_password( 20, false );
					if ( empty( $wp_hasher ) ) {
						require_once ABSPATH . WPINC . '/class-phpass.php';
						$wp_hasher = new PasswordHash( 8, true );
					}
					$hashed = $wp_hasher->HashPassword( $key );

					// set user status = 2, and fill the activation key field
					$wpdb->update( $wpdb->users, array( 'user_status' => '2', 'user_activation_key' => $hashed ), array( 'ID' => $user ) );

					$mailer = $SocBet_Theme->mailer();
					$emailBody = 'Привет {firstname},' . "\n\n" . 'Добро пожаловать в SocialBet.' . "\n" . 'Чтобы активировать свой аккаунт и подтвердить свой адрес электронной почты, пожалуйста, нажмите на ссылку: ' . "\n\n" . '{confirmation_link}' . "\n\n" . 'После того, как ваша регистрация будет завершена, вы можете войти в свой приборной панели!' . "\n\n" . 'С уважением';

					$mailer->new_member_email( $emailBody, $reg_firstname, $key, sanitize_user($reg_username), sanitize_email($reg_email) );

					$redirect_to = 'wp-login.php?signup=accesskey';
					wp_safe_redirect( $redirect_to );
					exit();			
				}


			}
		}
	}

	$registration_redirect = ! empty( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : '';
	/**
	 * Filter the registration redirect URL.
	 *
	 * @since 3.0.0
	 *
	 * @param string $registration_redirect The redirect destination URL.
	 */
	$redirect_to = apply_filters( 'registration_redirect', $registration_redirect );
	login_header(__('Registration Form'), '<p class="message register">' . esc_html__('Зарегистрироваться на этом сайте', 'socialbet') . '</p>', $errors);
	$notifyme = ! empty( $_POST['reg_notify'] ) ? $_POST['reg_notify'] : 'yes';
?>
<div class="log-reg-wrapper">
	<div class="form-body light-gray-bg md-content">
		<form name="registerform" id="registerform" action="<?php echo $form_url; ?>" method="post" novalidate="novalidate">
			<?php wp_nonce_field( 'socbet-user-register', '_wpnonce', true, true ); ?>

			<div class="form form-box">
			
				<div class="col-wop">
					<p class="mg-bottom"><?php esc_html_e('Войти с помощью', 'socialbet'); ?></p>
					<div class="social-box">
				<?php
				/**
				 * Fires following the 'Password' field in the login form.
				 *
				 * @since 2.1.0
				 */
				do_action( 'register_form' );
				?>
					</div>
				</div>

				<div class="col-wop npd-top npd-bottom">
					<div class="border-box pos-rel">
						<div class="border"></div>
						<p class="light-gray-bg center"><?php esc_html_e('или', 'socialbet'); ?></p>
					</div>
				</div>

				<div class="col-wop">
					<input type="text" name="reg_username" id="reg_username" placeholder="<?php esc_attr_e('Имя пользователя', 'socialbet'); ?>" value="<?php echo esc_attr($reg_username); ?>" />
					<div class="form-icon"><span class="icon-userlogin"></span></div>
				</div>

				<div class="col-wop">
					<input type="text" name="reg_firstname" id="reg_firstname" placeholder="<?php esc_attr_e('Имя', 'socialbet'); ?>" value="<?php echo esc_attr($reg_firstname); ?>" />
					<div class="form-icon"><span class="icon-userlogin"></span></div>
				</div>

				<div class="col-wop">
					<input type="text" name="reg_lastname" id="reg_lastname" placeholder="<?php esc_attr_e('Фамилия', 'socialbet'); ?>" value="<?php echo esc_attr($reg_lastname); ?>" />
					<div class="form-icon"><span class="icon-userlogin"></span></div>
				</div>


				<div class="col-wop">
				<?php if ( $invitation ) { ?>
					<input type="email" name="reg_email" id="reg_email" placeholder="<?php esc_attr_e('Электронная почта', 'socialbet'); ?>" value="<?php echo esc_attr( sanitize_email($_GET['invite_email']) ); ?>" disabled="disabled" />
				<?php } else { ?>
					<input type="email" name="reg_email" id="reg_email" placeholder="<?php esc_attr_e('Электронная почта', 'socialbet'); ?>" value="<?php echo esc_attr($reg_email); ?>" />
				<?php } ?>
					<div class="form-icon"><span class="icon-email"></span></div>
				</div>

				<div class="col-wop">
					<input type="password" name="reg_pwd" id="reg_pwd" placeholder="<?php esc_attr_e('Пароль', 'socialbet'); ?>" value="" />
					<div class="form-icon"><span class="icon-password"></span></div>
				</div>

				<div class="col-wop">
					<input type="password" name="reg_pwdc" id="reg_pwdc" placeholder="<?php esc_attr_e('Подтвердите пароль', 'socialbet'); ?>" value=""/>
					<div class="form-icon"><span class="icon-password"></span></div>
				</div>

				<div class="col-wop mg-bottom">
					<input class="fl" type="checkbox" value="yes" name="reg_notify" <?php checked( $notifyme, 'yes' ); ?> />
					<p class="fl mg-top"><?php esc_html_e('Сообщать мне о новостях Socialbet', 'socialbet'); ?></p>
				</div>

				<div class="col-wop pd-bottom pd-top">
					<p class="fl"><?php esc_html_e('Регистрируясь, вы соглашаетесь с', 'socialbet'); ?> <a class="brand-blue" href=""><?php esc_html_e('Условиями предоставления услуг', 'socialbet'); ?></a>, <a class="brand-blue" href=""><?php esc_html_e('Политикой конфиденциальности', 'socialbet'); ?></a>, <a class="brand-blue" href=""><?php esc_html_e('Правилами компенсации', 'socialbet'); ?></a> Socialbet.</p>
				</div>

				<div class="col-wop">
					<input type="hidden" name="redirect_to" value="<?php echo esc_attr( $redirect_to ); ?>" />
					<button type="submit" name="wp-submit" id="wp-submit" class="fill-balance md-top"><?php esc_html_e('зарегистрироваться', 'socialbet'); ?></button>
				</div>

				<div class="col-wop">
					<div class="border"></div>
				</div>
				<div class="col-wp bottom-text">
					<span class="dark-gray mg-top display-blk"><?php esc_html_e('Вы уже зарегистрированы на Socialbet?', 'socialbet'); ?></span>
					<a href="<?php echo esc_url( wp_login_url() ); ?>" class="brand-red"><?php esc_html_e('Войти', 'socialbet'); ?></a>
				</div>
				
			</div>

		</form>
	</div>
</div>

<?php
login_footer('user_login');
break;

case 'login' :
default:
	$secure_cookie = '';
	$customize_login = isset( $_REQUEST['customize-login'] );


	if ( $http_post && ( empty( $_POST['_wpnonce'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], 'socbet-user-login' ) ) ) {
		wp_die( __('Security check failed!', 'socialbet') );
	}

	if ( $customize_login )
		wp_enqueue_script( 'customize-base' );

	// If the user wants ssl but the session is not ssl, force a secure cookie.
	if ( !empty($_POST['log']) && !force_ssl_admin() ) {
		$user_email = sanitize_email($_POST['log']);
		if ( $user = get_user_by('email', $user_email) ) {
			if ( get_user_option('use_ssl', $user->ID) ) {
				$secure_cookie = true;
				force_ssl_admin(true);
			}
		}
	}

	if ( isset( $_REQUEST['redirect_to'] ) ) {
		$redirect_to = $_REQUEST['redirect_to'];
		// Redirect to https if user wants ssl
		if ( $secure_cookie && false !== strpos($redirect_to, 'wp-admin') )
			$redirect_to = preg_replace('|^http://|', 'https://', $redirect_to);
	} else {
		$redirect_to = admin_url();
	}

	$reauth = empty($_REQUEST['reauth']) ? false : true;

	// get user login by email
	$ulog = "";
	if ( !empty($_POST['log']) ) {
		$user_email = sanitize_email($_POST['log']);
		if ( $user = get_user_by('email', $user_email) ) {
			$ulog = $user->user_login;
		}
	}
	$creds = array();
	$creds['user_login'] = $ulog;
	$creds['user_password'] = isset( $_POST['pwd'] ) ? $_POST['pwd'] : '';
	$creds['remember'] = isset( $_POST['rememberme'] ) ? $_POST['rememberme'] : '';
	if ( isset($_POST['log']) && empty($ulog) ) {
		$user = new WP_Error( 'invalid_email', __('<strong>ERROR</strong>: There is no user registered with that email address.', 'socialbet') ); 
	} else {
		$user = wp_signon( $creds, $secure_cookie );
		if ( !is_wp_error($user) && $user->user_status == '2' ) {
			wp_logout();
			wp_redirect( 'wp-login.php?error=unverifieduser' );
			exit();	
		}
	}

	if ( empty( $_COOKIE[ LOGGED_IN_COOKIE ] ) ) {
		if ( headers_sent() ) {
			$user = new WP_Error( 'test_cookie', sprintf( __( '<strong>ERROR</strong>: Cookies are blocked due to unexpected output. For help, please see <a href="%1$s">this documentation</a> or try the <a href="%2$s">support forums</a>.' ),
				__( 'http://codex.wordpress.org/Cookies' ), __( 'https://wordpress.org/support/' ) ) );
		} elseif ( isset( $_POST['testcookie'] ) && empty( $_COOKIE[ TEST_COOKIE ] ) ) {
			// If cookies are disabled we can't log in even with a valid user+pass
			$user = new WP_Error( 'test_cookie', sprintf( __( '<strong>ERROR</strong>: Cookies are blocked or not supported by your browser. You must <a href="%s">enable cookies</a> to use WordPress.' ),
				__( 'http://codex.wordpress.org/Cookies' ) ) );
		}
	}

	$requested_redirect_to = isset( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : '';
	/**
	 * Filter the login redirect URL.
	 *
	 * @since 3.0.0
	 *
	 * @param string           $redirect_to           The redirect destination URL.
	 * @param string           $requested_redirect_to The requested redirect destination URL passed as a parameter.
	 * @param WP_User|WP_Error $user                  WP_User object if login was successful, WP_Error object otherwise.
	 */
	$redirect_to = apply_filters( 'login_redirect', $redirect_to, $requested_redirect_to, $user );

	if ( !is_wp_error($user) && !$reauth ) {
		if ( $interim_login ) {
			$message = '<p class="message">' . __('You have logged in successfully.') . '</p>';
			$interim_login = 'success';
			login_header( '', $message ); ?>
			</div>
			<?php
			/** This action is documented in wp-login.php */
			do_action( 'login_footer' ); ?>
			<?php if ( $customize_login ) : ?>
				<script type="text/javascript">setTimeout( function(){ new wp.customize.Messenger({ url: '<?php echo wp_customize_url(); ?>', channel: 'login' }).send('login') }, 1000 );</script>
			<?php endif; ?>
			</body></html>
<?php		exit;
		}

		if ( ( empty( $redirect_to ) || $redirect_to == 'wp-admin/' || $redirect_to == admin_url() ) ) {
			// If the user doesn't belong to a blog, send them to user admin. If the user can't edit posts, send them to their profile.
			if ( is_multisite() && !get_active_blog_for_user($user->ID) && !is_super_admin( $user->ID ) )
				$redirect_to = user_admin_url();
			elseif ( is_multisite() && !$user->has_cap('read') )
				$redirect_to = get_dashboard_url( $user->ID );
			elseif ( !$user->has_cap('edit_posts') )
				$redirect_to = admin_url('profile.php');
		}
		wp_safe_redirect($redirect_to);
		exit();
	}

	$errors = $user;
	// Clear errors if loggedout is set.
	if ( !empty($_GET['loggedout']) || $reauth )
		$errors = new WP_Error();

	if ( $interim_login ) {
		if ( ! $errors->get_error_code() )
			$errors->add('expired', __('Session expired. Please log in again. You will not move away from this page.'), 'message');
	} else {
		// Some parts of this script use the main login form to display a message
		if		( isset($_GET['loggedout']) && true == $_GET['loggedout'] )
			$errors->add('loggedout', __('You are now logged out.'), 'message');
		elseif	( isset($_GET['registration']) && 'disabled' == $_GET['registration'] )
			$errors->add('registerdisabled', __('User registration is currently not allowed.'));
		elseif	( isset($_GET['checkemail']) && 'confirm' == $_GET['checkemail'] )
			$errors->add('confirm', __('Check your e-mail for the confirmation link.'), 'message');
		elseif	( isset($_GET['checkemail']) && 'newpass' == $_GET['checkemail'] )
			$errors->add('newpass', __('Check your e-mail for your new password.'), 'message');
		elseif	( isset($_GET['checkemail']) && 'registered' == $_GET['checkemail'] )
			$errors->add('registered', __('Registration complete. Please check your e-mail.'), 'message');
		elseif ( strpos( $redirect_to, 'about.php?updated' ) )
			$errors->add('updated', __( '<strong>You have successfully updated WordPress!</strong> Please log back in to see what&#8217;s new.' ), 'message' );
		elseif	( isset($_GET['signup']) && 'accesskey' == $_GET['signup'] )
			$errors->add('signupwaitkey', esc_html__('Пожалуйста, проверьте свою электронную почту для подтверждения связи. Не получили письмо? Вы, возможно, потребуется проверить нежелательной / спам по электронной почте папку', 'socialbet'), 'message');	
		elseif	( isset($_GET['signup']) && 'complete' == $_GET['signup'] )
			$errors->add('signupsucess', esc_html__('Регистрация завершена. Пожалуйста, войдите', 'socialbet'), 'message');		
		elseif	( isset($_GET['error']) && 'invalidemailkeyloggedin' == $_GET['error'] )
			$errors->add('emailkeyerror', esc_html__('К сожалению, что ключ не является допустимым. Пожалуйста, проверьте свою электронную почту для нового ссылку для подтверждения', 'socialbet'));	
		elseif	( isset($_GET['error']) && 'invalidemailkey' == $_GET['error'] )
			$errors->add('emailkeyerror', esc_html__('К сожалению, что ключ не является допустимым', 'socialbet'));
		elseif	( isset($_GET['error']) && 'invalidnewemailkey' == $_GET['error'] )
			$errors->add('emailkeyerror', esc_html__('К сожалению, что ключ не является допустимым', 'socialbet'));	
		elseif	( isset($_GET['error']) && 'unverifieduser' == $_GET['error'] )
			$errors->add('unverifieduser', esc_html__('Пожалуйста, подтвердите свой адрес электронной почты перед логин', 'socialbet') );
		elseif	( isset($_GET['error']) && 'banned' == $_GET['error'] )
			$errors->add('banned_user', esc_html__('Вы были запрещены!', 'socialbet'));
		elseif	( isset($_GET['invitation']) && 'invalid' == $_GET['invitation'] )
			$errors->add('invitation_invalid', esc_html__('Неверный приглашение!', 'socialbet'));
	}

	/**
	 * Filter the login page errors.
	 *
	 * @since 3.6.0
	 *
	 * @param object $errors      WP Error object.
	 * @param string $redirect_to Redirect destination URL.
	 */
	$errors = apply_filters( 'wp_login_errors', $errors, $redirect_to );

	// Clear any stale cookies.
	if ( $reauth )
		wp_clear_auth_cookie();

	login_header(__('Log In'), '', $errors);

	if ( isset($_POST['log']) )
		$user_login = ( 'incorrect_password' == $errors->get_error_code() || 'empty_password' == $errors->get_error_code() ) ? esc_attr(wp_unslash($_POST['log'])) : '';
	$rememberme = ! empty( $_POST['rememberme'] );
?>
<div class="log-reg-wrapper">
<div class="form-body light-gray-bg md-content">
<form name="loginform" id="loginform" action="<?php echo esc_url( site_url( 'wp-login.php', 'login_post' ) ); ?>" method="post">
	<?php wp_nonce_field( 'socbet-user-login', '_wpnonce', true, true ); ?>

	<div class="form form-box">
	
		<div class="col-wop">
			<p class="mg-bottom"><?php esc_html_e('Войти с помощью', 'socialbet'); ?></p>
			<div class="social-box">
		<?php
		/**
		 * Fires following the 'Password' field in the login form.
		 *
		 * @since 2.1.0
		 */
		do_action( 'login_form' );
		?>
			</div>
		</div>

		<div class="col-wop npd-top npd-bottom">
			<div class="border-box pos-rel">
				<div class="border"></div>
				<p class="light-gray-bg center"><?php esc_html_e('или', 'socialbet'); ?></p>
			</div>
		</div>

		<div class="col-wop pos-rel">
			<input type="email" name="log" id="user_login" value="<?php echo esc_attr($user_login); ?>" placeholder="<?php esc_attr_e('почта', 'socialbet'); ?>"/>
			<div class="form-icon"><span class="icon-email"></span></div>
		</div>

		<div class="col-wop">
			<input type="password" name="pwd" id="user_pass" value="" placeholder="<?php esc_attr_e('Пароль', 'socialbet'); ?>"/>
			<div class="form-icon"><span class="icon-password"></span></div>
		</div>

		<div class="col-wop mg-bottom">
			<input class="fl" type="checkbox" name="rememberme" id="rememberme" value="forever" <?php checked( $rememberme ); ?> />
			<p class="fl mg-top"><?php esc_html_e('Запомнить меня', 'socialbet'); ?></p>
			<a class="fr brand-red mg-top" href="<?php echo esc_url( wp_lostpassword_url( site_url('wp-login.php') ) ); ?>"><?php esc_html_e('Забыли пароль?', 'socialbet'); ?></a>
		</div>

		<div class="col-wop">
			<button type="submit" name="wp-submit" id="wp-submit" class="fill-balance md-top"><?php esc_html_e('войти', 'socialbet'); ?></button>
	<?php	if ( $interim_login ) { ?>
			<input type="hidden" name="interim-login" value="1" />
	<?php	} else { ?>
			<input type="hidden" name="redirect_to" value="<?php echo esc_attr($redirect_to); ?>" />
	<?php 	} ?>
	<?php   if ( $customize_login ) : ?>
			<input type="hidden" name="customize-login" value="1" />
	<?php   endif; ?>
			<input type="hidden" name="testcookie" value="1" />
		</div>

		<div class="col-wp npd-top npd-bottom">
			<div class="border"></div>
		</div>
		<div class="col-wp bottom-text">
			<span class="dark-gray mg-top display-blk"><?php esc_html_e('Пока не зарегистрированы на Socialbet?', 'socialbet'); ?></span>
			<?php printf( '<a href="%s" class="brand-red">%s</a>', esc_url( wp_registration_url() ), esc_html__( 'Зарегистрироваться', 'socialbet' ) ); ?>
		</div>
	</div>

</form>
</div>
</div>

<script type="text/javascript">
function wp_attempt_focus(){
setTimeout( function(){ try{
<?php if ( $user_login ) { ?>
d = document.getElementById('user_pass');
d.value = '';
<?php } else { ?>
d = document.getElementById('user_login');
<?php if ( 'invalid_username' == $errors->get_error_code() ) { ?>
if( d.value != '' )
d.value = '';
<?php
}
}?>
d.focus();
d.select();
} catch(e){}
}, 200);
}

<?php if ( !$error ) { ?>
wp_attempt_focus();
<?php } ?>
if(typeof wpOnload=='function')wpOnload();
<?php if ( $interim_login ) { ?>
(function(){
try {
	var i, links = document.getElementsByTagName('a');
	for ( i in links ) {
		if ( links[i].href )
			links[i].target = '_blank';
	}
} catch(e){}
}());
<?php } ?>
</script>

<?php
login_footer();
break;
} // end action switch

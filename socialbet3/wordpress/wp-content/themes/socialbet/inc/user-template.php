<?php
/**
 * Functions related to user
 *
 * @since version 1.0
 */


add_filter( 'login_redirect', 'socbet_login_redirect', 10, 3 );
function socbet_login_redirect( $redirect_to, $requested_redirect_to, $user ) {

	if ( !is_wp_error($user) && !$user->has_cap('manage_socialbet') ) {

		$redirect_to = get_author_posts_url( $user->ID );
	}

	return $redirect_to;
}


//add_action('get_header', 'socbet_user_unfiltered_html_inject', 0);
function socbet_user_unfiltered_html_inject(){
	global $wp_query, $wp_roles;

	if( is_user_logged_in() ){
		
		if ( class_exists('WP_Roles') )
			if ( ! isset( $wp_roles ) )
				$wp_roles = new WP_Roles();


		$user = wp_get_current_user();

		if( is_single() || is_socbet_user_page() ){
			
			if( ! current_user_can('edit_others_timelines') )
				$user->add_cap( 'unfiltered_html' );

		}
		else {

			if( ! current_user_can('edit_others_timelines') && current_user_can('unfiltered_html') ) 
				$user->remove_cap( 'unfiltered_html' );	
		}

		return true;

	}

}

/**
 * load the template
 *
 * @access public
 * @param mixed $template
 * @return string
 */
function socbet_output_template( $template ) {
	$file = '';

	// this is user profile page ?
	if ( is_socbet_user_page() ) {
		$file = 'user-profile.php';
	}

	if ( $file ) {
		$temp_template = locate_template( $file );
		if ( $temp_template ) {
			$template = $temp_template;
		}
	}
	
	return $template;
}

/**
 * Conditional function to check the current URL
 * is user URL not not
 *
 * @return bool
 */
function is_socbet_user_page() {
  global $wp_query;

  if ( isset( $wp_query->query_vars['user'] ) ) {
    return $wp_query->query_vars['user'];
  }

  return false;
}


function is_socbet_user_settings_page() {
  global $wp_query;

  if ( is_socbet_user_page() && isset( $wp_query->query_vars['user_page'] ) ) {
    return $wp_query->query_vars['user_page'];
  }

  return false;
}


/**
 * checking if the visitor is the owner 
 * of forum user profile page,
 *
 * @access public
 * @return bool
 */
function is_own_profile() {
	// process only if user is logged in
	if ( is_user_logged_in() ) {
		global $wp_query, $current_user;
		get_currentuserinfo();

		if ( is_socbet_user_page() &&  $current_user->user_nicename == $wp_query->query_vars['user'] ) 
			return true;

		return false;
	}

	return false;
}



function user_is_allowed_access( $page ) {

	if ( ! is_user_logged_in() )
		return false;

	$array_strict = array(
		_transliteration_process( esc_html( urldecode('мои-настройки') ), '?', 'ru' ),
		_transliteration_process( esc_html( urldecode('пригласить-друзей') ), '?', 'ru' ),
		_transliteration_process( esc_html( urldecode('мои-сообщения') ), '?', 'ru' ),
		_transliteration_process( esc_html( urldecode('мои-счет') ), '?', 'ru' )
		);

	if ( in_array( $page, $array_strict ) )
		return false;

	// need to process another pages later
	return true;
}


function current_user_is_follow( $userid ) {
	global $current_user;
	get_currentuserinfo();

	if ( ! is_user_logged_in() )
		return false;

	$following = get_user_meta( $current_user->ID, 'socbet_following_data', true );

	if ( ! is_array($following) )
		return false;

	if ( in_array( $userid, $following ) )
		return true;

	return false;
}


function current_user_is_blocked( $userid ) {
	global $current_user;
	get_currentuserinfo();

	if ( ! is_user_logged_in() )
		return false;

	$blocked = get_user_meta( $current_user->ID, 'socbet_blocked_users', true );

	if ( ! is_array($blocked) )
		return false;

	if ( array_key_exists( 'user'.$userid, $blocked ) ) {
		$bb = $blocked['user'.$userid];
		if ( isset( $blocked[ 'user'.$userid ]['status'] ) && $blocked[ 'user'.$userid ]['status'] == 'true' ) {
			return true;
		}
	}

	return false;
}


function user_is_blocked_by( $userid ) {
	global $current_user;
	get_currentuserinfo();

	if ( ! is_user_logged_in() )
		return false;

	$blocked = get_user_meta( $userid, 'socbet_blocked_users', true );

	if ( ! is_array($blocked) )
		return false;

	$userid = $current_user->ID;
	if ( array_key_exists( 'user'.$userid, $blocked ) ) {
		$bb = $blocked['user'.$userid];
		if ( isset( $blocked['user'.$userid]['status'] ) && $blocked['user'.$userid]['status'] == 'true' ) {
			return true;
		}
	}

	return false;
}


function user_change_block_status( $userid, $idtochange, $status = 'true' ) {
	
	if ( empty($userid) || empty($idtochange) )
		return false;

	$blocked = get_user_meta( $userid, 'socbet_blocked_users', true );

	if ( ! is_array($blocked) ) {
		$new_block = array(
			"user$idtochange" => array(
				'status' => $status,
				'date'	=> date('Y-m-d H:i:s')
				)
		);
	} else {

		if ( array_key_exists( "user$idtochange", $blocked ) ) {
			$blocked["user$idtochange"] = array(
				'status' => $status,
				'date'	=> date('Y-m-d H:i:s')
				);

			$new_block = $blocked;
		} else {
			$add_block = array(
				"user$idtochange" => array(
					'status' => $status,
					'date'	=> date('Y-m-d H:i:s')
					)
			);
			$new_block = (array) $add_block + $blocked;	
		}
		
	}

	update_user_meta( $userid, 'socbet_blocked_users', $new_block, get_user_meta( $userid, 'socbet_blocked_users', true ) );
	return false;
}


function get_socbet_user_dashboard_url( $id, $path = 'my-settings' ) {
	global $wp_rewrite;

	//get the nice_name
	$nice_name = get_the_author_meta( 'user_nicename', $id );
	$link = $wp_rewrite->get_extra_permastruct('user');

	if ( ! empty($link) ) {
		$link = str_replace('%user%', $nice_name, $link);
		$link = home_url($link);
		$link = user_trailingslashit( trailingslashit( $link . "/{$path}/"), 'user' );
	} else {
		$link = home_url( "?user={$nice_name}&user_page={$path}" );
	}

	return apply_filters( "get_socbet_user_dashboard_{$path}_url", $link, $id );
}


function get_socbet_user_url( $id ) {
	global $wp_rewrite;

	//get the nice_name
	$nice_name = get_the_author_meta( 'user_nicename', $id );
	$link = $wp_rewrite->get_extra_permastruct('user');

	if ( ! empty($link) ) {
		$link = str_replace('%user%', $nice_name, $link);
		$link = home_url($link);
		$link = user_trailingslashit( trailingslashit( $link ), 'user' );
	} else {
		$link = home_url( "?user={$nice_name}" );
	}

	return apply_filters( "get_socbet_user_url", $link, $id );
}


function socbet_loggedin_profile_url() {
	if ( ! is_user_logged_in() )
		return false;

	global $wp_query, $current_user;
	get_currentuserinfo();

	echo esc_url( get_socbet_user_url( $current_user->ID ) );
}


function socbet_get_user_age( $user_id ) {

	$data = get_socbet_usermeta( $user_id );

	if ( empty( $data['user_birthday'] ) ) {
		return __('0 лет', 'socialbet');
	} else {
		$bdate = new DateTime( date('Y-m-d H:i:s', strtotime( $data['user_birthday'].' 00:00:00' ) ) );
		$now = new DateTime(date('Y-m-d H:i:s'));

		$interval = date_diff($now, $bdate);

		return sprintf(__('%s лет', 'socialbet'), $interval->format( '%Y' ));
	}
}


/**
 * to check if user is competition participant or not
 *
 * @return bool
 */
function user_is_participant( $competition_id ) {
	global $post, $current_user;
	get_currentuserinfo();

	if ( ! is_user_logged_in() )
		return false;

	$competition_users = get_post_meta( $competition_id, '_'.SOCIALBET_NAME.'_competition_participants', true );

	if ( empty( $competition_users ) )
		return false;

	if ( ! in_array( $current_user->ID, $competition_users ) )
		return false;

	return true;
}



function user_is_voted_on_poll( $postid ) {
	global $current_user;
	get_currentuserinfo();

	if ( ! is_user_logged_in() )
		return false;

	$voted = get_user_meta( $current_user->ID, 'socbet_poll_'.$postid, true );

	if ( $voted )
		return true;

	return false;
}


function count_unread_messages( $msg_id = "", $total = false ) {
	global $wpdb, $current_user;
	get_currentuserinfo();

	$mes_table = $wpdb->prefix . 'socbet_messages';
	$reply_table = $wpdb->prefix . 'socbet_message_replies';

	if ( $msg_id ) {
		$count = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM $reply_table WHERE message_id = %d AND status = %d AND user_id <> %d", $msg_id, 1,  $current_user->ID ) );
	} else {
		$count = 0;
		if ( $total ) {
			$rep = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM $reply_table WHERE status = %d AND user_id <> %d", 1,  $current_user->ID ) );
			$mes = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM $mes_table WHERE status = %d AND user_id_to = %d", 1,  $current_user->ID ) );

			$count = (int) $rep + (int) $mes;
		}
	}

	return $count;

}


function user_is_member_of( $groupid = "" ) {
	global $current_user;
	get_currentuserinfo();

	if ( empty($groupid) )
		return false;

	if ( !is_user_logged_in() )
		return false;

	$groups = get_user_meta( $current_user->ID, 'group_joined', true );
	if ( is_array($groups) && in_array($groupid, $groups) )
		return true;

	return false;
}


add_action( 'wp_ajax_socbet_add_new_group', 'ajax_socbet_add_new_group' );
add_action( 'wp_ajax_nopriv_socbet_add_new_group', 'ajax_socbet_add_new_group' );
function ajax_socbet_add_new_group() {
	global $current_user;
	get_currentuserinfo();

	if ( ! is_user_logged_in() ) {
		$ret = array(
			'err' => 'yes',
			'redirect' => 'yes',
			'url'	=> wp_login_url()
			);
		echo json_encode($ret);
		die();
	}

	if ( empty( $_POST['_socbetnewgroupnonce'] ) || ! wp_verify_nonce( $_POST['_socbetnewgroupnonce'], 'socbet-new-group' ) ) {
		$ret = array(
			'err' => 'yes',
			'redirect' => 'yes',
			'url'	=> home_url('/')
			);
		//error_log('Error on security');
		echo json_encode($ret);
		die();
	}

	if ( empty($_POST['group-name-creation']) ) {
		$ret = array(
			'err' => 'yes'
			);
		echo json_encode($ret);
		die();
	}

	$tax_name = $_POST['group-name-creation'];
	$tax_theme = $_POST['group-theme'];
	$tax_desc = $_POST['group-description-creation'];

	$creation = wp_insert_term( $tax_name, 'group_name', array( 'description'=>stripslashes($tax_desc) ) );

	if ( ! is_wp_error( $creation ) ) {
		$term_id = $creation['term_id'];
		
		$term_meta = array(
			'theme' => $tax_theme,
			'subscriber' => array($current_user->ID),
			'admin'	=> array($current_user->ID)
			);
		update_option( 'taxonomy_meta_'.$term_id, $term_meta );

		$theme_tax_meta = get_option( 'taxonomy_meta_'.$tax_theme );
		if( is_array($theme_tax_meta) ) {
			if( isset( $theme_tax_meta['terms'] ) && is_array( $theme_tax_meta['terms'] )  ) {
				$curTerms = $theme_tax_meta['terms'];
				$theme_tax_meta['terms'] = array_merge( array($tax_theme), $curTerms );
			} else {
				$theme_tax_meta['terms'] = array($tax_theme);
			}

			update_option( 'taxonomy_meta_'.$tax_theme, $theme_tax_meta );
		}
		
		$group_admin = get_user_meta( $current_user->ID, 'group_admin', true );
		$groups = get_user_meta( $current_user->ID, 'group_joined', true );

		if ( ! is_array($group_admin) ) {
			$new_ga = array($term_id);
		} else {
			$new_ga = array_merge( array($term_id), $group_admin );
		}
		update_user_meta( $current_user->ID, 'group_admin', $new_ga, get_user_meta( $current_user->ID, 'group_admin', true ) );

		if ( ! is_array($groups) ) {
			$new_gr = array($term_id);
		} else {
			$new_gr = array_merge( array($term_id), $groups );
		}
		update_user_meta( $current_user->ID, 'group_joined', $new_gr, get_user_meta( $current_user->ID, 'group_joined', true ) );

	}

	if ( empty($_POST['group-name-creation']) ) {
		$ret = array(
			'err' => 'yes'
			);
		echo json_encode($ret);
		die();
	}
}


add_action( 'wp_ajax_socbet_block_user_action', 'ajax_socbet_block_user' );
add_action( 'wp_ajax_nopriv_socbet_block_user_action', 'ajax_socbet_block_user' );
function ajax_socbet_block_user() {
	global $current_user;
	get_currentuserinfo();

	if ( ! is_user_logged_in() ) {
		$ret = array(
			'err' => 'yes',
			'redirect' => 'yes',
			'url'	=> wp_login_url()
			);
		echo json_encode($ret);
		die();
	}

	if ( empty( $_POST['_socbetblockusernonce'] ) || ! wp_verify_nonce( $_POST['_socbetblockusernonce'], 'socbet-block-user' ) ) {
		$ret = array(
			'err' => 'yes',
			'redirect' => 'yes',
			'url'	=> home_url('/')
			);
		//error_log('Error on security');
		echo json_encode($ret);
		die();
	}

	if ( empty( $_POST['user_id_to_block'] ) ) {
		$ret = array(
			'err' => 'yes'
			);
		echo json_encode($ret);
		die();
	}

	$user_to_block = intval($_POST['user_id_to_block']);

	if ( current_user_is_blocked($user_to_block) ) {
		$ret = array(
			'err' => false
			);
		echo json_encode($ret);
		die();
	}

	$blocked = get_user_meta( $current_user->ID, 'socbet_blocked_users', true );

	if ( ! is_array($blocked) ) {
		$new_block = array(
			"user$user_to_block" => array(
				'status' => 'true',
				'date'	=> date('Y-m-d H:i:s')
				)
		);
	} else {

		if ( array_key_exists( "user$user_to_block", $blocked ) ) {
			$blocked["user$user_to_block"] = array(
				'status' => 'true',
				'date'	=> date('Y-m-d H:i:s')
				);

			$new_block = $blocked;
		} else {
			$add_block = array(
				"user$user_to_block" => array(
					'status' => 'true',
					'date'	=> date('Y-m-d H:i:s')
					)
			);
			$new_block = (array) $add_block + $blocked;	
		}
		
	}

	update_user_meta( $current_user->ID, 'socbet_blocked_users', $new_block, get_user_meta( $current_user->ID, 'socbet_blocked_users', true ) );

	$ret = array(
		'err' => false
		);
	echo json_encode($ret);
	die();
}


add_action( 'wp_ajax_socbet_follow_user_action', 'ajax_socbet_follow_user' );
add_action( 'wp_ajax_nopriv_socbet_follow_user_action', 'ajax_socbet_follow_user' );
function ajax_socbet_follow_user() {
	global $current_user;
	get_currentuserinfo();

	if ( ! is_user_logged_in() ) {
		$ret = array(
			'err' => 'yes',
			'redirect' => 'yes',
			'url'	=> wp_login_url()
			);
		echo json_encode($ret);
		die();
	}

	if ( empty( $_POST['_socbetfollowusernonce'] ) || ! wp_verify_nonce( $_POST['_socbetfollowusernonce'], 'socbet-follow-user' ) ) {
		$ret = array(
			'err' => 'yes',
			'redirect' => 'yes',
			'url'	=> home_url('/')
			);
		//error_log('Error on security');
		echo json_encode($ret);
		die();
	}

	if ( empty( $_POST['user_id_to_follow'] ) ) {
		$ret = array(
			'err' => 'yes'
			);
		echo json_encode($ret);
		die();
	}

	$user_to_follow = intval($_POST['user_id_to_follow']);

	if ( current_user_is_follow($user_to_follow) ) {
		$ret = array(
			'err' => false
			);
		echo json_encode($ret);
		die();
	}

	$following = get_user_meta( $current_user->ID, 'socbet_following_data', true );
	$follower = get_user_meta( $user_to_follow, 'socbet_follower_data', true );

	if ( ! is_array($following) ) {
		$new_following = array($user_to_follow);
	} else {
		$new_following = array_merge( array($user_to_follow), $following );
	}

	update_user_meta( $current_user->ID, 'socbet_following_data', $new_following, get_user_meta( $current_user->ID, 'socbet_following_data', true ) );

	if ( ! is_array($follower) ) {
		$new_follower = array($current_user->ID);
	} else {
		$new_follower = array_merge( array($current_user->ID), $follower );
	}

	update_user_meta( $user_to_follow, 'socbet_follower_data', $new_follower, get_user_meta( $user_to_follow, 'socbet_follower_data', true ) );

	$ret = array(
		'err' => false
		);
	echo json_encode($ret);
	die();
}


add_action( 'wp_ajax_socbet_move_comment_to_trash', 'ajax_socbet_remove_message' );
add_action( 'wp_ajax_nopriv_socbet_move_comment_to_trash', 'ajax_socbet_remove_message' );
function ajax_socbet_remove_message() {
	global $current_user;
	get_currentuserinfo();

	if ( ! is_user_logged_in() ) {
		$ret = array(
			'err' => 'yes',
			'redirect' => 'yes',
			'url'	=> wp_login_url()
			);
		echo json_encode($ret);
		die();
	}

	if( empty( $_POST['comment_id'] ) ) {
		$ret = array(
			'err' => 'yes'
			);
		//error_log('Error on comment id');
		echo json_encode($ret);
		die();
	}

	if( empty( $_POST['comment_user_id'] ) ) {
		$ret = array(
			'err' => 'yes'
			);
		//error_log('Error on comment user id');
		echo json_encode($ret);
		die();
	}

	if( empty( $_POST['comment_post_id'] ) ) {
		$ret = array(
			'err' => 'yes'
			);
		//error_log('Error on comment post id');
		echo json_encode($ret);
		die();
	}

	$comment_id = intval( $_POST['comment_id'] );
	$comment_user_id = intval( $_POST['comment_user_id'] );
	$comment_post_id = intval( $_POST['comment_post_id'] );

	if ( empty( $_POST['_socbetremovecomment'.$comment_id] ) || ! wp_verify_nonce( $_POST['_socbetremovecomment'.$comment_id], 'socbet-remove-comment-'.$comment_id ) ) {
		$ret = array(
			'err' => 'yes'
			);
		//error_log('Error on security');
		echo json_encode($ret);
		die();
	}

	if ( $comment_user_id != $current_user->ID ) {
		$ret = array(
			'err' => 'yes'
			);
		//error_log('Error comment user id not same with current logged-in user');
		echo json_encode($ret);
		die();
	}

	if ( wp_trash_comment($comment_id) ) {
		$comment_number = get_comments_number( $comment_post_id );
		$ret = array(
			'err' => false,
			'number' => $comment_number,
			'url' => get_permalink( $comment_post_id )
			);
		echo json_encode($ret);
		die();
	}

	$ret = array(
		'err' => 'yes'
		);
	//error_log('failed to trash comment');
	echo json_encode($ret);
	die();
}



add_action( 'wp_ajax_socbet_post_new_message', 'ajax_socbet_post_new_message' );
add_action( 'wp_ajax_nopriv_socbet_post_new_message', 'ajax_socbet_post_new_message' );
function ajax_socbet_post_new_message() {
	global $wpdb, $current_user;
	get_currentuserinfo();

	if ( ! is_user_logged_in() ) {
		$ret = array(
			'err' => 'yes',
			'redirect' => 'yes',
			'url'	=> wp_login_url()
			);
		echo json_encode($ret);
		die();
	}

	if ( empty( $_POST['_socbetnewmsgnonce'] ) || ! wp_verify_nonce( $_POST['_socbetnewmsgnonce'], 'socbet-new-message' ) ) {
		$ret = array(
			'err' => 'yes'
			);
		//error_log('Error on security');
		echo json_encode($ret);
		die();
	}

	$content = isset( $_POST['message-content'] ) ? esc_textarea( $_POST['message-content'] ) : '';
	$msg_sender = isset( $_POST['user_id_from'] ) ? esc_sql( intval($_POST['user_id_from']) ) : '';
	$msg_receipt = isset( $_POST['user_id_to'] ) ? esc_sql( intval($_POST['user_id_to']) ) : '';

	if( empty( $content ) || empty( $msg_sender ) || empty( $msg_receipt ) ) {
		$ret = array(
			'err' => 'yes'
			);
		echo json_encode($ret);
		die();
	}

	$attachments = "";
	if ( isset($_POST['timeline_attachment_ids']) ) {
		$attachments = array();
		foreach ( (array) $_POST['timeline_attachment_ids'] as $attch ) {
			$attachments[] = $attch;
		}
		unset($attch);
		$attachments = implode(",", $attachments);
	}

	if ( ! is_wp_error( $wpdb->insert( $wpdb->prefix . 'socbet_messages',
		array(
			'user_id' => $msg_sender,
			'user_id_to' => $msg_receipt,
			'message' => $content,
			'attachment_ids' => $attachments,
			'date'	=> date('Y-m-d H:i:s'),
			'status' => 1
			),
		array('%d', '%d', '%s', '%s', '%s', '%d')) ) ) {

		$rid = $wpdb->insert_id;

		$ret = array(
			'err' => false,
			'reply_id' => $rid
			);
		echo json_encode($ret);
		die();
	}

	$ret = array(
		'err' => 'yes'
		);
	//error_log('cannot save to DB');
	echo json_encode($ret);
	die();

}


add_action( 'wp_ajax_socbet_post_message_reply', 'ajax_socbet_reply_message_form' );
add_action( 'wp_ajax_nopriv_socbet_post_message_reply', 'ajax_socbet_reply_message_form' );
function ajax_socbet_reply_message_form() {
	global $wpdb, $current_user;
	get_currentuserinfo();

	if ( ! is_user_logged_in() ) {
		$ret = array(
			'err' => 'yes',
			'redirect' => 'yes',
			'url'	=> wp_login_url()
			);
		echo json_encode($ret);
		die();
	}

	if ( empty( $_POST['_socbetmsgreplynonce'] ) || ! wp_verify_nonce( $_POST['_socbetmsgreplynonce'], 'socbet-message-reply' ) ) {
		$ret = array(
			'err' => 'yes'
			);
		//error_log('Error on security');
		echo json_encode($ret);
		die();
	}

	if( empty( $_POST['message_id'] ) ) {
		$ret = array(
			'err' => 'yes'
			);
		//error_log('Error on message id');
		echo json_encode($ret);
		die();
	}

	$message_id = intval( $_POST['message_id'] );
	$content = isset( $_POST['message-content'] ) ? esc_textarea( $_POST['message-content'] ) : '';

	if( empty( $content ) ) {
		$ret = array(
			'err' => 'yes'
			);
		//error_log('Blank message');
		echo json_encode($ret);
		die();
	}

	$attachments = "";
	if ( isset($_POST['timeline_attachment_ids']) ) {
		$attachments = array();
		foreach ( (array) $_POST['timeline_attachment_ids'] as $attch ) {
			$attachments[] = $attch;
		}
		unset($attch);
		$attachments = implode(",", $attachments);
	}

	if ( ! is_wp_error( $wpdb->insert( $wpdb->prefix . 'socbet_message_replies',
		array(
			'message_id' => $message_id,
			'user_id' => $current_user->ID,
			'message' => $content,
			'attachment_ids' => $attachments,
			'date'	=> date('Y-m-d H:i:s'),
			'status' => 1
			),
		array('%d', '%d', '%s', '%s', '%s', '%d')) ) ) {

		$rid = $wpdb->insert_id;

		$ret = array(
			'err' => false,
			'reply_id' => $rid
			);
		echo json_encode($ret);
		die();
	}

	$ret = array(
		'err' => 'yes'
		);
	//error_log('cannot save to DB');
	echo json_encode($ret);
	die();

}

add_action( 'wp_ajax_voted_poll', 'ajax_socbet_user_voted_poll' );
add_action( 'wp_ajax_nopriv_voted_poll', 'ajax_socbet_user_voted_poll' );
function ajax_socbet_user_voted_poll() {
	global $current_user;
	get_currentuserinfo();

	if ( ! is_user_logged_in() ) {
		$ret = array(
			'err' => 'yes',
			'redirect' => 'yes',
			'url'	=> wp_login_url()
			);
		echo json_encode($ret);
		die();
	}

	if( empty( $_POST['post_id'] ) ) {
		$ret = array(
			'err' => 'yes'
			);
		echo json_encode($ret);
		die();
	}

	$post_id = $_POST['post_id'];

	if ( empty( $_POST['_socbetvotedpoll_'.$post_id] ) || ! wp_verify_nonce( $_POST['_socbetvotedpoll_'.$post_id], 'socbet-voted-poll-'.$post_id ) ) {
		$ret = array(
			'err' => 'yes'
			);
		//error_log('Error on security');
		echo json_encode($ret);
		die();
	}

	$poller = get_post_meta( $post_id, '_socbet_poll_results', true );

	// user already voted
	if ( user_is_voted_on_poll($post_id) ) {
		$ret = array(
			'err' => 'yes'
			);
		echo json_encode($ret);
		die();
	}

	$result = $_POST['pool_me'];
	update_user_meta( $current_user->ID, 'socbet_poll_'.$post_id, 'voted', get_user_meta($current_user->ID, 'socbet_poll_'.$post_id, true ) );
	if ( is_array($poller) ) {
		$new_voted = array($result);
		$new_poller = array_merge($poller, $new_voted);
	} else {
		$new_poller = array($result);
	}

	update_post_meta( $post_id, '_socbet_poll_results', $new_poller, get_post_meta( $post_id, '_socbet_poll_results', true ) );

	$ret = array(
		'err' => false,
		'url' => get_permalink($post_id)
		);
	echo json_encode($ret);
	die();
}

add_action( 'wp_ajax_post_live_status', 'ajax_socbet_user_post_status' );
add_action( 'wp_ajax_nopriv_post_live_status', 'ajax_socbet_user_post_status' );
function ajax_socbet_user_post_status() {
	global $current_user;
	get_currentuserinfo();

	if ( ! is_user_logged_in() ) {
		$ret = array(
			'err' => 'yes'
			);
		echo json_encode($ret);
		die();
	}

	if ( empty( $_POST['_socbetuserstatusnonce'] ) || ! wp_verify_nonce( $_POST['_socbetuserstatusnonce'], 'socbet-user-status-post' ) ) {
		$ret = array(
			'err' => 'yes'
			);
		//error_log('Error on security');
		echo json_encode($ret);
		die();
	}

	if ( empty( $_POST['user_post_id'] ) ) {
		$ret = array(
			'err' => 'yes'
			);
		//error_log('Error user ID is not detected');
		echo json_encode($ret);
		die();
	}

	$user_id = intval( $_POST['user_post_id'] );
	$description = isset( $_POST['content'] ) ? $_POST['content'] : '';

	if ( isset( $_POST['use_poll']) && empty($description) ) {
		$description = $_POST['poll-name'];
	}

	if ( !isset($_POST['timeline_attachment_ids']) && empty($description) ) {
		$ret = array(
			'err' => 'yes'
			);
		//error_log('Error description is not there');
		echo json_encode($ret);
		die();
	}

	$post_to_save = array(
		'comment_status' 	=> 'open',
		'ping_status'		=> 'closed', // should we allow ping?
		'post_author'		=> intval($user_id),
		'post_content'		=> $description,
		'post_status'		=> 'publish',
		'post_title'		=> '',
		'post_type'			=> 'timeline'
		);

	$save_post = wp_insert_post( $post_to_save, true );

	if ( ! is_wp_error($save_post) ) {

		//update attachments
		if ( isset($_POST['timeline_attachment_ids']) ) {
			foreach ( (array) $_POST['timeline_attachment_ids'] as $attch_id ) {
				wp_update_post( array(
					'ID' => intval($attch_id),
					'post_parent' => intval($save_post)
					));
			}
			unset($attch_id);
		}

		// poll data
		if ( isset( $_POST['use_poll']) ) {
			update_post_meta( intval($save_post), '_socbet_poll_name', $_POST['poll-name'] );
			$poll_data = array();
			foreach( (array) $_POST['poll-options'] as $ops ) {
				if ( ! empty($ops) ) {
					$poll_data[] = $ops;
				}
			}
			unset( $ops );
			update_post_meta( intval($save_post), '_socbet_poll_options', $poll_data );
		}
		
		$ret = array(
			'err' => false,
			'post_id' => intval($save_post)
			);
		echo json_encode($ret);
		die();
	}

	$ret = array(
		'err' => 'yes'
		);
	//error_log('Error, wp trouble cannot save the post');
	echo json_encode($ret);
	die();
}


add_action( 'wp_ajax_post_live_group', 'ajax_socbet_user_post_group' );
add_action( 'wp_ajax_nopriv_post_live_group', 'ajax_socbet_user_post_group' );
function ajax_socbet_user_post_group() {
	global $current_user;
	get_currentuserinfo();

	if ( ! is_user_logged_in() ) {
		$ret = array(
			'err' => 'yes'
			);
		echo json_encode($ret);
		die();
	}

	if ( empty( $_POST['_socbetuserstatusnonce'] ) || ! wp_verify_nonce( $_POST['_socbetuserstatusnonce'], 'socbet-user-status-post' ) ) {
		$ret = array(
			'err' => 'yes'
			);
		//error_log('Error on security');
		echo json_encode($ret);
		die();
	}

	if ( empty( $_POST['user_post_id'] ) ) {
		$ret = array(
			'err' => 'yes'
			);
		//error_log('Error user ID is not detected');
		echo json_encode($ret);
		die();
	}

	$user_id = intval( $_POST['user_post_id'] );
	$description = isset( $_POST['content'] ) ? $_POST['content'] : '';
	$term_id = intval( $_POST['term_id'] );
	if ( isset( $_POST['use_poll']) && empty($description) ) {
		$description = $_POST['poll-name'];
	}

	if ( !isset($_POST['timeline_attachment_ids']) && empty($description) ) {
		$ret = array(
			'err' => 'yes'
			);
		//error_log('Error description is not there');
		echo json_encode($ret);
		die();
	}

	$post_to_save = array(
		'comment_status' 	=> 'open',
		'ping_status'		=> 'closed', // should we allow ping?
		'post_author'		=> intval($user_id),
		'post_content'		=> $description,
		'post_status'		=> 'publish',
		'post_title'		=> '',
		'post_type'			=> 'group-post'
		);

	$save_post = wp_insert_post( $post_to_save, true );

	if ( ! is_wp_error($save_post) ) {

		//update attachments
		if ( isset($_POST['timeline_attachment_ids']) ) {
			foreach ( (array) $_POST['timeline_attachment_ids'] as $attch_id ) {
				wp_update_post( array(
					'ID' => intval($attch_id),
					'post_parent' => intval($save_post)
					));
			}
			unset($attch_id);
		}

		// poll data
		if ( isset( $_POST['use_poll']) ) {
			update_post_meta( intval($save_post), '_socbet_poll_name', $_POST['poll-name'] );
			$poll_data = array();
			foreach( (array) $_POST['poll-options'] as $ops ) {
				if ( ! empty($ops) ) {
					$poll_data[] = $ops;
				}
			}
			unset( $ops );
			update_post_meta( intval($save_post), '_socbet_poll_options', $poll_data );
		}

		$term_taxonomy_ids = wp_set_object_terms( intval($save_post), array($term_id), 'group_name' );
		
		$ret = array(
			'err' => false,
			'post_id' => intval($save_post)
			);
		echo json_encode($ret);
		die();
	}

	$ret = array(
		'err' => 'yes'
		);
	//error_log('Error, wp trouble cannot save the post');
	echo json_encode($ret);
	die();
}


add_action( 'wp_ajax_socbet_quit_competition', 'ajax_socbet_quit_competition' );
add_action( 'wp_ajax_nopriv_socbet_quit_competition', 'ajax_socbet_quit_competition' );
function ajax_socbet_quit_competition() {
	global $current_user;
	get_currentuserinfo();

	if ( ! is_user_logged_in() ) {
		$ret = array(
			'err' => 'yes',
			'redirect' => 'yes',
			'url'	=> wp_login_url()
			);
		//error_log('Error on security');
		echo json_encode($ret);
		die();
	}


	if ( empty( $_POST['_wpajaxquitcompetition'] ) || ! wp_verify_nonce( $_POST['_wpajaxquitcompetition'], 'socbet-quit-competition' ) ) {
		$ret = array(
			'err' => 'yes',
			'redirect' => 'yes',
			'url'	=> wp_login_url()
			);
		//error_log('Error on security');
		echo json_encode($ret);
		die();
	}

	if ( empty( $_POST['competition_id'] ) ) {
		$ret = array(
			'err' => 'yes'
			);
		//error_log('Error on competition id not detected');
		echo json_encode($ret);
		die();
	}

	$cid = intval( $_POST['competition_id'] );
	if ( ! user_is_participant( $cid ) ) {
		$ret = array(
			'err' => 'yes'
			);
		//error_log('User not registered');
		echo json_encode($ret);
		die();
	}

	$competition_users = get_post_meta( $cid, '_'.SOCIALBET_NAME.'_competition_participants', true );
	$newcompusers = $competition_users;
	// remove the user
	if ( is_array( $competition_users ) ) {
		$array_min = array( $current_user->ID );
		$newcompusers = array_values( array_diff($competition_users,$array_min) );
	}

	update_post_meta( $cid, '_'.SOCIALBET_NAME.'_competition_participants', $newcompusers , get_post_meta( $cid, '_'.SOCIALBET_NAME.'_competition_participants', true ) );

	$user_datas = get_user_meta( $current_user->ID, 'user_participate_in', true );
	$new_user_data = $user_datas;
	if ( is_array( $user_datas ) ) {
		$udata_min = array( $cid );
		$new_user_data = array_values( array_diff($user_datas,$udata_min) );
	}

	update_user_meta( $current_user->ID, 'user_participate_in', $new_user_data, get_user_meta( $current_user->ID, 'user_participate_in', true ) );

	$ret = array(
		'err' => false
		);
	echo json_encode($ret);
	die();
}

add_action( 'wp_ajax_socbet_enter_competition', 'ajax_socbet_enter_competition' );
add_action( 'wp_ajax_nopriv_socbet_enter_competition', 'ajax_socbet_enter_competition' );
function ajax_socbet_enter_competition() {
	global $current_user;
	get_currentuserinfo();

	if ( ! is_user_logged_in() ) {
		$ret = array(
			'err' => 'yes'
			);
		//error_log('Error on security');
		echo json_encode($ret);
		die();
	}

	if ( empty( $_POST['_wpajaxentercompetition'] ) || ! wp_verify_nonce( $_POST['_wpajaxentercompetition'], 'socbet-enter-competition' ) ) {
		$ret = array(
			'err' => 'yes'
			);
		//error_log('Error on security');
		echo json_encode($ret);
		die();
	}

	if ( empty( $_POST['competition_id'] ) ) {
		$ret = array(
			'err' => 'yes'
			);
		//error_log('Error on competition id not detected');
		echo json_encode($ret);
		die();
	}

	$cid = intval( $_POST['competition_id'] );

	if ( user_is_participant( $cid ) ) {
		$ret = array(
			'err' => 'yes'
			);
		//error_log('User already registered');
		echo json_encode($ret);
		die();
	}

	$competition_users = get_post_meta( $cid, '_'.SOCIALBET_NAME.'_competition_participants', true );

	if ( empty( $competition_users ) ) {
		
		$competition_users = array($current_user->ID);
	
	} else {
		
		if ( is_array( $competition_users ) ) {
			$new_user = array($current_user->ID);
			$competition_users = array_merge( $competition_users, $new_user );
		} else {
			$competition_users = array($current_user->ID);
		}
	
	}

	// update the post data
	update_post_meta( $cid, '_'.SOCIALBET_NAME.'_competition_participants', $competition_users , get_post_meta( $cid, '_'.SOCIALBET_NAME.'_competition_participants', true ) );

	$user_datas = get_user_meta( $current_user->ID, 'user_participate_in', true );
	
	if ( empty( $user_datas ) ) {
		
		$user_datas = array($cid);
	
	} else {
		
		if ( is_array( $user_datas ) ) {
			$new_post = array($cid);
			$user_datas = array_merge( $user_datas, $new_post );
		} else {
			$user_datas = array($cid);
		}
	
	}
	update_user_meta( $current_user->ID, 'user_participate_in', $user_datas, get_user_meta( $current_user->ID, 'user_participate_in', true ) );

	$ret = array(
		'err' => false
		);
	echo json_encode($ret);
	die();

}


add_action( 'wp_ajax_socbet_get_state', 'ajax_socbet_selecting_state' );
add_action( 'wp_ajax_nopriv_socbet_get_state', 'ajax_socbet_selecting_state' );
function ajax_socbet_selecting_state() {
	global $SocBet_Theme;

	if ( empty( $_POST['_wpajaxsettingnonce'] ) || ! wp_verify_nonce( $_POST['_wpajaxsettingnonce'], 'socbet-user-ajax-mysettings' ) ) {
		echo '';
		die();
	}

	$country = isset( $_POST['ajx_country'] ) ? $_POST['ajx_country'] : false;
	if ( !$country ) {
		echo '';
		die();
	}

	$SocBet_Theme->countries->country_dropdown_options( $country, '', false );
	die();
}


add_action( 'wp_ajax_socbet_upload_profile_img', 'ajax_socbet_user_photo_uploader' );
add_action( 'wp_ajax_nopriv_socbet_upload_profile_img', 'ajax_socbet_user_photo_uploader' );
function ajax_socbet_user_photo_uploader() {
	global $SocBet_Theme, $current_user;
	get_currentuserinfo();

	if ( empty( $_POST['_wpajaxnonce'] ) || ! wp_verify_nonce( $_POST['_wpajaxnonce'], 'socbet-user-photo' ) ) {
		$ret = array(
			'err' => 'yes'
			);
		//error_log('Error on security');
		echo json_encode($ret);
		die();
	}

	// check the User session, if not match, break the process
	if ( empty( $_POST['userId'] ) || ( isset( $_POST['userId'] ) && intval( $_POST['userId'] ) != $current_user->ID ) ) {
		$ret = array(
			'err' => 'yes'
			);
		//error_log('Error on user id');
		echo json_encode($ret);
		die();
	}

	if ( empty( $_FILES['user-photo'] ) ) {
		$ret = array(
			'err' => 'yes'
			);
		//error_log('Error on file not detected');
		echo json_encode($ret);
		die();
	}

	// These files need to be included as dependencies when on the front end.
	require_once( ABSPATH . 'wp-admin/includes/image.php' );
	require_once( ABSPATH . 'wp-admin/includes/file.php' );
	require_once( ABSPATH . 'wp-admin/includes/media.php' );

	$attachment_id = media_handle_upload( 'user-photo', 0 );
	
	if ( is_wp_error($attachment_id) ){
		$ret = array(
			'err' => 'yes'
			);
		//error_log('Error on upload,' . $uploaded_file );
		echo json_encode($ret);
		die();
	}

	$user_id = intval( $_POST['userId'] );
	if ( $user_image = wp_get_attachment_image_src( $attachment_id, 'user_profile' ) ) {
		$file_url = $user_image[0];
	} else {
		$file_url = wp_get_attachment_url($attachment_id);
	}

	update_user_meta( $user_id, 'avatar', $file_url, get_user_meta($user_id, 'avatar', true ) );

	$post_to_save = array(
		'comment_status' 	=> 'open',
		'ping_status'		=> 'closed', // should we allow ping?
		'post_author'		=> intval($user_id),
		'post_content'		=> '',
		'post_status'		=> 'publish',
		'post_title'		=> '',
		'post_type'			=> 'timeline'
		);

	$save_post = wp_insert_post( $post_to_save, true );

	if ( !is_wp_error($save_post) ) {
		update_post_meta( $save_post, '_is_update_profile_photo', 'true' );
		
		wp_update_post( array(
			'ID' => intval($attachment_id),
			'post_parent' => intval($save_post)
			));
	}


	//success return the data to front-end
	$ret = array(
		'err' => false,
		'imgUrl' => esc_url( $file_url )
		);
	echo json_encode($ret);
	die();
}


add_action( 'wp_ajax_socbet_upload_group_thumbnail', 'ajax_socbet_group_thumbnail_uploader' );
add_action( 'wp_ajax_nopriv_socbet_upload_group_thumbnail', 'ajax_socbet_group_thumbnail_uploader' );
function ajax_socbet_group_thumbnail_uploader() {
	global $SocBet_Theme, $current_user;
	get_currentuserinfo();

	if ( ! is_user_logged_in() ) {
		$ret = array(
			'err' => 'yes'
			);
		echo json_encode($ret);
		die();
	}

	if ( empty( $_POST['_wpajaxnonce'] ) || ! wp_verify_nonce( $_POST['_wpajaxnonce'], 'socbet-group-thumbnail' ) ) {
		$ret = array(
			'err' => 'yes'
			);
		//error_log('Error on security');
		echo json_encode($ret);
		die();
	}

	if ( empty( $_POST['group_id'] ) ) {
		$ret = array(
			'err' => 'yes'
			);
		//error_log('Error on group id');
		echo json_encode($ret);
		die();
	}

	if ( empty( $_FILES['group-thumbnail'] ) ) {
		$ret = array(
			'err' => 'yes'
			);
		//error_log('Error on file not detected');
		echo json_encode($ret);
		die();
	}

	// These files need to be included as dependencies when on the front end.
	require_once( ABSPATH . 'wp-admin/includes/image.php' );
	require_once( ABSPATH . 'wp-admin/includes/file.php' );
	require_once( ABSPATH . 'wp-admin/includes/media.php' );

	$attachment_id = media_handle_upload( 'group-thumbnail', 0 );
	
	if ( is_wp_error($attachment_id) ){
		$ret = array(
			'err' => 'yes'
			);
		//error_log('Error on upload,' . $uploaded_file );
		echo json_encode($ret);
		die();
	}

	$group_id = intval( $_POST['group_id'] );

	$term_meta = get_option( 'taxonomy_meta_'.$group_id );

	if ( ! is_array($term_meta) ) {
		$ret = array(
			'err' => 'yes'
			);
		//error_log('Error on upload,' . $uploaded_file );
		echo json_encode($ret);
		die();
	}

	$term_meta['thumbnail'] = $attachment_id;
	update_option( 'taxonomy_meta_'.$group_id, $term_meta );

	$file_url = wp_get_attachment_thumb_url($attachment_id);

	//success return the data to front-end
	$ret = array(
		'err' => false,
		'imgUrl' => esc_url( $file_url )
		);
	echo json_encode($ret);
	die();
}


add_action( 'wp_ajax_socbet_upload_group_image', 'ajax_socbet_group_image_uploader' );
add_action( 'wp_ajax_nopriv_socbet_upload_group_image', 'ajax_socbet_group_image_uploader' );
function ajax_socbet_group_image_uploader() {
	global $SocBet_Theme, $current_user;
	get_currentuserinfo();

	if ( ! is_user_logged_in() ) {
		$ret = array(
			'err' => 'yes'
			);
		echo json_encode($ret);
		die();
	}

	if ( empty( $_POST['_wpajaxnonce'] ) || ! wp_verify_nonce( $_POST['_wpajaxnonce'], 'socbet-group-image' ) ) {
		$ret = array(
			'err' => 'yes'
			);
		//error_log('Error on security');
		echo json_encode($ret);
		die();
	}

	if ( empty( $_POST['group_id'] ) ) {
		$ret = array(
			'err' => 'yes'
			);
		//error_log('Error on group id');
		echo json_encode($ret);
		die();
	}

	if ( empty( $_FILES['group-image'] ) ) {
		$ret = array(
			'err' => 'yes'
			);
		//error_log('Error on file not detected');
		echo json_encode($ret);
		die();
	}

	// These files need to be included as dependencies when on the front end.
	require_once( ABSPATH . 'wp-admin/includes/image.php' );
	require_once( ABSPATH . 'wp-admin/includes/file.php' );
	require_once( ABSPATH . 'wp-admin/includes/media.php' );

	$attachment_id = media_handle_upload( 'group-image', 0 );
	
	if ( is_wp_error($attachment_id) ){
		$ret = array(
			'err' => 'yes'
			);
		//error_log('Error on upload,' . $uploaded_file );
		echo json_encode($ret);
		die();
	}

	$group_id = intval( $_POST['group_id'] );

	$term_meta = get_option( 'taxonomy_meta_'.$group_id );

	if ( ! is_array($term_meta) ) {
		$ret = array(
			'err' => 'yes'
			);
		//error_log('Error on upload,' . $uploaded_file );
		echo json_encode($ret);
		die();
	}

	$term_meta['image'] = $attachment_id;
	update_option( 'taxonomy_meta_'.$group_id, $term_meta );

	$file_url = wp_get_attachment_url($attachment_id);

	//success return the data to front-end
	$ret = array(
		'err' => false,
		'imgUrl' => esc_url( $file_url )
		);
	echo json_encode($ret);
	die();
}

add_action( 'wp_ajax_socbet_timelines_files', 'ajax_socbet_timeline_files_upload' );
add_action( 'wp_ajax_nopriv_socbet_timelines_files', 'ajax_socbet_timeline_files_upload' );
function ajax_socbet_timeline_files_upload() {
	
	if ( ! is_user_logged_in() ) {
		$ret = array(
			'err' => 'yes'
			);
		//error_log('User need logged in');
		echo json_encode($ret);
		die();
	}

	if ( empty( $_POST['_socbettimelinefilesnonce'] ) || ! wp_verify_nonce( $_POST['_socbettimelinefilesnonce'], 'socbet-timeline-files' ) ) {
		$ret = array(
			'err' => 'yes'
			);
		//error_log('Error on security');
		echo json_encode($ret);
		die();
	}

	// These files need to be included as dependencies when on the front end.
	require_once( ABSPATH . 'wp-admin/includes/image.php' );
	require_once( ABSPATH . 'wp-admin/includes/file.php' );
	require_once( ABSPATH . 'wp-admin/includes/media.php' );

	$attachment_id = media_handle_upload( 'socbet_timelinefiles_upload', 0 );

	if ( is_wp_error( $attachment_id ) ) {
		// upload error, possible reason are file type is not allowed by wp or the file size is too large
		$ret = array(
			'err' => 'yes'
			);
		echo json_encode($ret);
		die();
	} else {
		$mime_type = get_post_mime_type( $attachment_id );
		if ( in_array( $mime_type, array('image/jpeg', 'image/png', 'image/gif') ) ) {
			if ( $attdata = wp_get_attachment_image_src( $attachment_id ) ) {
				$thumbnail = $attdata[0];
			}
		} else {
			$thumbnail = wp_mime_type_icon( $mime_type );
		}

		$ret = array(
			'err' => false,
			'thumbnail' => $thumbnail,
			'attachment_id' => $attachment_id
			);
		echo json_encode($ret);
		die();

	}
}
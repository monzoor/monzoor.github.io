<?php
/**
 * Core functions
 *
 * @since version 1.0
 */


function socbet_get_language_code() {

  $locale = get_locale();
  $localelis = explode('_', trim($locale));
  
  return ( isset($localelis[0]) ? $localelis[0] : $locale ); 

}


/**
 * Check if custom menu has been build or not
 * @param $loc = location of the menu
 *
 * @access public
 * @return bool
 */
function socbet_have_custom_menu( $loc ) {
	$menu = has_nav_menu( $loc );

	return $menu;
}


/**
 * template redirect
 * 
 */
function socbet_global_template_redirect() {
    global $wp_query;

    $loggedin = false;
    if ( is_user_logged_in() )
        $loggedin = true;

    if ( is_socbet_user_settings_page() && ! is_own_profile() ) {
      if ( $loggedin ) {

          $user_page = is_socbet_user_settings_page();
          if ( ! user_is_allowed_access( $user_page ) ) {
            wp_safe_redirect( esc_url( home_url() ) );
            exit;
          }

      } else {
          wp_safe_redirect( esc_url( wp_login_url() ) );
          exit;
      }
    }

    return true;
}


function socbet_go_to_bet_page() {
  if ( is_user_logged_in() ) {
    //change to bet page later
    return '#';
  } else {
    return wp_login_url( home_url('/') );
  }
}

/**
 * Get image URL of featured image
 * @param $id = post id/attachment id
 *
 * @access public
 * @return image URL
 */
function socbet_get_featured_image_link($id) {
    $thumb = get_post_thumbnail_id($id);

    if ( !$thumb )
        return false;

    return wp_get_attachment_url($thumb);
}


function socbet_get_competition_type_links() {
    $types = get_terms( 'competition_type', 'hide_empty=0&orderby=id' );

    $links = '<ul>' . "\n";
    $links .= '<li'. ( is_post_type_archive('competition') ? ' class="selected"' : '' ) .'><a href="'. get_post_type_archive_link('competition') .'">' . esc_html('Все', 'socialbet') . '</a></li>' . "\n";
    
    if ( !empty( $types ) && !is_wp_error( $types ) ) {
        
        foreach ( $types as $type ) {
            $links .= '<li'. ( is_tax( 'competition_type', $type->term_id ) ? ' class="selected"' : '' ) .'><a href="'. get_term_link( $type ) .'">' . esc_html( $type->name ) . '</a></li>' . "\n";
        }
        unset($type);

    }
    $links .= '</ul>' . "\n";

    return $links;
}

/**
 * get image for competition
 *
 * @return string
 */
function socbet_get_competition_image() {
    global $post;

    if ( !is_object($post) )
        return false;

    $image = get_template_directory_uri() . '/assets/images/competition.jpg';
    if ( $url = socbet_get_featured_image_link( $post->ID ) ) {
        $image = $url;
    }

    return $image;
}

/**
 * get competition time ends
 * 
 * @param $id = Int Post ID
 *
 * @return string
 */
function socbet_get_competition_time_ends( $id ) {
    $comp_date = get_post_meta( $id, '_'.SOCIALBET_NAME.'_competition_end', true );
    if ( !$comp_date )
        return "null";

    $end_date = new DateTime( date('Y-m-d H:i:s', strtotime($comp_date) ) );
    $now = new DateTime(date('Y-m-d H:i:s'));

    if ( $now > $end_date )
        return 'null';

    return date('Y/m/d H:i:s', strtotime($comp_date));
}

/**
 * get the time diff
 * 
 * @param $id = Int Post ID
 * @param $format = string the return format 'D','H','I','S'
 *
 * @return string
 */
function socbet_get_competition_time_diff( $id, $format='D' ) {

    $comp_date = get_post_meta( $id, '_'.SOCIALBET_NAME.'_competition_end', true );
    if ( !$comp_date )
        return '00';

    $comp_date = new DateTime( date('Y-m-d H:i:s', strtotime($comp_date) ) );
    $now = new DateTime(date('Y-m-d H:i:s'));

    if ( $now > $comp_date )
        return '00';

    $allowed_format = array('D','H','I','S');
    if ( !in_array($format, $allowed_format) )
        return '00';

    $interval = date_diff($now, $comp_date);

    return $interval->format( '%'.$format );
}

/**
 * Creates a nicely formatted and more specific title element text for output
 * in head of document, based on current view.
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
add_filter( 'wp_title', 'socbet_filtered_wp_title', 10, 2 );
function socbet_filtered_wp_title( $title, $sep ) {
    global $paged, $page;

    if ( is_feed() )
        return $title;

    if ( $custom = is_socbet_user_page() )
        $title = $custom . ' ' . $sep . ' ';

    if ( is_post_type_archive('group-post') )
      $title = 'Группы ' . $sep . ' ';

    // Add the site name.
    $title .= get_bloginfo( 'name' );

    // Add the site description for the home/front page.
    $site_description = get_bloginfo( 'description', 'display' );
    if ( $site_description && ( is_home() || is_front_page() ) )
        $title = "$title $sep $site_description";

    // Add a page number if necessary.
    if ( $paged >= 2 || $page >= 2 )
        $title = "$title $sep " . sprintf( __( 'Page %s', 'socialbet' ), max( $paged, $page ) );

    return $title;
}


/**
 * Filter the post type's link
 * 
 * @return void
 */
add_filter( 'post_type_link', 'glossary_term_permalink', 10, 2 );
function glossary_term_permalink( $post_link, $post ) {
    if ( false == strpos( $post_link, '%' ) ) {
      return $post_link;
    }

    if ( false !== strpos( $post_link, '%sport_type%' ) && 'event' == get_post_type($post) ) {
        $slugs = socbet_terms_slug_tree( 'sport_type', $post->ID );
        $post_link = str_replace( '%sport_type%', $slugs, $post_link );

        return $post_link;
    }

    return $post_link;
}

/**
 * get nicely slug based on terms
 *
 * @return string
 */
function socbet_terms_slug_tree( $taxonomy, $postID ) {
    // get terms for current post
    // get only one since we will create slugs for permalink
    $terms = get_the_terms( $postID, $taxonomy );

    $slug = "";
    if ( $terms ) {
        $term = array_pop( $terms );

        $pr_slug = array();
        $pr_slug[] = $term->slug;
        while ($term->parent != '0'){
            $tp_id = $term->parent;

            $term = get_term_by( 'id', $tp_id, $taxonomy );
            $pr_slug[] = $term->slug;
        }

        $slugs = array_reverse($pr_slug);
        $slug = implode('/', $slugs);
    }

    // return the results
    return $slug;
}

/**
 * Add custom interval for WP cronjobs
 *
 * @return void
 */
function cron_add_more_schedules( $schedules ) {
    // Adds once minutes to the existing schedules.
    $schedules['aminute'] = array(
        'interval' => 60,
        'display' => __( 'Once a Minute', 'socialbet' )
    );

    // Adds twice a minutes
    $schedules['twiceaminute'] = array(
        'interval' => 30,
        'display' => __( 'Twice a Minute', 'socialbet' )
    );

    $schedules['tenseconds'] = array(
        'interval' => 10,
        'display' => __( 'Once Per Ten Seconds', 'socialbet' )
    );

    return $schedules;
}


/**
 * get profile details
 *
 * @return user object
 */
function get_profile_user_details() {
    global $wp_query, $profile_user;

    if ( ! is_socbet_user_page() )
      return false;

    //reset
    if ( $profile_user ) 
        unset( $profile_user );

    $profile_user = get_user_by( 'slug', $wp_query->query_vars['user'] );

    if ( ! $profile_user )
        return false;

    $GLOBALS['profile_user'] = new WP_User( $profile_user->ID );
}


/**
 * get all meta data from a user
 *
 * @return array()
 */
function get_socbet_usermeta( $userID = "" ) {
  
  if ( empty($userID) )
    return false;

  return array_map( function( $a ){ return $a[0]; }, get_user_meta( $userID ) );

}


function socbet_get_dialog_url( $msg_id ) {
  global $wp_rewrite, $current_user;
  get_currentuserinfo();

  if ( ! is_user_logged_in() )
    return false;

  $url = get_socbet_user_dashboard_url( $current_user->ID, _transliteration_process( esc_html( urldecode('мои-сообщения') ), '?', 'ru' ) );

  $user_link = $wp_rewrite->get_extra_permastruct('user');

  if ( ! empty($user_link) ) {
    $link = user_trailingslashit( trailingslashit( $url . "dialog/{$msg_id}/"), 'user' );
  } else {
    $link = add_query_arg( 'dialog', $msg_id, esc_url( $url ) );
  }

  return $link;
}


/**
 * Count partisipants in a competition
 *
 * @return int
 */
function get_participants_number( $post_id ) {
  
  $participants = get_post_meta( $post_id, '_'.SOCIALBET_NAME.'_competition_participants', true );

  if( empty($participants) )
    return 0;
  else
    return count($participants);

}


function get_participants_competition_users( $post_id ) {

  $competition_users = get_post_meta( $post_id, '_'.SOCIALBET_NAME.'_competition_participants', true );

  if ( !$competition_users )
    return false;

  return $competition_users;
}


function get_user_competition_counts( $type="all", $post_ids=array() ) {

  if ( empty($post_ids) )
    return '0';

  $args = array(
    'post_type' => 'competition',
    'post_status' => 'publish',
    'post__in' => $post_ids,
    'posts_per_page' => -1,
    'orderby' => 'date'
    );

  $today = date("Y-m-d H:i:s");
  if ( $type == 'active' ) {
    $args['meta_query'] = array(
        array(
          'key'     => '_'.SOCIALBET_NAME.'_competition_end',
          'value'   => $today,
          'type'    => 'DATETIME',
          'compare' => '>=',
        ),
      );
  } else if ( $type == 'end' ) {
    $args['meta_query'] = array(
        array(
          'key'     => '_'.SOCIALBET_NAME.'_competition_end',
          'value'   => $today,
          'type'    => 'DATETIME',
          'compare' => '<=',
        ),
      );
  }

  $countquery = new WP_Query($args);

  ob_start();

  echo $countquery->found_posts;
  wp_reset_query();

  return ob_get_clean();

}


function socbet_time_diff( $from, $to = '' ) {
  if ( empty( $to ) ) {
    $to = time();
  }

  $suffix = date('H:i', $from);
  $diff = (int) abs( $to - $from );

  if ( $diff < HOUR_IN_SECONDS ) {
    $mins = round( $diff / MINUTE_IN_SECONDS );
    if ( $mins <= 1 )
      $mins = 1;

    if ( $mins < 2 ) {
      $since = __('сейчас', 'socialbet');
    } else {
      $since = sprintf( _n( '%s минута назад', '%s минут назад', $mins ), $mins );
    }

  } elseif ( $diff < DAY_IN_SECONDS && $diff >= HOUR_IN_SECONDS ) {
    $hours = round( $diff / HOUR_IN_SECONDS );
    if ( $hours <= 1 )
      $hours = 1;
    $since = sprintf( _n( '%s час назад', '%s часов назад', $hours ), $hours );
  
  } elseif ( $diff < WEEK_IN_SECONDS && $diff >= DAY_IN_SECONDS ) {
    $days = round( $diff / DAY_IN_SECONDS );
    if ( $days <= 1 )
      $days = 1;

    if ( $days < 2 ) {
      $since = sprintf( __('вчера назад в %s', 'socialbet'), $suffix );
    } else {
      $since = sprintf( _n( '%s день в %s', '%s дней в %s', $days ), $days, $suffix );
    }
  } else {
    $since = sprintf( __('%s в %s'), date( 'd M', $from ), $suffix );
  }

  return $since;
}


function socbet_has_attachments() {
  global $post;

  if ( !is_object($post) )
    return false;

  $args = array( 'post_type' => 'attachment', 'posts_per_page' => -1, 'post_status' =>'any', 'post_parent' => $post->ID ); 
  $attachments = get_posts( $args );
  if ( $attachments ) {
    return $attachments;
  }

  return false;
}

/**
 * Remove default wp-login style
 *
 * @return void
 */
function socbet_remove_login_styles() {
  wp_dequeue_style( 'login' );
}

/**
 * enqueue the login styles
 *
 * @return void
 */
function socbet_add_login_styles() {
  wp_enqueue_style( 'socialbet-login', get_template_directory_uri() .'/assets/css/login.css', false, SOCIALBET_VERSION );
  wp_enqueue_style( 'socialbet-helper', get_template_directory_uri() .'/assets/css/helper.css', false, SOCIALBET_VERSION );
}



function socbet_save_user_privacy_settings() {
  global $wp_query, $current_user, $user_data;
  get_currentuserinfo();

  $errors = new WP_Error();
  $data = array();

  if ( empty( $_POST['_wpnonce'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], 'socbet-user-mysettings' ) ) {
    // we need to completely break all process if security check is failed!
    wp_die( __('Security check failed!', 'socialbet') );
  }

  $data['view_my_bets'] = isset( $_POST['view_my_bets'] ) ? $_POST['view_my_bets'] : '';
  $data['view_my_stats'] = isset( $_POST['view_my_stats'] ) ? $_POST['view_my_stats'] : '';
  $data['message_me'] = isset( $_POST['message_me'] ) ? $_POST['message_me'] : '';

  foreach( $data as $field => $value ) {
    update_user_meta( $current_user->ID, $field, $value );
  }
  unset($field);
  unset($value);

  $errors->add( 'message', esc_html__('Ваши настройки будут успешно сохранены!', 'socialbet'), 'message' );
  $user_data = get_socbet_usermeta( $current_user->ID );
  
  return $errors;

}


/**
 * Save user settings
 *
 * @return void
 */
function socbet_save_user_general_settings() {
  global $wp_query, $current_user, $user_data;
  get_currentuserinfo();

  $errors = new WP_Error();
  $data = array();

  if ( empty( $_POST['_wpnonce'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], 'socbet-user-mysettings' ) ) {
    // we need to completely break all process if security check is failed!
    wp_die( __('Security check failed!', 'socialbet') );
  }

  $redirect = isset($_POST['_wp_http_referer']) ? $_POST['_wp_http_referer'] : '';

  $data['first_name'] = isset( $_POST['first_name'] ) ? $_POST['first_name'] : '';
  $data['last_name'] = isset( $_POST['last_name'] ) ? $_POST['last_name'] : '';
  $data['user_sex'] = $_POST['user_sex'];
  $data['user_birthday'] = "";
  if ( isset( $_POST['user_birthday']) ) {
    $bd = array();
    foreach( (array) $_POST['user_birthday'] as $bdpost ) {
      $bd[] = $bdpost;
    }
    unset( $bdpost );
    $data['user_birthday'] = implode('-', $bd );
  }

  $data['user_country'] = isset( $_POST['user_country'] ) ? $_POST['user_country'] : '';
  $data['user_city'] = isset( $_POST['user_city'] ) ? $_POST['user_city'] : '';
  $data['user_plan'] = isset( $_POST['user_plan'] ) ? $_POST['user_plan'] : '';
  $data['user_plan_cost'] = isset( $_POST['user_plan_cost'] ) ? $_POST['user_plan_cost'] : '';
  $data['user_subscription'] = isset( $_POST['user_subscription'] ) ? $_POST['user_subscription'] : '';
  $data['user_subscription_price'] = isset( $_POST['user_subscription_price'] ) ? $_POST['user_subscription_price'] : '';
  $data['user_subscription_bets'] = isset( $_POST['user_subscription_bets'] ) ? $_POST['user_subscription_bets'] : '';

  // create some check lists
  if ( empty( $data['first_name'] ) )
    $errors->add( 'firstname_required', __('Please enter your First name.', 'socialbet') );

  if ( empty( $data['last_name'] ) )
    $errors->add( 'lastname_required', __('Please enter your last name or surname.', 'socialbet') );

  if ( ( intval(date('Y')) - intval(date('Y', strtotime( $data['user_birthday'] ))) ) < 17 )
    $errors->add( 'cannot_access', __('Sorry, you must at least 17 years old to access this site.', 'socialbet') );

  if ( empty( $data['user_country'] ) )
    $errors->add( 'country_required', __('Please select a country where you live in.', 'socialbet') );

  if ( empty( $data['user_plan'] ) )
    $errors->add( 'selectplan', __('Please select a membership plan.', 'socialbet') );

  if ( 'premium' == $data['user_plan'] && empty( $data['user_plan_cost'] ) )
    $errors->add( 'selectcost', __('You have choose premium membership plan, please select a membership cost.', 'socialbet') );

  if ( 'paid' == $data['user_subscription'] && empty( $data['user_subscription_price'] ) )
    $errors->add( 'selectsubsprice', __('Please select a subscription price.', 'socialbet') );

  if ( 'paid' == $data['user_subscription'] && empty( $data['user_subscription_bets'] ) )
    $errors->add( 'selectsubsprice', __('Please select a bate values', 'socialbet') );

  if ( $errors->get_error_code() )
    return $errors;

  foreach( $data as $field => $value ) {
    update_user_meta( $current_user->ID, $field, $value );
  }
  unset($field);
  unset($value);

  $errors->add( 'message', esc_html__('Ваши настройки будут успешно сохранены!', 'socialbet'), 'message' );
  $user_data = get_socbet_usermeta( $current_user->ID );
  
  return $errors;
}


/**
 * User sent invitation
 *
 * @return void
 */
function socbet_user_sent_invitation() {
    global $wp_query, $current_user, $user_data;
    get_currentuserinfo();

    $errors = new WP_Error();

    if ( ! is_user_logged_in() ) {
        $redirect = esc_url( site_url('wp-login.php', 'login_post') );
        wp_safe_redirect( $redirect );
        exit(); 
    }

    if ( empty( $_POST['_wpsocbetsentinvitationnonce'] ) || ! wp_verify_nonce( $_POST['_wpsocbetsentinvitationnonce'], 'socbet-sent-invitation' ) ) {
        // we need to completely break all process if security check is failed!
        wp_die( __('Security check failed!', 'socialbet') );
    }

    if ( empty( $_POST['invite_email'] ) )
        $errors->add( 'email_required', esc_html__('Пожалуйста, введите адрес электронной почты.', 'socialbet') );

    if ( $errors->get_error_code() )
        return $errors;

    $email = sanitize_email( $_POST['invite_email'] );
    $process = socbet_sent_invitation_email( $email );

    if ( $process != '1' ) {

        switch ( $process ) {
            case '4':
                $errors->add( 'invalid_email', esc_html__('Пожалуйста, введите адрес электронной почты.', 'socialbet') );
                break;
            case '2':
                $errors->add( 'email_registered', esc_html__('Извините, электронной почты уже зарегистрирован как пользователь.', 'socialbet') );
                break;
            case '3':
                $errors->add( 'email_invited', esc_html__('К сожалению, адрес электронной почты уже приглашены.', 'socialbet') );
                break;
        }


    } else {
        $errors->add( 'message', esc_html__('Приглашение отправлено'), 'message' );
    }

    return $errors;

}

add_action( 'comment_form_before', 'socbet_comment_form_before', 99 );
function socbet_comment_form_before() {
  global $post;

  if ( $post->post_type == 'timeline' || $post->post_type == 'group-post' ) {
    ob_start();
  }
}

add_action( 'comment_form_top', 'socbet_comment_form_top', 1 );
function socbet_comment_form_top() {
  global $post;

  if ( $post->post_type == 'timeline' || $post->post_type == 'group-post' ) {
    $orig = ob_get_clean();
    echo '<div class="timeline-form-holder">' . "\n";
    echo '<form action="' . site_url( '/wp-comments-post.php' ) . '" method="post" id="timeline-form-'.get_the_ID().'" class="comment-form timeline-commentform-form" data-parentid="'.get_the_ID().'" data-backuri="'.get_permalink(get_the_ID()).'" novalidate>';
  }
}


function socbet_timeline_replies( $comment, $args, $depth ) {
  global $post, $current_user;
  get_currentuserinfo();

  $GLOBALS['comment'] = $comment;
  extract($args, EXTR_SKIP);
  
  $comment_user_data = get_socbet_usermeta( $comment->user_id );
  $comment_user_avatar = empty( $comment_user_data['avatar'] ) ? get_template_directory_uri() . '/assets/images/default_avatar.png' : $comment_user_data['avatar'];
  $comment_display_name = ( empty($comment_user_data['first_name']) && empty($comment_user_data['last_name']) ) ? $comment_user_data['nickname'] : $comment_user_data['first_name'] . ' ' . $comment_user_data['last_name'];
  ?>

  <div <?php comment_class(); ?> id="timeline-comment-<?php comment_ID() ?>">
    <div class="image-info-box pos-rel">
    <?php if ( $post->post_author == $current_user->ID || $comment->user_id == $current_user->ID ) { ?>
      <div class="close-abs hover">
        <span class="icon-close timeline-remove-comment" data-cid="<?php comment_ID() ?>"></span>
        <div class="hover-box">
          <?php esc_html_e('Удалить', 'socialbet'); ?>
          <span class="icon-arrowdropdown"></span>
        </div>
      </div>
      <form class="delete-comment-trash" id="delete-comment-trash-<?php comment_ID() ?>" data-timelineid="<?php print $comment->comment_post_ID ?>" action="" method="post">
        <?php wp_nonce_field( 'socbet-remove-comment-'.get_comment_ID(), '_socbetremovecomment'.get_comment_ID(), true, true ); ?>
        <input type="hidden" name="comment_id" value="<?php comment_ID() ?>" />
        <input type="hidden" name="comment_user_id" value="<?php print $comment->user_id; ?>" />
        <input type="hidden" name="comment_post_id" value="<?php print $comment->comment_post_ID; ?>" />
        <input type="hidden" name="action" value="socbet_move_comment_to_trash" />
      </form>
    <?php } ?>
      <div class="img-holder small">
        <a href="<?php echo get_author_posts_url($comment->user_id); ?>"><img src="<?php echo $comment_user_avatar; ?>" class="circle" alt="" /></a>
      </div>
      <div class="info-holder">
        <p><?php print $comment_display_name; ?></p>
        <p class="sub-info"><?php print socbet_time_diff( get_comment_time('U'), current_time('timestamp') ); ?></p>
      </div>
      <div class='comment-content'>
        <?php comment_text(); ?>
      </div>
    </div>

  <?php
}

add_action( 'comment_post', 'socbet_ajaxify_timeline_comments', 20, 2 );
function socbet_ajaxify_timeline_comments( $comment_ID, $comment_status ) {
  if ( ! empty( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) == 'xmlhttprequest' ) {

    switch( $comment_status ) {
      case '0':
        wp_notify_moderator( $comment_ID );

        $ret = array(
          'err' => false,
          'comment_id' => $comment_ID
          );
        break;

      case '1':
        wp_notify_postauthor( $comment_ID );

        $ret = array(
          'err' => false,
          'comment_id' => $comment_ID
          );
        break;

      default:
        $ret = array(
          'err' => 'yes'
          );
        break;
    }

    echo json_encode($ret);
    die();

  }
}



function socbet_first_poll_creation() {
  ob_start();
  ?>
  <div id="poll-creation">
    <div class="input-holder">
      <label><?php esc_html_e('Название опроса', 'socialbet'); ?></label>
      <div class="close"><span class="icon-close" id="remove-poll-creation"></span></div>
      <input type="text" class="wrt-p1" name="poll-name" value="" />
    </div>
    <label class="block"><?php esc_html_e('Варианты ответа', 'socialbet'); ?></label>
    <div class="input-holder special">
      <input type="text" class="wrt-p1" name="poll-options[]" value="" />
      <div class="close-abs"><span class="icon-close remove-poll-option"></span></div>
    </div>
    <div class="input-holder special">
      <input type="text" class="wrt-p1" name="poll-options[]" value="" />
      <div class="close-abs"><span class="icon-close remove-poll-option"></span></div>
    </div>
    <input type="text" class="wrt-p1" id="poll-add-op" name="poll-add-op" placeholder="<?php esc_attr_e('Добавить вариант', 'socialbet'); ?>" value="" />
    <input type="hidden" name="use_poll" value="1" />
  </div>
  <?php
  $html = ob_get_clean();
  return esc_html( $html );
}


function sobcet_poll_add_option_field() {
  ob_start();
  ?>
    <div class="input-holder special">
      <input type="text" class="wrt-p1" name="poll-options[]" value="" />
      <div class="close-abs"><span class="icon-close remove-poll-option"></span></div>
    </div>
  <?php
  $html = ob_get_clean();
  return esc_html( $html );
}


function socbet_get_poll_count( $pid ) {

  $poller = get_post_meta( $pid, '_socbet_poll_results', true );
  if ( empty($poller) ) {
    return 0;
  }

  return count($poller);
}


function socbet_get_poll_results( $pid ) {

  $results = get_post_meta( $pid, '_socbet_poll_results', true );
  if ( ! is_array($results) )
    return false;

  $break_res = array();

  foreach ( $results as $res ) {
    $restext = $res;
    $break_res[$restext][] = $res;
  }
  unset($res);

  return $break_res;
}


function get_timeline_likes_count( $pid ) {

  $results = get_post_meta( $pid, '_socbet_liked', true );
  if ( ! is_array($results) )
    return '0';

  return count( $results );
}


function get_timeline_dislikes_count( $pid ) {

  $results = get_post_meta( $pid, '_socbet_disliked', true );
  if ( ! is_array($results) )
    return '0';

  return count( $results );
}

/**
 * Process user joined with a group
 * will run on 'get_header' (before header)
 *
 * @return void
 */
add_action( 'get_header', 'socbet_process_user_join_group' );
function socbet_process_user_join_group() {
  global $wp_query, $current_user;
  get_currentuserinfo();

  if ( isset($_GET['join_group']) && $_GET['join_group'] ) {
    if ( !is_tax('group_name'))
      return;

    if ( !is_user_logged_in() ) {
      wp_redirect( esc_url(wp_login_url()) );
      exit;
    }

    $group_id = $wp_query->get_queried_object_id();
    if ( !$group_id || user_is_member_of($group_id) )
      return;

    $group_data = get_option( 'taxonomy_meta_'.$group_id );
    if ( !isset($group_data['subscriber']) )
      return;

    $group_data['subscriber'] = array_merge( array($current_user->ID), $group_data['subscriber'] );
    update_option( 'taxonomy_meta_'.$group_id, $group_data );

    $group_joined = get_user_meta( $current_user->ID, 'group_joined', true );
    if ( is_array($group_joined) ) {
      $group_joined = array_merge( array($group_id), $group_joined );
    } else {
      $group_joined = array($group_id);
    }

    update_user_meta( $current_user->ID, 'group_joined', $group_joined, get_user_meta( $current_user->ID, 'group_joined', true ) );

    $back = get_term_link($group_id, 'group_name');
    wp_redirect( esc_url($back) );
    exit;

  }
}

/**
 * Process likes and dislikes on timeline
 * will run on 'get_header' (before header)
 *
 * @return void
 */
add_action( 'get_header', 'socbet_process_likes_dislikes_timeline' );
function socbet_process_likes_dislikes_timeline() {
  global $current_user;
  get_currentuserinfo();

  if ( is_singular('timeline') || is_singular('group-post') ) {


    if ( ! is_user_logged_in() )
      return;

    if ( ! isset($_GET['pid']) )
      return;

    if ( ! isset($_GET['taction']) )
      return;

    $postid = intval( $_GET['pid'] );
    $action = $_GET['taction'];
    $likes_data = get_post_meta( $postid, '_socbet_liked', true );
    $dislikes_data = get_post_meta( $postid, '_socbet_disliked', true );

    if ( $action == 'liked' ) {
      
      if ( is_array($likes_data) && array_key_exists($current_user->ID, $likes_data) )
        return;

      // user previously dislike this timeline, got to remove it first
      if ( is_array($dislikes_data) && array_key_exists($current_user->ID, $dislikes_data) ) {
        unset( $dislikes_data[$current_user->ID] );
        update_post_meta( $postid, '_socbet_disliked', $dislikes_data, get_post_meta( $postid, '_socbet_disliked', true ) );
      }

      if ( is_array($likes_data) ) {
        $new = array( $current_user->ID => $current_user->ID );
        $new_likes_data = $likes_data + (array) $new;
      } else {
        $new_likes_data = array( $current_user->ID => $current_user->ID );
      }

      update_post_meta( $postid, '_socbet_liked', $new_likes_data, get_post_meta( $postid, '_socbet_liked', true ) );
      
      wp_redirect( get_permalink( $postid ) );
      exit();

    } else if ( $action == 'disliked' ) {
      
      if ( is_array($dislikes_data) && array_key_exists($current_user->ID, $dislikes_data) )
        return; 

      // user previously like this timeline, got to remove it first
      if ( is_array($likes_data) && array_key_exists($current_user->ID, $likes_data) ) {
        unset( $likes_data[$current_user->ID] );
        update_post_meta( $postid, '_socbet_liked', $likes_data, get_post_meta( $postid, '_socbet_liked', true ) );
      }

      if ( is_array($dislikes_data) ) {
        $new = array( $current_user->ID => $current_user->ID );
        $new_dislikes_data = $dislikes_data + (array) $new;
      } else {
        $new_dislikes_data = array( $current_user->ID => $current_user->ID );
      }

      update_post_meta( $postid, '_socbet_disliked', $new_dislikes_data, get_post_meta( $postid, '_socbet_disliked', true ) );
      
      wp_redirect( get_permalink( $postid ) );
      exit();  
    }
  }
}


add_action( 'get_header', 'socbet_marked_messages_read' );
function socbet_marked_messages_read() {
    global $wp_query, $current_user;
    get_currentuserinfo();

    if ( is_own_profile() && is_socbet_user_settings_page() == 'moi-soobshcheniya' ) {

        require_once( get_template_directory() . '/inc/class-socbet-messages.php' );
        $user_messages = new Socbet_Umessage();

        if ( isset( $wp_query->query_vars['dialog'] ) && ! empty($wp_query->query_vars['dialog']) ) {
            $msg_id = intval( $wp_query->query_vars['dialog'] );
            $det = $user_messages->get_details( $msg_id );
            if ( (int) $det->user_id_to == $current_user->ID && $det->status == '1'  ) {
                $user_messages->marked_read( $msg_id );
            }

            if ( count_unread_messages( $msg_id ) ) {
                $user_messages->marked_reply_read( $msg_id, $current_user->ID );
            }
        }

        if ( isset( $_GET['remove_message'] ) ) {
            $msg_to_remove = intval( $_GET['remove_message'] );
            $redirect = get_socbet_user_dashboard_url( $current_user->ID, _transliteration_process( esc_html( urldecode('мои-сообщения') ), '?', 'ru' ) );

            if ( !isset($_GET['msgdelkey']) || !wp_verify_nonce($_GET['msgdelkey'], 'socbet_remove_msg') ) {
                wp_redirect( $redirect );
                exit();
            }

            $user_messages->remove_message( $msg_to_remove );      
            wp_redirect( $redirect );
            exit();   
        }

        if ( isset( $_GET['reactivate_message'] ) ) {
            $msg_to_remove = intval( $_GET['reactivate_message'] );
            $redirect = get_socbet_user_dashboard_url( $current_user->ID, _transliteration_process( esc_html( urldecode('мои-сообщения') ), '?', 'ru' ) );

            if ( !isset($_GET['msgreactivatekey']) || !wp_verify_nonce($_GET['msgreactivatekey'], 'socbet_reactivate_msg') ) {
                wp_redirect( $redirect );
                exit();
            }

            $user_messages->reactivate_message( $msg_to_remove );      
            wp_redirect( $redirect );
            exit();   
        }
       
    } else if ( is_own_profile() && is_socbet_user_settings_page() == 'moi-nastroyki-chernyy-spisok' ) {
      if ( isset($_GET['unblock']) ) {

          $unblock = intval( $_GET['unblock'] );
          $redirect = get_socbet_user_dashboard_url( $current_user->ID, 'moi-nastroyki-chernyy-spisok' );

          if ( !isset($_GET['unblockusrkey']) || !wp_verify_nonce($_GET['unblockusrkey'], 'socbet_unblock_user') ) {
              wp_redirect( $redirect );
              exit();
          }

          user_change_block_status( $current_user->ID, $unblock, 'false' );
          wp_redirect( $redirect );
          exit(); 
      
      } else if ( isset($_GET['block']) ) {

          $block = intval( $_GET['block'] );
          $redirect = get_socbet_user_dashboard_url( $current_user->ID, 'moi-nastroyki-chernyy-spisok' );

          if ( !isset($_GET['blockusrkey']) || !wp_verify_nonce($_GET['blockusrkey'], 'socbet_block_user') ) {
              wp_redirect( $redirect );
              exit();
          }

          user_change_block_status( $current_user->ID, $block, 'true' );
          wp_redirect( $redirect );
          exit(); 
      }
    }
}


function email_is_already_invited( $email ) {
    global $wpdb;

    $table = $wpdb->prefix . 'socbet_invitation';
    $row = $wpdb->get_row( $wpdb->prepare( "SELECT ID FROM $table WHERE email = %s", sanitize_email($email) ) );

    if ( $row )
        return $row->ID;

    return false;
}


function socbet_sent_invitation_email( $email ) {
    global $SocBet_Theme, $wpdb, $wp_hasher, $current_user;
    get_currentuserinfo();

    if ( !is_user_logged_in() ) {
        wp_redirect( esc_url( wp_login_url() ) );
        exit(); 
    }

    if( ! is_email( sanitize_email($email) ) ) {
        return '4';
    }

    // too famous? already registered user cannot recieve an invitation
    if ( email_exists( sanitize_email($email) ) ) {
        return '2';
    }

    // cannot sent double invitation
    if ( email_is_already_invited( sanitize_email($email) ) ) {
        return '3';
    }

    $key = wp_generate_password( 20, false );
    if ( empty( $wp_hasher ) ) {
        require_once ABSPATH . WPINC . '/class-phpass.php';
        $wp_hasher = new PasswordHash( 8, true );
    }
    $hashed = $wp_hasher->HashPassword( $key );

    $table = $wpdb->prefix . 'socbet_invitation';

    $wpdb->insert( $table,
        array(
            'email' => sanitize_email($email),
            'invitation_date' => date_i18n("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s"))),
            'invitation_by' => $current_user->ID,
            'invitation_key' => $hashed,
            'status' => '0'
            ),
        array('%s','%s','%d','%s','%d'));

    $mailer = $SocBet_Theme->mailer();
    $emailBody = 'Привет,' . "\n\n" . 'Приглашаем Вас присоединиться к SocialBet, утвердить приглашение, пожалуйста, нажмите на ссылку: ' . "\n\n" . '{confirmation_link}' . "\n\n" . 'После того, как ваша регистрация будет завершена, вы можете войти в свой приборной панели!' . "\n\n" . 'С уважением';

    $mailer->new_invitation_email( $emailBody, $key, sanitize_email($email) );

    return '1';
}



/**
 * Not exactly speed boost, all will depend the server config ^_^
 * We will adds:
 * - mod_deflate to compress the files with gzip
 * - for the poor IE folk, Use ChromeFrame if it's installed
 * - Allow access from all domains for webfonts. 
 * - Expires headers (for better cache control)
 * - Stop screen flicker in IE on CSS rollovers
 * but yes, it will more faster
 */
function socbet_admin_speed_boost() {
    ob_start(); 
    ?>

# ================ START OPTIMATION ==================
# Force the latest IE version, in various cases when it may fall back to IE7 mode
# github.com/rails/rails/commit/123eb25#commitcomment-118920
# Use ChromeFrame if it's installed for a better experience for the poor IE folk
<IfModule mod_headers.c>
  Header set X-UA-Compatible "IE=Edge,chrome=1"
  # mod_headers can't match by content-type, but we don't want to send this header on *everything*...
  <FilesMatch "\.(appcache|crx|css|eot|gif|htc|ico|jpe?g|js|m4a|m4v|manifest|mp4|oex|oga|ogg|ogv|otf|pdf|png|safariextz|svg|svgz|ttf|vcf|webm|webp|woff|xml|xpi)$">
    Header unset X-UA-Compatible
  </FilesMatch>
</IfModule>

# Allow access from all domains for webfonts.
<IfModule mod_headers.c>
  <FilesMatch "\.(eot|font.css|otf|ttc|ttf|woff)$">
    Header set Access-Control-Allow-Origin "*"
  </FilesMatch>
</IfModule>

# Gzip compression
<IfModule mod_deflate.c>
    SetOutputFilter DEFLATE
  # Force deflate for mangled headers developer.yahoo.com/blogs/ydn/posts/2010/12/pushing-beyond-gzipping/
  <IfModule mod_setenvif.c>
    <IfModule mod_headers.c>
      SetEnvIfNoCase ^(Accept-EncodXng|X-cept-Encoding|X{15}|~{15}|-{15})$ ^((gzip|deflate)\s*,?\s*)+|[X~-]{4,13}$ HAVE_Accept-Encoding
      RequestHeader append Accept-Encoding "gzip,deflate" env=HAVE_Accept-Encoding
      Header append Vary User-Agent
    </IfModule>
  </IfModule>

  # Compress all output labeled with one of the following MIME-types
  # (for Apache versions below 2.3.7, you don't need to enable mod_filter
  # and can remove the '<IfModule mod_filter.c>' and '</IfModule>' lines as
  # 'AddOutputFilterByType' is still in the core directives)
  <IfModule mod_filter.c>
    AddOutputFilterByType DEFLATE application/atom+xml \
                                  application/javascript \
                                  application/x-javascript \
                                  application/json \
                                  application/rss+xml \
                                  application/vnd.ms-fontobject \
                                  application/x-font-ttf \
                                  application/xhtml+xml \
                                  application/xml \
                                  font/opentype \
                                  image/svg+xml \
                                  image/x-icon \
                                  text/css \
                                  text/html \
                                  text/javascript \
                                  text/plain \
                                  text/x-component \
                                  text/xml
  </IfModule>

    BrowserMatch ^Mozilla/4 gzip-only-text/html
    BrowserMatch ^Mozilla/4\.0[678] no-gzip
    BrowserMatch \bMSIE !no-gzip !gzip-only-text/html
</IfModule>

# Expires headers (for better cache control)
<IfModule mod_expires.c>
  ExpiresActive on

# Perhaps better to whitelist expires rules? Perhaps.
  ExpiresDefault                          "access plus 1 month"

# cache.appcache needs re-requests in FF 3.6
  ExpiresByType text/cache-manifest       "access plus 0 seconds"

# Your document html
  ExpiresByType text/html                 "access plus 0 seconds"

# Data
  ExpiresByType application/json          "access plus 0 seconds"
  ExpiresByType application/xml           "access plus 0 seconds"
  ExpiresByType text/xml                  "access plus 0 seconds"

# Feed
  ExpiresByType application/atom+xml      "access plus 1 hour"
  ExpiresByType application/rss+xml       "access plus 1 hour"

# Favicon (cannot be renamed)
  ExpiresByType image/x-icon              "access plus 1 week"

# Media: images, video, audio
  ExpiresByType audio/ogg                 "access plus 1 month"
  ExpiresByType image/gif                 "access plus 1 month"
  ExpiresByType image/jpeg                "access plus 1 month"
  ExpiresByType image/png                 "access plus 1 month"
  ExpiresByType video/mp4                 "access plus 1 month"
  ExpiresByType video/ogg                 "access plus 1 month"
  ExpiresByType video/webm                "access plus 1 month"

# Stop screen flicker in IE on CSS rollovers
    BrowserMatch "MSIE" brokenvary=1
    BrowserMatch "Mozilla/4.[0-9]{2}" brokenvary=1
    BrowserMatch "Opera" !brokenvary
    SetEnvIf brokenvary 1 force-no-vary

# HTC files  (css3pie)
  ExpiresByType text/x-component          "access plus 1 month"

# Webfonts
  ExpiresByType application/vnd.ms-fontobject "access plus 1 month"
  ExpiresByType application/x-font-ttf    "access plus 1 month"
  ExpiresByType application/x-font-woff   "access plus 1 month"
  ExpiresByType font/opentype             "access plus 1 month"
  ExpiresByType image/svg+xml             "access plus 1 month"

# CSS and JavaScript
  ExpiresByType application/javascript    "access plus 1 year"
  ExpiresByType text/css                  "access plus 1 year"

</IfModule>

# ETag removal
<IfModule mod_headers.c>
  Header unset ETag
</IfModule>
# Since we're sending far-future expires, we don't need ETags for static content.
# developer.yahoo.com/performance/rules.html#etags
FileETag None
# ================ END OPTIMATION ==================
<?php
    $compress = ob_get_clean();
    return $compress;
}
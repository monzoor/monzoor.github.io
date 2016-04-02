<?php
/**
 * custom column on post type table
 */

/** CUSTOM COLUMNS */
add_action( 'admin_init', 'socbet_admin_trigger_custom_columns' );
function socbet_admin_trigger_custom_columns() {
    if ( post_type_exists('event') ) {
        add_filter( 'manage_edit-event_columns', 'socbet_cpt_event_edit_columns' );
    }

    if ( post_type_exists('event') ) {
        add_filter( 'manage_edit-competition_columns', 'socbet_cpt_competition_edit_columns' );
    }

    add_action( 'manage_posts_custom_column', 'socbet_cpt_event_custom_columns' );
}

/**
 * Event post type columns
 *
 * @return void
 */
function socbet_cpt_event_edit_columns($columns) {
	$columns = array(
		"cb" => "<input type=\"checkbox\" />",
		"title" => __('Title', 'socialbet'),
        "taxonomy-sport_type" => __('Sport', 'socialbet'),
        "event_date" => __('Event Date', 'socialbet'),
        "market" => __('Event Markets', 'socialbet'),
		"tips" => __('Tips', 'socialbet'),
		"comments" => '<span class="vers"><div title="' . esc_attr__( 'Comments', 'socialbet' ) . '" class="comment-grey-bubble"></div></span>',
        "date" => __('Date', 'socialbet')
	);

	return $columns;
}

/**
 * Compeititon post type columns
 *
 * @return void
 */
function socbet_cpt_competition_edit_columns($columns) {
    $columns = array(
        "cb" => "<input type=\"checkbox\" />",
        "title" => __('Title', 'socialbet'),
        "taxonomy-competition_type" => __('Competition Type', 'wip'),
        "competition_price" => __('Price', 'socialbet'),
        "ending_date" => __('End', 'socialbet'),
        "prize" => __('Total Prize', 'socialbet'),
        "usr" => __('Participants', 'socialbet'),
        "comments" => '<span class="vers"><div title="' . esc_attr__( 'Comments', 'socialbet' ) . '" class="comment-grey-bubble"></div></span>',
        "date" => __('Date', 'socialbet')
    );

    return $columns;
}

/**
 * Custom columns output
 *
 * @return void
 */
function socbet_cpt_event_custom_columns($column) {
    global $post, $wpdb;

    switch($column) {

        case "event_date":

            $ev_date = get_post_meta( $post->ID, '_'.SOCIALBET_NAME.'_event_datetime', true );

            if ( current_time('timestamp') < strtotime($ev_date) ) {
                echo '<p><time>' . sprintf(__('%s from now', 'socialbet'), human_time_diff( strtotime($ev_date), current_time('timestamp') ) ) . '</time></p>';
            } else {
                echo '<p><time>' . sprintf(__('%s ago', 'socialbet'), human_time_diff( strtotime($ev_date), current_time('timestamp') ) ) . '</time></p>';
            }

            echo '( '.date('dS F Y \a\t h:i A', strtotime($ev_date) ).' )';
            break;

        case "market":

           $count_markets = $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->socbet_market} WHERE `event_id` = {$post->ID}" );

             echo '<p>';

            ( $count_markets > 1 || $count_markets == 0 ) ? printf( __('%d markets', 'socialbet'), $count_markets ) : printf( __('%d market', 'socialbet'), $count_markets );
                
            echo '</p>';

            printf( __('<a href="%s" class="button button-primary">View All</a>', 'socialbet'), admin_url('edit.php?post_type=event&page=show-markets&event='.$post->ID) );
            break;

        case "tips":

            $tips_cpt_name = get_post_meta( $post->ID, '_cpt_tip_name', true );

            if ( ! post_type_exists( $tips_cpt_name ) )  {
                
                print __('Something wrong here!', 'socialbet');

            } else {

                $count = $count_posts = wp_count_posts( $tips_cpt_name )->publish;
                echo '<p>';

                ( $count > 1 || $count == 0 ) ? printf( __('%d tips', 'socialbet'), $count ) : printf( __('%d tip', 'socialbet'), $count );
                
                echo '</p>';
                printf( __('<a href="%1$s" class="button button-primary">Add New</a> <a href="%2$s" class="button button-primary">View All</a></p>', 'socialbet'), admin_url('post-new.php?post_type='.$tips_cpt_name) , admin_url('edit.php?post_type='.$tips_cpt_name) );
            
            }

            break;

        case "competition_price":

            $price = get_post_meta( $post->ID, '_'.SOCIALBET_NAME.'_competition_price', true );
            echo ( empty($price) || intval($price) < 1 ? esc_html_e('бесплатно', 'socialbet') : $price );

            break;

        case "ending_date":

            $edate = get_post_meta( $post->ID, '_'.SOCIALBET_NAME.'_competition_end', true );
            echo date( 'dS F Y \a\t h:i A', strtotime($edate) );

            break;

        case "prize":
            
            $prize = get_post_meta( $post->ID, '_'.SOCIALBET_NAME.'_competition_prize', true );
            echo $prize;

            break;

        case "usr":

            //will figure it our later
            $count = get_participants_number( $post->ID );
            printf( __('%d users', 'socialbet'), $count );

            break;
    }
}
<?php
/**
 * Comments template for user timelines
 *
 * @ver 1.0
 */
if ( isset($comment) )
	unset( $comment );

global $group_id;
?>

<div id="timeline-comments-<?php the_ID(); ?>" class="timelines-comments-area">

<?php

if ( get_comments_number( get_the_ID() ) > 1 ) {
	?>
	<div class="col-wp brand-light-blue-bg more-comment">
		<?php if ( isset($_GET['showcomments']) && $_GET['showcomments'] ) { ?>
		<a class="tm-get-all-comments" id="tm-get-all-comments-<?php the_ID(); ?>" data-postid="<?php the_ID(); ?>" href="<?php echo get_permalink(); ?>"><?php esc_html_e('Скрыть комментарии', 'socialbet'); ?></a>
		<?php } else { ?>
		<a class="tm-get-all-comments all" id="tm-get-all-comments-<?php the_ID(); ?>" data-postid="<?php the_ID(); ?>" href="<?php echo get_permalink(); ?>"><?php printf( __('Показать все комментарии (<span class="timelines-comments-number-count-%d">%d</span>)', 'socialbet'), get_the_ID(), get_comments_number( get_the_ID() ) ); ?></a>
		<?php } ?>
	</div>
	<?php
}

echo '<div id="timeline-comment-lists-'.get_the_ID().'">' . "\n";

if ( have_comments() ) :

	echo '<div class="col-wp brd-top">' . "\n";

	// for ajax purpose to get all comments
	if ( isset($_GET['showcomments']) && $_GET['showcomments'] ) {

		wp_list_comments( array(
			'style' => 'div',
			'callback' => 'socbet_timeline_replies',
			'type' => 'comment',
			'per_page'=> -1
		) );

	} else {

		wp_list_comments( array(
			'style' => 'div',
			'callback' => 'socbet_timeline_replies',
			'type' => 'comment',
			'reverse_top_level' => true,
			'per_page'=> 1,
			'page' => 1
		), get_comments(array('status' => 'approve', 'post_id'=>get_the_ID())) );

	}

	echo '</div>' . "\n";

endif;

echo '</div>' . "\n";

if ( is_user_logged_in() ):

	if ( !empty($group_id) ) {

		if ( user_is_member_of( $group_id ) ) {

			$commenter = wp_get_current_commenter();
			$comment_form = array(
				'id_form' => 'timeline-commentform-'.get_the_ID(),
				'id_submit' => 'timeline-commentform-submit-'.get_the_ID(),
				'title_reply'          => '',
				'title_reply_to'       => '',
				'comment_notes_before' => '',
				'comment_notes_after'  => '',
				'label_submit'  => esc_html__( 'отправить', 'socialbet' ),
				'logged_in_as'  => '',
				'comment_field' => '<div class="col-wop"><div class="arrow_box"><textarea class="small" placeholder="'. esc_attr__('Ваш комментарий...', 'socialbet') .'" name="comment" aria-required="true"></textarea></div></div>'
			);
			comment_form( $comment_form );

		}

	} else {

		$commenter = wp_get_current_commenter();
		$comment_form = array(
			'id_form' => 'timeline-commentform-'.get_the_ID(),
			'id_submit' => 'timeline-commentform-submit-'.get_the_ID(),
			'title_reply'          => '',
			'title_reply_to'       => '',
			'comment_notes_before' => '',
			'comment_notes_after'  => '',
			'label_submit'  => esc_html__( 'отправить', 'socialbet' ),
			'logged_in_as'  => '',
			'comment_field' => '<div class="col-wop"><div class="arrow_box"><textarea class="small" placeholder="'. esc_attr__('Ваш комментарий...', 'socialbet') .'" name="comment" aria-required="true"></textarea></div></div>'
		);
		comment_form( $comment_form );
	}

endif;
?>

</div>
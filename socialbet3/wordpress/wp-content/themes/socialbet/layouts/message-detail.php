<?php
/**
 * Message details/dialogue
 * 
 * @ver 1.0
 */

global $wp_query, $profile_user, $user_data, $SocBet_Theme, $user_avatar;

$display_name_msg = ( empty($user_data['first_name']) && empty($user_data['last_name']) ) ? $profile_user->display_name : $user_data['first_name'] . ' ' . $user_data['last_name'];

require_once( get_template_directory() . '/inc/class-socbet-messages.php' );
$user_messages = new Socbet_Umessage();
$msg = $user_messages->get_details( (int) $wp_query->query_vars['dialog'] );
if ( ! $msg ) {
	esc_html_e('Не можете найти данные', 'socialbet');
	return;
}

$as_receipt = false;
if ( (int) $msg->user_id == $profile_user->ID ) {
	$receipt = (int) $msg->user_id_to;
} else {
	$receipt = (int) $msg->user_id;
	$as_receipt = true;
}

$r_data = get_socbet_usermeta( $receipt );
$r_avatar = empty( $r_data['avatar'] ) ? get_template_directory_uri() . '/assets/images/default_avatar.png' : $r_data['avatar'];
$r_name_msg = ( empty($r_data['first_name']) && empty($r_data['last_name']) ) ? $r_data['nicename'] : $r_data['first_name'] . ' ' . $r_data['last_name'];
?>

	<h1 class="fl wd-auto zero-border"><?php print $r_name_msg; ?></h1>
	<div class="clear"></div>
	<div class="profile-dialogue-wrapper mg-top" id="profile-dialogue-wrapper">

		<div class="col-wp npd-top" id="msg-<?php echo $msg->id; ?>">
			<div class="image-info-box mg-top">
				<div class="img-holder">
			 		<img src="<?php print ( $as_receipt ? $r_avatar : $user_avatar ); ?>" class="circle">
			 	</div>
			 	<div class="info-holder dialogue-content">
			 		<div class="sender-name"><?php print ( $as_receipt ? $r_name_msg : $display_name_msg ); ?></div>
			 		
			 		<?php print wpautop( stripslashes($msg->message) ); ?>
			 		
			 		<?php if ( $msg->attachment_ids != "" ) {
			 			$attch_msg = explode(",", trim($msg->attachment_ids) );
			 			foreach ( $attch_msg as $am ) {
			 			?>
			 			<img class="mg-top dialogue-img" src="<?php echo wp_get_attachment_url( (int) $am ); ?>"/>
			 		<?php
			 			}
					} ?>
			 	</div>
			 	<p class="sub-info fr nmg"><?php print date('d.m.y', strtotime($msg->date) ); ?></p>
			</div>
		</div>

		<?php
		$replies = $user_messages->get_replies( (int) $wp_query->query_vars['dialog'] );
		if ( $replies ) {
			foreach ( $replies as $reply ) {
		?>

		<div class="col-wp npd-top" id="reply-<?php echo $reply->id; ?>">
			<div class="image-info-box mg-top">
				<div class="img-holder">
			 		<img src="<?php print ( (int) $reply->user_id == $receipt ? $r_avatar : $user_avatar ); ?>" class="circle">
			 	</div>
			 	<div class="info-holder dialogue-content">
			 		<div class="sender-name"><?php print ( (int) $reply->user_id == $receipt ? $r_name_msg : $display_name_msg ); ?></div>
			 		
			 		<?php print wpautop( stripslashes($reply->message) ); ?>
			 		
			 		<?php 
			 		if ( $reply->attachment_ids != "" ) { 
			 			$attch_rep = explode(",", trim($reply->attachment_ids) );
			 			foreach ( $attch_rep as $ar ) {
			 			?>
			 			<img class="mg-top dialogue-img" src="<?php echo wp_get_attachment_url( (int) $ar ); ?>"/>
			 		<?php
			 			}
			 		} 
			 		?>
			 	</div>
			 	<p class="sub-info fr nmg"><?php print date('d.m.y', strtotime($reply->date) ); ?></p>
			</div>
		</div>

		<?php 
			} 
			unset($reply);
		} ?>

	</div>
	<?php // Reply form 
	if ( $msg->status != '3' ) {
	?>
	<div class="profile-dialogue-wrapper no-bg zero-border">
		<div class="col-wp npd-top">
			<div class="image-info-box mg-top">
				<div class="img-holder">
			 		<img src="<?php echo $user_avatar; ?>" class="circle">
			 	</div>
			 	<div class="info-holder">
			 	<form id="form-ajx-msg-reply" method="post">
			 		<?php wp_nonce_field( 'socbet-message-reply', '_socbetmsgreplynonce', true, true ); ?>
			 		<div class="talkbubble">
			 			<textarea name="message-content"></textarea>
			 		</div>
			 		<div class="image-holder" id="msg-upload-holder"></div>
			 		<input type="hidden" name="user_id" value="<?php echo esc_attr( $profile_user->ID ); ?>" />
			 		<input type="hidden" name="message_id" value="<?php echo esc_attr( $msg->id ); ?>" />
			 		<input type="hidden" name="action" value="socbet_post_message_reply" />
			 		<div class="fill-balance fl" id="trigger-msg-reply">
						<?php esc_html_e('отправить', 'socialbet'); ?>
					</div>
				</form>
					<div class="photo-uoload brand-blue fr timeline-upload-trigger">
						<span class="icon-photo fl"></span>
						<p class="b fl brand-blue"><?php esc_html_e('Фотография', 'socialbet'); ?></p>
					</div>
			 	</div>
			 	<div class="img-holder fr pdw-fr t-d-view">
			 		<img src="<?php echo $r_avatar; ?>" class="circle">
			 	</div>
			</div>
			<form class="hdn-form-ajx" id="form-ajx-tlf" method="post" enctype="multipart/form-data">
				<?php wp_nonce_field( 'socbet-timeline-files', '_socbettimelinefilesnonce', true, true ); ?>
				<input name="socbet_timelinefiles_upload" type="file" />
				<input name="action" type="hidden" value="socbet_timelines_files" />
			</form>
		</div>
	</div>
	<?php
	}
	?>
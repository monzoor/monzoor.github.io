<?php
/**
 * translation : My Messages/Mailbox
 * @ver 1.0
 */

global $wp_query, $profile_user, $user_data, $SocBet_Theme, $user_avatar;

$display_name_msg = ( empty($user_data['first_name']) && empty($user_data['last_name']) ) ? $profile_user->display_name : $user_data['first_name'] . ' ' . $user_data['last_name'];

if ( isset($wp_query->query_vars['dialog']) ) {
	get_template_part('layouts/message', 'detail' );
	return;
}

require_once( get_template_directory() . '/inc/class-socbet-messages.php' );
$user_messages = new Socbet_Umessage();
$messages = $user_messages->message_query();
?>

	<h1><?php esc_html_e('Мои сообщения', 'socialbet'); ?><?php if ( $ttl_message_count = count_unread_messages('', true) ) { ?> <span>+<?php echo $ttl_message_count; ?></span><?php } ?></h1>
	<div class="my-message-wrapper mg-top">

	<?php 
	if ( $messages ) { 
		foreach ( $messages as $msg ) {
		?>
		<div class="white-bg pos-rel message-item" id="message-<?php echo $msg->id; ?>">
			<img class="circle fl" src="<?php echo $user_avatar; ?>">
			<div class="name-box fl pos-rel">
				<div class="center">
					<p class="font14 b"><?php print $display_name_msg; ?></p>
					<p class="placeholder-color"><?php print socbet_time_diff( mysql2date('U', $msg->date, false), current_time('timestamp') ); ?></p>
				</div>
			</div>
			<div class="message fl">
			<?php if ( $msg->status == '3' ) { ?>
				<p><?php esc_html_e('Диалог удален', 'socialbet'); ?></p>
			<?php } else { ?>
				<?php
				$message_content = stripslashes( $msg->message );
				if ( (int) $msg->user_id !== $profile_user->ID ) {
					$sender_data = get_socbet_usermeta( $msg->user_id );
					$sender_avatar = empty( $sender_data['avatar'] ) ? get_template_directory_uri() . '/assets/images/default_avatar.png' : $sender_data['avatar'];
					$message_content = '<img class="circle fl" src="'.$sender_avatar.'" align="left">' . $message_content;
				}
				$message_content = '<a href="'.socbet_get_dialog_url($msg->id).'">' . $message_content . '</a>';
				print wpautop( $message_content ); 
				?>
			<?php } ?>
			</div>
			<?php if ( $msg->status == '3' ) { ?>
			<div class="gray-overlay pos-abs"></div>
			<a href="<?php echo wp_nonce_url( add_query_arg( array('reactivate_message'=>$msg->id) , get_socbet_user_dashboard_url( $profile_user->ID, _transliteration_process( esc_html( urldecode('мои-сообщения') ), '?', 'ru' ) ) ), 'socbet_reactivate_msg', 'msgreactivatekey' ); ?>" class="dark-gray pos-abs reactivate font12" data-message="<?php print $msg->id; ?>"><u><?php esc_html_e('Восстановить', 'socialbet'); ?></u></a>
			<?php } else { ?>

				<?php if ( $message_count = count_unread_messages( $msg->id ) ) { ?>
				<div class="circle-box fr hover-hd">
					<p class="circle white brand-red-bg font20">+<?php print $message_count; ?></p>
				</div>
				<?php } ?>
			<div class="circle-box fr cls hover-sw">
				<a href="<?php echo wp_nonce_url( add_query_arg( array('remove_message'=>$msg->id) , get_socbet_user_dashboard_url( $profile_user->ID, _transliteration_process( esc_html( urldecode('мои-сообщения') ), '?', 'ru' ) ) ), 'socbet_remove_msg', 'msgdelkey' ); ?>"><span class="icon-close placeholder-color2 font14 remove-message" data-message="<?php print $msg->id; ?>"></span></a>
			</div>
			<?php } ?>
		</div>
	<?php
		}
	}
	?>
	</div>
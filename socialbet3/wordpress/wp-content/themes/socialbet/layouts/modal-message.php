<?php
/**
 * Send message modal box template
 */

global $wp_query, $profile_user, $user_data, $user_avatar, $current_user;
get_currentuserinfo();
$display_name = ( empty($user_data['first_name']) && empty($user_data['last_name']) ) ? $profile_user->display_name : $user_data['first_name'] . ' ' . $user_data['last_name'];
?>

<!-- Send message -->
<div class="md-modal md-effect-1 send-message" id="modal-sent-message">
	<div class="md-content">
		<div class="header">
			<div class="img-holder small">
		 		<img src="<?php echo $user_avatar; ?>" class="circle">
		 	</div>
			<div class="close-abs no-bg"><span class="icon-close brand-blue-bg white md-close"></span></div>
			<h1 class="font30 white"><?php esc_html_e('Новое сообщение', 'socialbet'); ?></h1>
		</div>
		<div class="infos col-wp medium-gray-bg">
			<p class="font14 b fl"><?php printf( esc_html__('Получатель: %s', 'socialbet'), $display_name ); ?></p>
			<p class="fr font14"><u><a href="#"><?php printf( esc_html__('Перейти к диалогу с %s', 'socialbet'), $display_name ); ?></a></u></p>
			<div class="clear"></div>
			<form action="" id="form-ajx-msg-reply" method="post">
				<?php wp_nonce_field( 'socbet-new-message', '_socbetnewmsgnonce', true, true ); ?>
				<label class="full-width font14" for=""><?php esc_html_e('Сообщение', 'socialbet'); ?></label>
				<textarea class="white-bg" name="message-content"></textarea>
				<div class="image-holder" id="msg-upload-holder"></div>
		 		<input type="hidden" name="user_id_from" value="<?php echo esc_attr( $current_user->ID ); ?>" />
		 		<input type="hidden" name="user_id_to" value="<?php echo esc_attr( $profile_user->ID ); ?>" />
		 		<input type="hidden" name="action" value="socbet_post_new_message" />
				<div class="fill-balance fl" id="trigger-msg-reply">
					<?php esc_html_e('отправить', 'socialbet'); ?>
				</div>
				<div class="brand-blue fr mg-top timeline-upload-trigger cursor-pointer">
					<span class="icon-photo"></span>&nbsp; <?php esc_html_e('Фотография', 'socialbet'); ?>
				</div>
			</form>
			<form class="hdn-form-ajx" id="form-ajx-tlf" method="post" enctype="multipart/form-data">
				<?php wp_nonce_field( 'socbet-timeline-files', '_socbettimelinefilesnonce', true, true ); ?>
				<input name="socbet_timelinefiles_upload" type="file" />
				<input name="action" type="hidden" value="socbet_timelines_files" />
			</form>
		</div>
	</div>
</div>
<!-- Block -->
<div class="md-modal md-effect-1 notifications" id="modal-block-user">
	<div class="md-content">
		<div class="header">
			<div class="close-abs no-bg"><span class="icon-close brand-blue-bg white md-close"></span></div>
			<h1 class="font30 white"><?php esc_html_e('Черный список', 'socialbet'); ?></h1>
		</div>
		<div class="infos col-wp">
			<p class="font14 b"><?php printf( esc_html__('Вы хотите добавить %s в черный список.', 'socialbet'), $display_name ); ?></p>
			<p class="font13"><?php print __('Это значит, что он не сможет больше просматривать Вашу страницу и отправлять Вам сообщения.<br/>Вы уверены что хотите внести пользователя в черный список?', 'socialbet'); ?></p>
			<div class="fill-balance-black" id="triger-block-user">
				<?php esc_html_e('в черный список', 'socialbet'); ?>
			</div>
			<form class="hdn-form-ajx" method="post" id="form-ajx-block">
				<?php wp_nonce_field( 'socbet-block-user', '_socbetblockusernonce', true, true ); ?>
		 		<input type="hidden" name="user_id_to_block" value="<?php echo esc_attr( $profile_user->ID ); ?>" />
		 		<input name="action" type="hidden" value="socbet_block_user_action" />
			</form>
		</div>
	</div>
</div>
<!-- Follow -->
<div class="md-modal md-effect-1 notifications" id="modal-user-follow">
	<div class="md-content">
		<div class="header">
			<div class="close-abs no-bg"><span class="icon-close brand-blue-bg white md-close"></span></div>
			<h1 class="font30 white"><?php esc_html_e('Подписаться', 'socialbet'); ?></h1>
		</div>
		<div class="infos col-wp">
			<p class="font14 b"><?php printf( esc_html__('Подписка на %s платная.', 'socialbet'), $display_name ); ?></p>
			<div class="more-user pos-rel mg-top">
				<div class="text center"><span class="brand-blue font32 more" >130 руб./месяц</span></div>
			</div>
			<p class="font13 mg-top links"><?php esc_html_e('Эта сумма будет списываться с Вашего счета ежемесячно. Гарантированное количество прогнозов - 50 штук в месяц.', 'socialbet'); ?></p>
			<div class="fill-balance-yellow" id="triger-follow-user">
				<?php esc_html_e('подписаться', 'socialbet'); ?>
			</div>
			<form class="hdn-form-ajx" method="post" id="form-ajx-follow">
				<?php wp_nonce_field( 'socbet-follow-user', '_socbetfollowusernonce', true, true ); ?>
		 		<input type="hidden" name="user_id_to_follow" value="<?php echo esc_attr( $profile_user->ID ); ?>" />
		 		<input name="action" type="hidden" value="socbet_follow_user_action" />
			</form>
		</div>
	</div>
</div>
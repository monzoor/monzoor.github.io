<?php
/**
 * User privacy settings template
 * 
 * @version 1.0
 */

if ( ! is_own_profile() )
	return;

global $wp_query, $profile_user, $user_data, $SocBet_Theme;
$errors = "";
$http_post = ('POST' == $_SERVER['REQUEST_METHOD']);

if ( $http_post ) {
	$errors = socbet_save_user_privacy_settings();
}
?>

<?php get_template_part('layouts/dashboard/setting', 'bar' ); ?>

<div class="user-settings-wrap privacy">

<?php $SocBet_Theme->print_messages($errors); ?>

<form method="post" action="" id="user-settings-general">

<?php wp_nonce_field( 'socbet-user-mysettings', '_wpnonce', true, true ); ?>

<h3 class="user-setting-section"><?php esc_html_e('Настройки приватности', 'socialbet'); ?></h3>

<div class="user-form-row">
	
	<label for="view_my_bets"><?php esc_html_e('Кто видит мои ставки', 'socialbet'); ?></label>
	<div class="user-field-col">
		<select name="view_my_bets" id="view_my_bets" class="select">
			<option value="0" <?php selected('0', ( isset($user_data['view_my_bets']) ? $user_data['view_my_bets'] : '' ) , true ); ?>><?php esc_html_e('Все', 'socialbet'); ?></option>
			<option value="1" <?php selected('1', ( isset($user_data['view_my_bets']) ? $user_data['view_my_bets'] : '' ), true ); ?>><?php esc_html_e('Только платная подписка', 'socialbet'); ?></option>
		</select>
	</div>
</div>

<div class="user-form-row">
	
	<label for="view_my_stats"><?php esc_html_e('Кто видит мою статистику', 'socialbet'); ?></label>
	<div class="user-field-col">
		<select name="view_my_stats" id="view_my_stats" class="select">
			<option value="0" <?php selected('0', ( isset($user_data['view_my_stats']) ? $user_data['view_my_stats'] : '' ) , true ); ?>><?php esc_html_e('Все', 'socialbet'); ?></option>
			<option value="1" <?php selected('1', ( isset($user_data['view_my_stats']) ? $user_data['view_my_stats'] : '' ), true ); ?>><?php esc_html_e('Только платная подписка', 'socialbet'); ?></option>
		</select>
	</div>
</div>

<div class="user-form-row">
	
	<label for="message_me"><?php esc_html_e('Кто может писать мне сообщения', 'socialbet'); ?></label>
	<div class="user-field-col">
		<select name="message_me" id="message_me" class="select">
			<option value="0" <?php selected('0', ( isset($user_data['message_me']) ? $user_data['message_me'] : '' ) , true ); ?>><?php esc_html_e('Все', 'socialbet'); ?></option>
			<option value="1" <?php selected('1', ( isset($user_data['message_me']) ? $user_data['message_me'] : '' ), true ); ?>><?php esc_html_e('Только платная подписка', 'socialbet'); ?></option>
		</select>
	</div>
</div>

<p class="text-center">
	<button type="submit" class="fill-balance big-button"><?php esc_html_e('создать группу', 'socialbet'); ?></button>
</p>

</form>

</div>
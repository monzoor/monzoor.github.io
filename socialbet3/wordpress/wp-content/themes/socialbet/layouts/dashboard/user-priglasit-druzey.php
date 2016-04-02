<?php
/**
 * translation : Invite friends
 * @ver 1.0
 */

global $wpdb, $wp_query, $profile_user, $user_data, $SocBet_Theme;

$errors = "";
$http_post = ('POST' == $_SERVER['REQUEST_METHOD']);

if ( $http_post ) {
	$errors = socbet_user_sent_invitation();
}
?>

<h1 class="fl wd-auto"><?php esc_html_e('Пригласить друзей', 'socialbet'); ?></h1>

<div class="clear"></div>

<div class="user-settings-wrap">

<?php $SocBet_Theme->print_messages($errors); ?>

<form method="post" action="" id="user-settings-general">

<?php wp_nonce_field( 'socbet-sent-invitation', '_wpsocbetsentinvitationnonce', true, true ); ?>

<h3 class="user-setting-section"><?php esc_html_e('Пригласить друга, семью или коллегу, чтобы присоединиться SocialBet.', 'socialbet'); ?></h3>

<div class="user-form-row">
	
	<label for="invite_email"><?php esc_html_e('Электронная почта', 'socialbet'); ?></label>
	<div class="user-field-col">
		<input type="email" name="invite_email" id="invite_email" value="" autocomplete="off"/>
	</div>
</div>

<p class="text-center">
	<button type="submit" class="fill-balance big-button"><?php esc_html_e('Отправить приглашение', 'socialbet'); ?></button>
</p>

</form>

</div>
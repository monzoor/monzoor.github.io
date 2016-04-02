<?php
/**
 * account menus
 * @ver 1.0
 */

global $wp_query, $profile_user;
?>

<ul>
	<li<?php if ( isset( $wp_query->query_vars['user_page'] ) && $wp_query->query_vars['user_page'] == _transliteration_process( esc_html( urldecode('ставки') ), '?', 'ru' ) ) echo ' class="selected"'; ?>>
		<a href="<?php echo get_socbet_user_dashboard_url( $profile_user->ID, _transliteration_process( esc_html( urldecode('ставки') ), '?', 'ru' ) ); ?>"><?php print __('Мои cтавки', 'socialbet'); ?></a>
		<span class="count fr">5+</span>
	</li>
	<li<?php if ( isset( $wp_query->query_vars['user_page'] ) && $wp_query->query_vars['user_page'] == _transliteration_process( esc_html( urldecode('мои-счет') ), '?', 'ru' ) ) echo ' class="selected"'; ?>>
		<a href="<?php echo get_socbet_user_dashboard_url( $profile_user->ID, _transliteration_process( esc_html( urldecode('мои-счет') ), '?', 'ru' ) ); ?>"><?php print __('Мои счет', 'socialbet'); ?></a>
	</li>
	<li<?php if ( isset( $wp_query->query_vars['user_page'] ) && $wp_query->query_vars['user_page'] == _transliteration_process( esc_html( urldecode('подписчики') ), '?', 'ru' ) ) echo ' class="selected"'; ?>>
		<a href="<?php echo get_socbet_user_dashboard_url( $profile_user->ID, _transliteration_process( esc_html( urldecode('подписчики') ), '?', 'ru' ) ); ?>"><?php print __('Мои подписчики', 'socialbet'); ?></a>
	</li>
	<li<?php if ( isset( $wp_query->query_vars['user_page'] ) && $wp_query->query_vars['user_page'] == _transliteration_process( esc_html( urldecode('подписки') ), '?', 'ru' ) ) echo ' class="selected"'; ?>>
		<a href="<?php echo get_socbet_user_dashboard_url( $profile_user->ID, _transliteration_process( esc_html( urldecode('подписки') ), '?', 'ru' ) ); ?>"><?php print __('Мои подписки', 'socialbet'); ?></a>
	</li>
	<li<?php if ( isset( $wp_query->query_vars['user_page'] ) && $wp_query->query_vars['user_page'] == _transliteration_process( esc_html( urldecode('мои-сообщения') ), '?', 'ru' ) ) echo ' class="selected"'; ?>>
		<a href="<?php echo get_socbet_user_dashboard_url( $profile_user->ID, _transliteration_process( esc_html( urldecode('мои-сообщения') ), '?', 'ru' ) ); ?>"><?php esc_html_e('Мои сообщения', 'socialbet'); ?></a>
		<?php if ( $message_count = count_unread_messages('', true) ) { ?>
		<span class="count fr"><?php print $message_count; ?>+</span>
		<?php } ?>
	</li>
	<li<?php if ( isset( $wp_query->query_vars['user_page'] ) && $wp_query->query_vars['user_page'] == _transliteration_process( esc_html( urldecode('мои-новости') ), '?', 'ru' ) ) echo ' class="selected"'; ?>>
		<a href="<?php echo get_socbet_user_dashboard_url( $profile_user->ID, _transliteration_process( esc_html( urldecode('мои-новости') ), '?', 'ru' ) ); ?>"><?php esc_html_e('Мои новости', 'socialbet'); ?></a>
	</li>
	<li<?php if ( isset( $wp_query->query_vars['user_page'] ) && $wp_query->query_vars['user_page'] == _transliteration_process( esc_html( urldecode('группы') ), '?', 'ru' ) ) echo ' class="selected"'; ?>>
		<a href="<?php echo get_socbet_user_dashboard_url( $profile_user->ID, _transliteration_process( esc_html( urldecode('группы') ), '?', 'ru' ) ); ?>"><?php print __('Мои группы', 'socialbet'); ?></a>
	</li>
	<li<?php if ( isset( $wp_query->query_vars['user_page'] ) && $wp_query->query_vars['user_page'] == _transliteration_process( esc_html( urldecode('конкурсы') ), '?', 'ru' ) ) echo ' class="selected"'; ?>>
		<a href="<?php echo get_socbet_user_dashboard_url( $profile_user->ID, _transliteration_process( esc_html( urldecode('конкурсы') ), '?', 'ru' ) ); ?>"><?php print __('Мои конкурсы', 'socialbet'); ?></a>
	</li>
	<li<?php if ( isset( $wp_query->query_vars['user_page'] ) && $wp_query->query_vars['user_page'] == _transliteration_process( esc_html( urldecode('статистика') ), '?', 'ru' ) ) echo ' class="selected"'; ?>>
		<a href="<?php echo get_socbet_user_dashboard_url( $profile_user->ID, _transliteration_process( esc_html( urldecode('статистика') ), '?', 'ru' ) ); ?>"><?php print __('Мои статистика', 'socialbet'); ?></a>
	</li>
	<li<?php if ( isset( $wp_query->query_vars['user_page'] ) && $wp_query->query_vars['user_page'] == _transliteration_process( esc_html( urldecode('мои-настройки') ), '?', 'ru' ) ) echo ' class="selected"'; ?>>
		<a href="<?php echo get_socbet_user_dashboard_url( $profile_user->ID, _transliteration_process( esc_html( urldecode('мои-настройки') ), '?', 'ru' ) ); ?>"><?php esc_html_e('Мои настройки', 'socialbet'); ?></a>
	</li>
	<li<?php if ( isset( $wp_query->query_vars['user_page'] ) && $wp_query->query_vars['user_page'] == _transliteration_process( esc_html( urldecode('пригласить-друзей') ), '?', 'ru' ) ) echo ' class="selected"'; ?>>
		<a href="<?php echo get_socbet_user_dashboard_url( $profile_user->ID, _transliteration_process( esc_html( urldecode('пригласить-друзей') ), '?', 'ru' ) ); ?>"><?php esc_html_e('Пригласить друзей', 'socialbet'); ?></a>
	</li>
	<li><a href=""><?php print __('Sign Out', 'socialbet'); ?></a></li>
</ul>
<?php
/**
 * public user menus
 * @ver 1.0
 */

global $wp_query, $profile_user;
?>

<ul>
	<li<?php if ( isset( $wp_query->query_vars['user_page'] ) && $wp_query->query_vars['user_page'] == _transliteration_process( esc_html( urldecode('ставки') ), '?', 'ru' ) ) echo ' class="selected"'; ?>>
		<a href="<?php echo get_socbet_user_dashboard_url( $profile_user->ID, _transliteration_process( esc_html( urldecode('ставки') ), '?', 'ru' ) ); ?>"><?php print __('Ставки', 'socialbet'); ?></a>
	</li>
	<li<?php if ( isset( $wp_query->query_vars['user_page'] ) && $wp_query->query_vars['user_page'] == _transliteration_process( esc_html( urldecode('подписчики') ), '?', 'ru' ) ) echo ' class="selected"'; ?>>
		<a href="<?php echo get_socbet_user_dashboard_url( $profile_user->ID, _transliteration_process( esc_html( urldecode('подписчики') ), '?', 'ru' ) ); ?>"><?php print __('Подписчики', 'socialbet'); ?></a>
	</li>
	<li<?php if ( isset( $wp_query->query_vars['user_page'] ) && $wp_query->query_vars['user_page'] == _transliteration_process( esc_html( urldecode('подписки') ), '?', 'ru' ) ) echo ' class="selected"'; ?>>
		<a href="<?php echo get_socbet_user_dashboard_url( $profile_user->ID, _transliteration_process( esc_html( urldecode('подписки') ), '?', 'ru' ) ); ?>"><?php print __('Подписки', 'socialbet'); ?></a>
	</li>
	<li<?php if ( isset( $wp_query->query_vars['user_page'] ) && $wp_query->query_vars['user_page'] == _transliteration_process( esc_html( urldecode('группы') ), '?', 'ru' ) ) echo ' class="selected"'; ?>>
		<a href="<?php echo get_socbet_user_dashboard_url( $profile_user->ID, _transliteration_process( esc_html( urldecode('группы') ), '?', 'ru' ) ); ?>"><?php print __('Группы', 'socialbet'); ?></a>
	</li>
	<li<?php if ( isset( $wp_query->query_vars['user_page'] ) && $wp_query->query_vars['user_page'] == _transliteration_process( esc_html( urldecode('конкурсы') ), '?', 'ru' ) ) echo ' class="selected"'; ?>>
		<a href="<?php echo get_socbet_user_dashboard_url( $profile_user->ID, _transliteration_process( esc_html( urldecode('конкурсы') ), '?', 'ru' ) ); ?>"><?php print __('Конкурсы', 'socialbet'); ?></a>
	</li>
	<li<?php if ( isset( $wp_query->query_vars['user_page'] ) && $wp_query->query_vars['user_page'] == _transliteration_process( esc_html( urldecode('статистика') ), '?', 'ru' ) ) echo ' class="selected"'; ?>>
		<a href="<?php echo get_socbet_user_dashboard_url( $profile_user->ID, _transliteration_process( esc_html( urldecode('статистика') ), '?', 'ru' ) ); ?>"><?php print __('Статистика', 'socialbet'); ?></a>
	</li>
</ul>
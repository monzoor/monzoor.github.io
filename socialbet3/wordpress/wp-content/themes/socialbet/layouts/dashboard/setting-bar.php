<?php
global $wp_query, $profile_user, $user_data, $SocBet_Theme;
?>
<div id="user-settings-tabs">
	<h2>
		<a href="<?php echo get_socbet_user_dashboard_url( $profile_user->ID, 'moi-nastroyki' ); ?>"<?php if( $wp_query->query_vars['user_page'] == 'moi-nastroyki') echo ' class="user-tab-active"'; ?>><?php esc_html_e('Общее', 'socialbet'); ?></a>
		<a href="<?php echo get_socbet_user_dashboard_url( $profile_user->ID, 'moi-nastroyki-privatnost' ); ?>"<?php if( $wp_query->query_vars['user_page'] == 'moi-nastroyki-privatnost') echo ' class="user-tab-active"'; ?>><?php esc_html_e('Приватность', 'socialbet'); ?></a>
		<a href="<?php echo get_socbet_user_dashboard_url( $profile_user->ID, 'moi-nastroyki-chernyy-spisok' ); ?>"<?php if( $wp_query->query_vars['user_page'] == 'moi-nastroyki-chernyy-spisok') echo ' class="user-tab-active"'; ?>><?php print esc_html_e('Черный список', 'socialbet'); ?></a>
	</h2>
</div>
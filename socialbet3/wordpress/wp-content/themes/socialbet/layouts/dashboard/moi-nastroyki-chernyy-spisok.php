<?php
/**
 * Blocklists
 * 
 * @version 1.0
 */

if ( ! is_own_profile() )
	return;

global $wp_query, $profile_user, $user_data, $SocBet_Theme;
$blocked = empty( $user_data['socbet_blocked_users'] ) ? array() : maybe_unserialize( $user_data['socbet_blocked_users'] );
?>


<?php get_template_part('layouts/dashboard/setting', 'bar' ); ?>

	<div class="settings-wrapper no-bg">
		<div class="search-box2 fr">
			<form method="post" action="">
				<input type="text" name="s" placeholder="Начните вводить название">
				<button type="submit" class="search-button"><span class="icon-search"></span></button>
			</form>
		</div>
		<div class="clear"></div>
		
		<p class="brand-blue b pd-top"><?php printf( esc_html__('В вашем черном списке находятся %d человека', 'socialbet'), count($blocked) ); ?></p>

		<div class="my-message-wrapper mg-top">

		<?php
		if ( empty($blocked) ) {

			esc_html_e('Нет черный список', 'socialbet');

		} else {

			$usr = array();
			foreach( $blocked as $userkey => $v ) {
				$usr[] = intval( str_replace('user', '', $userkey) );
			}
			unset($v);

			$args = array(
				'include' => $usr,
				'number' => count( $usr ),
				'fields' => 'all_with_meta'
				);
			$pquery = new WP_User_Query( $args );

			if ( ! empty( $pquery->results ) ) {

				foreach ( $pquery->results as $puser ) {

					$b_user_data = get_socbet_usermeta( $puser->ID );
					$b_display_name = ( empty($b_user_data['first_name']) && empty($b_user_data['last_name']) ) ? $puser->display_name : $b_user_data['first_name'] . ' ' . $b_user_data['last_name'];
					$b_user_avatar = empty( $b_user_data['avatar'] ) ? get_template_directory_uri() . '/assets/images/default_avatar.png' : $b_user_data['avatar'];
					$sts = $blocked["user{$puser->ID}"]['status'];
					$sts_time = $blocked["user{$puser->ID}"]['date'];

					if ( $sts == 'true' ) {
		?>

			<div class="white-bg">
				<a href="<?php echo get_author_posts_url( $puser->ID ); ?>"><img class="circle fl" src="<?php print $b_user_avatar; ?>"></a>
				<div class="name-box fl pos-rel">
					<div class="center">
						<p class="font14 b"><?php print $b_display_name; ?></p>
					</div>
				</div>
				<div class="message pos-rel fl">
					<p class="center dark-gray">
						<a href="<?php echo wp_nonce_url( add_query_arg( array('unblock'=>$puser->ID), get_socbet_user_dashboard_url($profile_user->ID, 'moi-nastroyki-chernyy-spisok') ), 'socbet_unblock_user', 'unblockusrkey' ); ?>"><?php esc_html_e('Убрать из черного списка', 'socialbet'); ?></a>
					</p>
				</div>
			</div>

		<?php
					} else {
		?>
			<div class="white-bg pos-rel">
				<a href="<?php echo get_author_posts_url( $puser->ID ); ?>"><img class="circle fl" src="<?php print $b_user_avatar; ?>"></a>
				<div class="name-box fl pos-rel">
					<div class="center">
						<p class="font14 b"><?php print $b_display_name; ?></p>
						<p class="placeholder-color"><?php print socbet_time_diff( mysql2date('U', $sts_time, false), current_time('timestamp') ); ?></p>
					</div>
				</div>
				<div class="message pos-rel fl">
					<p class="center">
						<a href="<?php echo wp_nonce_url( add_query_arg( array('block'=>$puser->ID), get_socbet_user_dashboard_url($profile_user->ID, 'moi-nastroyki-chernyy-spisok') ), 'socbet_block_user', 'blockusrkey' ); ?>"><?php esc_html_e('Восстановить', 'socialbet'); ?></a>	
					</p>
				</div>
				<div class="gray-overlay pos-abs"></div>
			</div>
		<?php
					}
				}
				unset($puser);

			}
		}
		?>

		</div>


		<!--<div class="yellow-bg pos-abs notification t-d-view">
			<div class="close-abs no-bg dark-gray"><span class="icon-close"></span></div>
			<p>Вам осталось сделать <span class="pl font32">23</span> прогноза</p>
			<p>У Вас осталось на это <span class="pl font32">23</span> дней</p>
		</div>-->
	</div>
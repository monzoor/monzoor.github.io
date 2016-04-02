<?php
/**
 * Followers
 * @ver 1.0
 */

global $wp_query, $profile_user, $user_data, $SocBet_Theme;
$followers = empty( $user_data['socbet_follower_data'] ) ? array() : maybe_unserialize( $user_data['socbet_follower_data'] );
?>

<h1><?php print ( is_own_profile() ? esc_html__('Мои подписчики', 'socialbet') :  esc_html__('Подписчики', 'socialbet') ) ?><span>+3</span></h1>
<div class="profile-followers-wrapper mg-top">
	<div class="search-box2 fl mg-top">
		<form methpd="post" action="">
			<input type="text" placeholder="<?php esc_attr_e('Начните вводить название', 'socialbet'); ?>">
			<button type="submit" class="search-button"><span class="icon-search"></span></button>
		</form>
	</div>
	<div class="view-style fr mobile-hide">
		<a href="#" class="list-v selected dark-gray"><span class="icon-list"></span><?php esc_html_e('Списком', 'socialbet'); ?></a>
		<a href="#" class="grid-v dark-gray"><span class="icon-grid"></span><?php esc_html_e('Сеткой', 'socialbet'); ?></a>
	</div>
	<div class="clear"></div>
	<div class="followers-wrapper">
	<?php if ( empty($followers) ) { ?>


	<?php } else { ?>
	<ul class="followers list">
		<?php
			$args = array(
				'include' => $followers,
				'number' => count( $followers ),
				'fields' => 'all_with_meta'
				);
			$pquery = new WP_User_Query( $args );

			if ( ! empty( $pquery->results ) ) {

				foreach ( $pquery->results as $puser ) {

					$f_user_data = get_socbet_usermeta( $puser->ID );
					$f_display_name = ( empty($f_user_data['first_name']) && empty($f_user_data['last_name']) ) ? $puser->display_name : $f_user_data['first_name'] . ' ' . $f_user_data['last_name'];
					$f_user_avatar = empty( $f_user_data['avatar'] ) ? get_template_directory_uri() . '/assets/images/default_avatar.png' : $f_user_data['avatar'];
		?>

			<li class="white-bg">
				<span class="icon-new pos-abs brand-red font30 mobile-hide"></span>
				<div class="follower-img">
					<a href="<?php echo get_author_posts_url( $puser->ID ); ?>"><img class="circle" src="<?php print $f_user_avatar; ?>"></a>
				</div>
				<p class="al-cntr b mg-top name"><?php print $f_display_name; ?></p>
				<div class="polygon-wrapper2">
					<div class="circle-text brand-red-bg fl pos-rel">
						<div>3200</div>
						<p class="pos-abs">место</p>
					</div>
					<!-- <p>sdsa</p> -->
					<div class="circle-text brand-blue-bg fl pos-rel">
						<div>412</div>
						<p class="pos-abs">прогнозов</p>
					</div>
					<div class="circle-text yellow-bg fl pos-rel">
						<div>+100</div>
						<p class="pos-abs">% прибыли</p>
					</div>
				</div>
				<div class="fill-balance white-bg mobile-hide">
					<a href="<?php echo get_author_posts_url( $puser->ID ); ?>"><span class="brand-blue"><?php esc_html_e('подписаться', 'socialbet'); ?></span></a>
				</div>
				<div class="sign-up mob-view no-bg brand-blue">
					<span class="icon-useradd"></span>
				</div>
			</li>

		<?php
				}
				unset($puser);

			}
		?>
	</ul>
	<?php } ?>
	</div>
</div>
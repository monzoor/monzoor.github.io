<?php get_header(); ?>

<div class="main-container">
	<div class="middle-container-wrapper-1col index">
		<div class="welcome-wrapper pos-rel">
			<div>
				<h1><?php esc_html_e('Добро пожаловать на Socialbet!', 'socialbet'); ?></h1>
				<p class="mg-top"><?php esc_html_e('Разнообразный и богатый опыт постоянное информационно-пропагандистское обеспечение нашей деятельности обеспечивает широкому кругу (специалистов) участие в формировании позиций, занимаемых участниками в отношении поставленных задач.', 'socialbet'); ?></p>
				<div class="fill-balance">
					<a href="<?php print esc_url( socbet_go_to_bet_page() ); ?>"><?php esc_html_e('сделать ставку', 'socialbet'); ?></a>
				</div>
			</div>
		</div>
		<div class="our-leader-wrapper">
			<h2><?php esc_html_e('Наши лидеры', 'socialbet'); ?></h2>
			<div class="our-leader-box">
				<ul>
					<?php
						$args = array(
							'number' => 8,
							'fields' => 'all_with_meta'
							);
						$pquery = new WP_User_Query( $args );
						if ( ! empty( $pquery->results ) ) {
							$i = 1;
							foreach ( $pquery->results as $puser ) {
								$user_data = get_socbet_usermeta( $puser->ID );
								$display_name = ( empty($user_data['first_name']) && empty($user_data['last_name']) ) ? $puser->display_name : $user_data['first_name'] . ' ' . $user_data['last_name'];
								$user_avatar = empty( $user_data['avatar'] ) ? get_template_directory_uri() . '/assets/images/default_avatar.png' : $user_data['avatar'];
					?>
						<li><a href="<?php echo get_author_posts_url( $puser->ID ); ?>">
							<img class="circle" src="<?php echo $user_avatar; ?>">
							<div class="cr-yellow pos-abs"></div>
							<div class="cr-blue pos-abs"></div>
							<div class="cr-red pos-abs"><?php print $i; ?></div>
							<p><?php print $display_name; ?></p>
						</a></li>
					<?php
							$i++;
							}
							unset($puser);
							unset($i);
						}
					?>
				</ul>
			</div>
		</div>
	</div>
	<!-- End of middle container -->
</div>
<!-- End of Main Container -->



<?php get_footer(); ?>
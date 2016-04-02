<?php
/**
 * Single competition template
 * @version 1.0
 */

get_header(); 
global $post;
?>

<div class="main-container">

	<div class="middle-container-wrapper-2col-wide for-hide">
	
	<?php
		if ( have_posts() ):

			while (have_posts()): the_post();
	?>

		<h1 class="fl wd-auto mg-top zero-border font35"><?php print apply_filters('the_title', sprintf(__('Конкурс &laquo; %s &raquo;', 'socialbet'), get_the_title()) ); ?> <span class="brand-red"><?php printf( esc_html__('%d участников', 'socialbet'), get_participants_number( get_the_ID() ) ); ?></span></h1>
		<div class="clear"></div>	
		<div class="compitition-wrapper mg-top">
			<div class="description-wrapper" style="background-image: url('<?php echo socbet_get_competition_image( get_the_ID() ); ?>');">
			<?php
			if ( has_term( esc_html('Бесплатные'), 'competition_type', $post  ) ) {
			?>
				<div class="fl free-notice">
					<span class="icon-free yellow"></span>
				</div>
			<?php
			 }
			?>
				<div class="fr participant-wrapper pos-rel">
					<p class="fl yellow font14"><?php esc_html_e('Призовой фонд', 'socialbet'); ?></p>
					<h3 class="fr yellow font50"><?php echo get_post_meta( get_the_ID(), '_'.SOCIALBET_NAME.'_competition_prize', true ) . '&#36;'; ?></h3>
					<div class="clear"></div>
					<p class="tx-center white"><?php esc_html_e('До конца конкурса осталось', 'socialbet'); ?></p>

					<div class="timer-box">
						<div class="div-center" data-endtimes="<?php echo socbet_get_competition_time_ends( get_the_ID() ); ?>">
							<p class="p1 days"><em><?php echo socbet_get_competition_time_diff( get_the_ID() ); ?></em><br><span><?php esc_html_e('дней', 'socialbet'); ?></span></p>
							<p class="p1 hours"><em><?php echo socbet_get_competition_time_diff( get_the_ID(), 'H' ); ?></em><br><span><?php esc_html_e('часов', 'socialbet'); ?></span></p>
							<p class="p1 min"><em><?php echo socbet_get_competition_time_diff( get_the_ID(), 'I' ); ?></em><br><span><?php esc_html_e('минут', 'socialbet'); ?></span></p>
							<p class="p1 sec"><em><?php echo socbet_get_competition_time_diff( get_the_ID(), 'S'); ?></em><br><span><?php esc_html_e('секунд', 'socialbet'); ?></span></p>
						</div>
					</div>

					<?php
					if ( user_is_participant( get_the_ID() ) ) { ?>
						<div class="border "></div>
						<p class="white b"><?php esc_html_e('Ваш результат:', 'socialbet'); ?></p>

						<p class="tx-center white amount"><span class="yellow font32">6578</span>очков &nbsp; &nbsp; <span class="yellow font32">13</span>место</p>
					<?php 
						} else { 
							if ( is_user_logged_in() ) {
							?>
						<div class="fill-balance fl col-wop yellow-bg dark-gray md-trigger hidden-after-ajax" data-modal="modal-enter-contest">
							<?php esc_html_e('участвовать', 'socialbet'); ?>
						</div>
						<div class="fill-balance fl col-wop yellow-bg dark-gray show-after-ajax">
							<a href="#"><?php esc_html_e('К матчам конкурса!', 'socialbet'); ?></a>
						</div>	
							<?php	
							} else {
					?>
						<div class="fill-balance fl col-wop yellow-bg dark-gray">
							<a class="join-competition" href="<?php echo esc_url( wp_login_url( get_permalink() ) ); ?>"><?php esc_html_e('участвовать', 'socialbet'); ?></a>
						</div>
					<?php 
							}
						} 
					?>
				</div>
			</div>

			<div class="text-box-wrapper">
				<div class="left-box use-shadow">
					<div class="col-wp">
						<h1 class="zero-border"><?php esc_html_e('Описание конкурса:', 'socialbet'); ?></h1>
					</div>
					<div class="border nmg"></div>
					<div class="col-wp font13 entry-content">
						<?php the_content(); ?>
					</div>
				</div>

				<div class="right-box use-shadow">
					<div class="col-wp">
						<h1 class="zero-border"><?php esc_html_e('Описание конкурса:', 'socialbet'); ?></h1>
					</div>
					<div class="border nmg"></div>
					<div class="col-wop pos-rel right-content">
						<div class="number-text-box center font13 entry-content">
							<div class="dot-border-box pos-rel"></div>
							<?php
								if( $rules = get_post_meta( get_the_ID(), '_'.SOCIALBET_NAME.'_competition_rules_desciption', true ) ) {
									echo apply_filters( 'the_content', $rules );
								}
							?>
							<div class="dot-border-box pos-rel"></div>
						</div>
					</div>
				</div>
			</div>

			<div class="our-leader-wrapper">
				<h2 class="dark-gray"><?php esc_html_e('Участники конкурса:', 'socialbet'); ?></h2>
				<div class="our-leader-box">
				<?php
					if( ! get_participants_number(get_the_ID()) ) {
				?>

					<?php print __('No participants', 'socialbet'); ?>

				<?php } else { ?>
					<ul>
					<?php
						$args = array(
							'include' => get_participants_competition_users( get_the_ID() ),
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
				<?php } ?>
				</div>
			</div>

			<div class="more-user pos-rel">
				<div class="text center"><?php printf( __('и еще <span class="brand-blue font14 more md-trigger" data-modal="modal-6">%d человек</span>', 'socialbet'), get_participants_number(get_the_ID()) ); ?></div>
			</div>
			<div class="clear"></div>

			<div class="contest-wrapper mg-top pos-rel">
				
				<div class="timer-box">
					<div class="div-center" data-endtimes="<?php echo socbet_get_competition_time_ends( get_the_ID() ); ?>">
						<p class="p1 days"><em><?php echo socbet_get_competition_time_diff( get_the_ID() ); ?></em><br><span><?php esc_html_e('дней', 'socialbet'); ?></span></p>
						<p class="p1 hours"><em><?php echo socbet_get_competition_time_diff( get_the_ID(), 'H' ); ?></em><br><span><?php esc_html_e('часов', 'socialbet'); ?></span></p>
						<p class="p1 min"><em><?php echo socbet_get_competition_time_diff( get_the_ID(), 'I' ); ?></em><br><span><?php esc_html_e('минут', 'socialbet'); ?></span></p>
						<p class="p1 sec"><em><?php echo socbet_get_competition_time_diff( get_the_ID(), 'S'); ?></em><br><span><?php esc_html_e('секунд', 'socialbet'); ?></span></p>
					</div>
				</div>

				<div class="text-holder center">
					<ul>
						<li class="mobile-hide"><p><?php esc_html_e('Призовой фонд', 'socialbet'); ?></p></li>
						<li class="mobile-hide"><p class="font60 brand-blue"><?php echo get_post_meta( get_the_ID(), '_'.SOCIALBET_NAME.'_competition_prize', true ) . '&#36;'; ?></p></li>
						<li>
						<?php
						if ( user_is_participant( get_the_ID() ) ) { 
							// link to the market will figure it out later
						?>
							
							<div class="fill-balance-yellow nmg-top"><a href="#"><?php esc_html_e('К матчам конкурса!', 'socialbet'); ?></a></div>
						
						<?php 
						} else { 
							if ( is_user_logged_in() ) {
						?>
							
							<div class="fill-balance-yellow nmg-top md-trigger hidden-after-ajax" data-modal="modal-enter-contest"><?php esc_html_e('Принять участие в конкурсе!', 'socialbet'); ?></div>
							<div class="fill-balance-yellow nmg-top show-after-ajax"><a href="#"><?php esc_html_e('К матчам конкурса!', 'socialbet'); ?></a></div>
							
							<?php } else { ?>
							
							<div class="fill-balance-yellow nmg-top"><a href="<?php echo esc_url( wp_login_url( get_permalink() ) ); ?>"><?php esc_html_e('Принять участие в конкурсе!', 'socialbet'); ?></a></div>
						
						<?php 
							} 
						}
						?>
						</li>
						<li class="mobile-hide"><p class="font60 brand-blue"><?php echo get_post_meta( get_the_ID(), '_'.SOCIALBET_NAME.'_competition_prize', true ) . '&#36;'; ?></p></li>
						<li class="mobile-hide"><p><?php esc_html_e('Призовой фонд', 'socialbet'); ?></p></li>
					</ul>
				</div>
			</div>

<?php
	$args = array(
		'post_type' => 'competition',
		'post_status' => 'publish',
		'post__not_in' => array(get_the_ID()),
		'posts_per_page' => 3,
		'orderby' => 'rand'
		);
	$args['meta_query'] = array(
			array(
				'key'     => '_'.SOCIALBET_NAME.'_competition_end',
				'value'   => date('Y/m/d H:i'),
				'type'	  => 'CHAR',
				'compare' => '<=',
			),
		);

	$comquery = new WP_Query( $args );

	if( $comquery->have_posts() ) {
?>
			<div class="dot-border-box pos-rel mg-top transparent"></div>

			<div class="recommend-wrapper mg-top">
				<h1 class="zero-border"><?php esc_html_e('Рекомендуем Вам:', 'socialbet'); ?></h1>

				<div class="competition-box-wrapper mg-top test">
					<ul>
		<?php 
			while ( $comquery->have_posts() ) {
			$comquery->the_post();
		?>

			<?php get_template_part( 'competition', 'list' ); ?>

		<?php } ?>
					</ul>
				</div>
			</div>
<?php
	}
	wp_reset_query();
?>

		</div>
<?php

		endwhile;

	endif;
	wp_reset_postdata();
?>

	</div>


	<div class="right-container-wrapper t-d-view tab-por-no-view">
		<img src="<?php echo get_template_directory_uri() . '/assets/images/banner-1.jpg'; ?>" alt="" />
	</div>


</div>

<?php get_footer(); ?>
<?php
/**
 * @version 1.0
 */

global $wp_query, $profile_user, $user_data, $SocBet_Theme;
$competitions = empty( $user_data['user_participate_in'] ) ? array() : maybe_unserialize( $user_data['user_participate_in'] );
?>


	<h1 class="fl wd-auto"><?php if ( is_own_profile() ) { printf( __('Мои конкурсы <span>%d</span>', 'socialbet'), count($competitions) ); } else { printf( __('Kонкурсы <span>%d</span>', 'socialbet'), count($competitions) ); } ?></h1>
	<div class="search-box2 fr">
		<form methpd="post" action="">
			<input type="text" name="cs" placeholder="<?php esc_attr_e('Начните вводить название', 'socialbet'); ?>">
			<button type="submit" class="search-button"><span class="icon-search"></span></button>
		</form>
	</div>

	<div class="profile-competition-wrapper fl">
		<div class="filter-box mg-bottom">
			<ul>
				<li<?php if ( ! isset($_GET['status']) ) echo ' class="selected"'; ?>>
					<a href="<?php echo get_socbet_user_dashboard_url( $profile_user->ID, _transliteration_process( esc_html( urldecode('конкурсы') ), '?', 'ru' ) ); ?>">
						<?php printf( esc_html__('Все (%d)', 'socialbet'), count($competitions) ) ; ?>
					</a>
				</li>
				<li<?php if ( isset($_GET['status']) && $_GET['status'] == 'aktivnyye' ) echo ' class="selected"'; ?>>
					<a href="<?php echo add_query_arg( 'status', 'aktivnyye', get_socbet_user_dashboard_url( $profile_user->ID, _transliteration_process( esc_html( urldecode('конкурсы') ), '?', 'ru' ) ) ); ?>">
						<?php printf( esc_html__('Активные (%d)', 'socialbet'), get_user_competition_counts('active', $competitions) ); ?>
					</a>
				</li>
				<li<?php if ( isset($_GET['status']) && $_GET['status'] == 'zavershennyye' ) echo ' class="selected"'; ?>>
					<a href="<?php echo add_query_arg( 'status', 'zavershennyye', get_socbet_user_dashboard_url( $profile_user->ID, _transliteration_process( esc_html( urldecode('конкурсы') ), '?', 'ru' ) ) ); ?>">
						<?php printf( esc_html__('Завершенные (%d)', 'socialbet'), get_user_competition_counts('end', $competitions) ); ?>
					</a>
				</li>
			</ul>
		</div>
		<div class="competition-box-wrapper">
		<?php
			if ( empty($competitions) ) {
				
				esc_html_e('У вас нет конкуренции', 'socialbet');
			
			} else {

				$args = array(
					'post_type' => 'competition',
					'post_status' => 'publish',
					'post__in' => $competitions,
					'posts_per_page' => -1,
					'orderby' => 'date'
					);

				$today = date("Y-m-d H:i:s");
				if ( isset($_GET['status']) ) {
					if ( $_GET['status'] == 'aktivnyye' ) {
						$args['meta_query'] = array(
								array(
									'key'     => '_'.SOCIALBET_NAME.'_competition_end',
									'value'   => $today,
									'type'	  => 'DATETIME',
									'compare' => '>=',
								),
							);
					} else if ( $_GET['status'] == 'zavershennyye' ) {
						$args['meta_query'] = array(
								array(
									'key'     => '_'.SOCIALBET_NAME.'_competition_end',
									'value'   => $today,
									'type'	  => 'DATETIME',
									'compare' => '<=',
								),
							);
					}
				}

				$comquery = new WP_Query( $args );

				if( $comquery->have_posts() ):
		?>
			<ul>
				<?php
					while ( $comquery->have_posts() ): $comquery->the_post();
					global $post;
				?>
				<li id="competition-<?php the_ID(); ?>">
					<div <?php post_class(array('use-shadow','competition-inner-wrapper') ); ?>>
						<div class="img-holder" style="background-image: url('<?php echo socbet_get_competition_image( get_the_ID() ); ?>');">
							<?php
							if ( has_term( esc_html('Бесплатные'), 'competition_type', $post  ) ) {
							?>
								<div class="free-notice">
									<span class="icon-free yellow"></span>
								</div>
							<?php
							}
							?>
							<div class="timer-box">
								<div class="div-center" data-endtimes="<?php echo socbet_get_competition_time_ends( get_the_ID() ); ?>">
									<p class="p1 days"><em><?php echo socbet_get_competition_time_diff( get_the_ID() ); ?></em><br><span><?php esc_html_e('дней', 'socialbet'); ?></span></p>
									<p class="p1 hours"><em><?php echo socbet_get_competition_time_diff( get_the_ID(), 'H' ); ?></em><br><span><?php esc_html_e('часов', 'socialbet'); ?></span></p>
									<p class="p1 min"><em><?php echo socbet_get_competition_time_diff( get_the_ID(), 'I' ); ?></em><br><span><?php esc_html_e('минут', 'socialbet'); ?></span></p>
									<p class="p1 sec"><em><?php echo socbet_get_competition_time_diff( get_the_ID(), 'S'); ?></em><br><span><?php esc_html_e('секунд', 'socialbet'); ?></span></p>
								</div>
							</div>
						</div>
						<h2><a href="<?php the_permalink(); ?>" class="dark-link"><?php the_title(); ?></a></h2>
						<div class="col-wp">
							<p class="fl head">
								Ваш результат:
								<span>6789</span>
								<span class="point">очков</span>
								<span>13</span>
								<span class="point">место</span>
							</p>
						</div>
						
						<?php
						if ( socbet_get_competition_time_ends( get_the_ID() ) == 'null' ) {
						?>
							<?php if( is_own_profile() ) { ?>
							<div class="col-wp congratulations-wrapper">
								<div class="congratulations try-again">
									<?php esc_html_e('Поздравляем', 'socialbet'); ?>
								</div>
							</div>
							<?php } ?>

							<div class="col-wp done">
								<p align="center"><?php esc_html_e('Конкурс завершен', 'socialbet'); ?></p>
							</div>

						<?php } else { ?>

							<div class="fill-balance">
								<a href="#"><?php esc_html_e('к матчам конкурса', 'socialbet'); ?></a>
							</div>
							<?php if( is_own_profile() ) { ?>
							<div class="col-wp light-gray-bg">
								<p align="center" class="placeholder-color"><a href="#" class="ajax-trigger-quit-competition"><u><?php esc_html_e('Не участвовать в конкурсе', 'socialbet'); ?></u></a></p>
								<form class="ajax-quit-competition-form" method="post">
								<?php wp_nonce_field( 'socbet-quit-competition', '_wpajaxquitcompetition', true, true ); ?>
								<input type="hidden" name="competition_id" value="<?php esc_attr_e( $post->ID ); ?>" />
								<input type="hidden" name="action" value="socbet_quit_competition" />
								</form>
							</div>
							<?php } ?>
							
						<?php } ?>
					</div>
				</li>
				<?php
				endwhile;
				?>
			</ul>
		<?php else: ?>

			<?php esc_html_e('Просим прощения, нет данных', 'socialbet'); ?>

		<?php 
			endif; 
			wp_reset_query();
		?>
		<?php
			}
		?>
		</div>
	</div>
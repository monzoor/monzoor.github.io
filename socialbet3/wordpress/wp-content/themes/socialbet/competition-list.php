<?php
/**
 * Competition lists loop
 *
 * @ver 1.0
 */

if ( ! defined('ABSPATH') )
	exit;

global $post;
?>
	<li>
		<div class="competition-inner-wrapper use-shadow">
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
				<div class="yellow-box pos-abs">
					<p class="p1"><?php esc_html_e('призовой фонд', 'socialbet'); ?></p>
					<p class="p2"><?php echo get_post_meta( get_the_ID(), '_'.SOCIALBET_NAME.'_competition_prize', true ) . '&#36;'; ?></p>
				</div>
				<div class="timer-box">
					<div class="div-center" data-endtimes="<?php echo socbet_get_competition_time_ends( get_the_ID() ); ?>">
						<p class="p1 days"><em><?php echo socbet_get_competition_time_diff( get_the_ID() ); ?></em><br><span><?php esc_html_e('дней', 'socialbet'); ?></span></p>
						<p class="p1 hours"><em><?php echo socbet_get_competition_time_diff( get_the_ID(), 'H' ); ?></em><br><span><?php esc_html_e('часов', 'socialbet'); ?></span></p>
						<p class="p1 min"><em><?php echo socbet_get_competition_time_diff( get_the_ID(), 'I' ); ?></em><br><span><?php esc_html_e('минут', 'socialbet'); ?></span></p>
						<p class="p1 sec"><em><?php echo socbet_get_competition_time_diff( get_the_ID(), 'S'); ?></em><br><span><?php esc_html_e('секунд', 'socialbet'); ?></span></p>
					</div>
				</div>
			</div>
			<h2><?php the_title(); ?></h2>
			<div class="col-wp">
				<p class="fl txt">
					<?php echo get_the_excerpt(); ?>
				</p>
			</div>
			<a href="<?php the_permalink(); ?>" class="fill-balance fl gray-filler">
				<span class="white"><?php esc_html_e('ПОДРОБНЕЕ', 'socialbet'); ?></span>
			</a>
			<div class="fill-balance fl">
				<?php 
				if ( user_is_participant( get_the_ID() ) ) {
					echo '<a href="#" class="black-link">' . esc_html__('К матчам конкурса!', 'socialbet'). '</a>';
				} else { 
					echo '<a href="'.get_permalink().'" class="black-link">' . esc_html__('УЧАСТВОВАТЬ', 'socialbet') . '</a>';
				}
				?>
			</div>
		</div>
	</li>
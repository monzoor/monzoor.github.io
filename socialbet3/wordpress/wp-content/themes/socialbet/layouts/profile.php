<?php
/**
 * user profile/index page
 *
 * @ver 1.0
 */

global $wp_query, $profile_user, $user_data, $SocBet_Theme, $user_avatar, $display_name;
?>

<?php if( is_own_profile() ) { ?>
<h1 class="mg-bottom" id="user-profile-header"><?php printf( esc_html__('%d записей', 'socialbet'), $wp_query->found_posts ); ?></h1>

	<div class="write-post-wrapper mg-bottom">
		<div class="lft-box">
			<img class="circle" src="<?php echo $user_avatar; ?>">
		</div>
		<div class="rt-box">
			<div class="arrow-box"><div class="arrow-left"></div></div>
			<div class="writing-post">
				
				<form id="user-status-write" action="<?php echo esc_url( get_author_posts_url($profile_user->ID) ); ?>" method="post">
					<?php wp_nonce_field( 'socbet-user-status-post', '_socbetuserstatusnonce', true, true ); ?>
					<input type="hidden" name="action" value="post_live_status" />
					<input name="user_post_id" type="hidden" value="<?php echo esc_attr($profile_user->ID); ?>" />
					<textarea name="content" placeholder="<?php esc_attr_e('Поделитесь новостями', 'socialbet'); ?>"></textarea>
					<div class="image-holder" id="timeline-upload-holder"></div>
					<div class="poll-holder" id="timeline-poll-holder"></div>
					<a class="fill-balance" id="post-status-trigger" href="#"><?php esc_html_e('Послать', 'socialbet'); ?></a>

					<div class="attach">
						<ul class="attach-menu">
						    <li><a href="#"><?php esc_html_e('Прикрепить', 'socialbet'); ?></a>
						        <ul class="options use-shadow">
						        	<div class="border"></div>
						            <li><a href="#" class="timeline-upload-trigger"><span class="icon-photo"></span><?php esc_html_e('Фотографию', 'socialbet'); ?> </a>
						            </li><li><a href="#"><span class="icon-video"></span><?php esc_html_e('Видеозапись', 'socialbet'); ?> </a>
						            </li><li><a href="#" class="timeline-upload-trigger"><span class="icon-document"></span><?php esc_html_e('Документ', 'socialbet'); ?> </a>
						            </li><li><a href="#" class="timeline-poll-trigger"><span class="icon-voting"></span><?php esc_html_e('Опрос', 'socialbet'); ?> </a>
						            </li>            
						        </ul>
						    </li>
						</ul>
					</div>

				</form>
				<form class="hdn-form-ajx" id="form-ajx-tlf" method="post" enctype="multipart/form-data">
					<?php wp_nonce_field( 'socbet-timeline-files', '_socbettimelinefilesnonce', true, true ); ?>
					<input name="socbet_timelinefiles_upload" type="file" />
					<input name="action" type="hidden" value="socbet_timelines_files" />
				</form>
			</div>
		</div>
	</div>
<?php } else { ?>
<h1><?php esc_html_e('Последние записи', 'socialbet'); ?></h1>
<?php } ?>

<div id="user-status-wrapper">
<?php

if ( user_is_blocked_by($profile_user->ID) ) {

	esc_html_e( 'Извините, нет записей, могут быть отображены', 'socialbet' );

	echo '</div>';
	return;
}

if ( have_posts() ) :

	while ( have_posts() ): the_post();

?>

	<?php get_template_part('timeline', 'loop'); ?>

<?php
	
	endwhile;

endif;
wp_reset_postdata();
?>
</div>

<?php if ( $wp_query->max_num_pages > 1 ) { ?>
<div class="demo-3 loads-more-page" data-maxpages="<?php echo $wp_query->max_num_pages; ?>" data-page="1">
	<ul class="bokeh">
		<li></li>
		<li></li>
		<li></li>
		<li></li>
	</ul>
</div>
<?php } ?>
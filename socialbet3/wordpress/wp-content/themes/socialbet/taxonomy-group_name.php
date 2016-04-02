<?php 
get_header(); 
global $term, $group_id, $group_thumbnail, $wp_query, $current_user, $user_data, $is_group_admin, $group_member, $user_avatar, $display_name;
get_currentuserinfo();

$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
$group_id = $term->term_id;
$meta_group = get_option('taxonomy_meta_'.$group_id);
$group_member = array();
$group_admin = array();
$is_group_admin = false;

$group_thumbnail = $group_image = "";

if ( is_array($meta_group) && isset($meta_group['theme']) ) {
	$theme = $meta_group['theme'];
	$group_member = isset( $meta_group['subscriber'] ) ? $meta_group['subscriber'] : '0';
	$group_admin = isset( $meta_group['admin'] ) ? $meta_group['admin'] : '0';
	$theme_meta = get_option('taxonomy_meta_'.$theme);

	if ( is_array($theme_meta) ) {
		$group_thumbnail = isset($theme_meta['thumbnail']) ? wp_get_attachment_thumb_url( $theme_meta['thumbnail'] ) : '';
		$group_image = isset($theme_meta['image']) ? wp_get_attachment_url( $theme_meta['image'] ) : '';	
	}

	if ( isset( $meta_group['image'] ) && $meta_group['image'] != "" ) {
		$group_image = wp_get_attachment_url( $meta_group['image'] );	
	}
	if ( isset( $meta_group['thumbnail'] ) && $meta_group['thumbnail'] != "" ) {
		$group_thumbnail = wp_get_attachment_thumb_url( $meta_group['thumbnail'] );	
	}
}

if ( is_user_logged_in() ) {
	$user_data = get_socbet_usermeta( $current_user->ID );
	$display_name = ( empty($user_data['first_name']) && empty($user_data['last_name']) ) ? $current_user->display_name : $user_data['first_name'] . ' ' . $user_data['last_name'];
	$user_avatar = empty( $user_data['avatar'] ) ? get_template_directory_uri() . '/assets/images/default_avatar.png' : $user_data['avatar'];

	if ( in_array($current_user->ID,$group_admin) ) {
		$is_group_admin = true;
	}
}
?>

<div class="main-container">

	<div class="group-top-img" id="group-top-img" style="background-image: url('<?php print $group_image; ?>');">
		<?php if ( $is_group_admin ) { ?>
			<div class="new-photo">
				<a href="#" class="ajx-form-call" id="group-image-trigger-upload" data-form="form-ajx-group-image" data-form-type="upload">
					<span class="icon-photo white"></span>
					<span class="white up-text"><?php esc_html_e('Загрузить фотографию', 'socialbet'); ?></span>
				</a>
				<form class="hdn-form-ajx" id="form-ajx-group-image" method="post" enctype="multipart/form-data">
					<?php wp_nonce_field( 'socbet-group-image', '_wpajaxnonce', true, true ); ?>
					<input name="group-image" type="file" />
					<input name="group_id" type="hidden" value="<?php echo esc_attr($group_id); ?>" />
					<input name="action" type="hidden" value="socbet_upload_group_image" />
				</form>
			</div>
		<?php } ?>
	</div>

	<?php get_template_part('group', 'left'); ?>

	<div class="middle-container-wrapper<?php if ( $is_group_admin ) echo ' g-admin'; ?>">

		<?php /** mobile view */ ?>
		<div class="top-avatar pos-rel mob-view">
	 		<img src="<?php print $group_thumbnail; ?>" class="group-thumbnail-<?php echo trim($group_id); ?> circle" />
	 		<?php if ( $is_group_admin ) { ?>
			<div class="new-avatar pos-abs abs-bottom-zero">
	 			<a href="#" class="ajx-form-call" data-form="form-ajx-group-thumbnail" data-form-type="upload">
					<span class="white"><?php esc_html_e('Загрузить фотографию', 'socialbet'); ?></span>
	 				<span class="icon-photo white"></span>
	 			</a>
	 		</div>
	 		<?php } ?>
	 	</div>
	 	<div class="col-wop mob-view">
	 		<h1 class="zero-border"><?php print esc_html( $term->name ); ?></h1>
	 		<p class="mg-top font14">
	 			<?php print stripslashes($term->description); ?>
	 		</p>

	 	<?php if ( $is_group_admin ) { ?>
	 		<div class="border mg-top"></div>
	 		<ul class="links">
	 			<li><a href="?upravleniye-gruppoy=1"><?php print __('Управление<br> группой', 'socialbet'); ?></a></li>
	 			<li class="md-trigger" data-modal="modal-16"><?php print __('Пригласить<br> участников', 'socialbet'); ?></li>
	 			<li><a href="#"><?php print __('Назначить<br>руководителя', 'socialbet'); ?></a></li>
	 		</ul>
	 		<div class="border mg-top"></div>
	 	<?php } ?>
	 	</div>
	 	<?php /** end mobile view */ ?>

 	<?php if ( isset($_GET['upravleniye-gruppoy']) && $is_group_admin ) { ?>

 		<?php get_template_part('layouts/group', 'manage'); ?>

 	<?php } else { ?>

		<h1><?php esc_html_e('Последние записи', 'socialbet'); ?></h1>

		<?php if ( user_is_member_of($group_id) ) { ?>

			<div class="write-post-wrapper mg-bottom">
				<div class="lft-box">
					<img class="circle" src="<?php echo $user_avatar; ?>">
				</div>
				<div class="rt-box">
					<div class="arrow-box"><div class="arrow-left"></div></div>
					<div class="writing-post">
						
						<form id="user-status-write" action="<?php echo esc_url( get_term_link($group_id, 'group_name') ); ?>" method="post">
							<?php wp_nonce_field( 'socbet-user-status-post', '_socbetuserstatusnonce', true, true ); ?>
							<input type="hidden" name="action" value="post_live_group" />
							<input type="hidden" name="term_id" value="<?php echo esc_attr($group_id); ?>" />
							<input name="user_post_id" type="hidden" value="<?php echo esc_attr($current_user->ID); ?>" />
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
		<?php } ?>

		<div id="user-status-wrapper">
		<?php

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

	<?php } ?>

		<div class="clear"></div>
	</div>

	<div class="right-container-wrapper t-d-view tab-por-no-view">
		asdas
	</div>

</div>

<?php get_footer(); ?>
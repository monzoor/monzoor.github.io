<?php
/**
 * Group left sidebar
 */
global $term, $group_id, $group_thumbnail, $is_group_admin, $group_member;
?>

<div class="left-container-wrapper group-left t-d-view">
	<div class="top-avatar pos-rel">
 		<img src="<?php print $group_thumbnail; ?>" class="group-thumbnail-<?php echo trim($group_id); ?> circle" />
<?php
if ( $is_group_admin ) {
?>
		<div class="new-avatar pos-abs abs-bottom-zero">
 			<a href="#" class="ajx-form-call" id="group-thumbnail-trigger-upload" data-form="form-ajx-group-thumbnail" data-form-type="upload">
				<span class="white up-text"><?php esc_html_e('Загрузить фотографию', 'socialbet'); ?></span>
 				<span class="icon-photo white"></span>
 			</a>
			<form class="hdn-form-ajx" id="form-ajx-group-thumbnail" method="post" enctype="multipart/form-data">
				<?php wp_nonce_field( 'socbet-group-thumbnail', '_wpajaxnonce', true, true ); ?>
				<input name="group-thumbnail" type="file" />
				<input name="group_id" type="hidden" value="<?php echo esc_attr($group_id); ?>" />
				<input name="action" type="hidden" value="socbet_upload_group_thumbnail" />
			</form>
 		</div>
<?php
}
?>
 	</div>
	<div class="col-wp">
 		<h1><?php print esc_html( $term->name ); ?></h1>
 		<p class="mg-top font14">
 			<?php print stripslashes($term->description); ?>
 		</p>
 		

<?php
if ( $is_group_admin ) {
?>
 		<p class="<?php if( isset($_GET['upravleniye-gruppoy']) && $_GET['upravleniye-gruppoy'] ) echo 'selected '; ?>b mg-top"><a href="?upravleniye-gruppoy=1" class="dark-link"><?php esc_html_e('Управление группой' ,'socialbet'); ?></a></p>
 		<p data-modal="modal-16" class="md-trigger b mg-top"><?php esc_html_e('Пригласить участников' ,'socialbet'); ?></p>
 		<p data-modal="modal-17" class="md-trigger b mg-top"><?php esc_html_e('Назначить руководителя' ,'socialbet'); ?></p>

<?php
} else {
	if ( ! user_is_member_of($group_id) ) {
?>

		<div class="fill-balance">
			<a href="?join_group=1" class="dark-link"><?php esc_html_e('подписаН' ,'socialbet'); ?></a>
		</div>
<?php
	}
}
?>


		<h1 class="fl mg20"><?php esc_html_e('Подписчики', 'socialbet'); ?></h1>
		<p class="fr brand-blue font14 b count"><?php printf( esc_html__('%d подписчиков', 'socialbet'), count($group_member) ); ?></p>
		<div class="clear"></div>
		<div class="col-wop mg-top">

		<?php
			$args = array(
				'include' => $group_member,
				'number' => 10,
				'fields' => 'all_with_meta'
				);
			$pquery = new WP_User_Query( $args );

			if ( ! empty( $pquery->results ) ) {

				foreach ( $pquery->results as $puser ) {

					$f_user_data = get_socbet_usermeta( $puser->ID );
					$f_user_avatar = empty( $f_user_data['avatar'] ) ? get_template_directory_uri() . '/assets/images/default_avatar.png' : $f_user_data['avatar'];
		?>
			<div class="img-holder small fl">
				<a href="<?php echo get_author_posts_url( $puser->ID ); ?>"><img class="circle" src="<?php print $f_user_avatar; ?>"></a>
		 	</div>
		<?php
				}

			}
		?>
		</div>

		<h1 class="fl mg-top">Обсуждения</h1>
		<p class="fr brand-blue font14 b count">769 тем</p>
		<div class="clear"></div>
		<div class="col-wop mg-top quote">
			<div class="quote-sign fl"><img src="<?php echo get_template_directory_uri() . '/assets/images/quote.jpg'; ?>" alt="" /></div>
			<div class="text-box fl">
				<p class="font14">Фильмы для серьёзных обзоров</p>
				<p class="placeholder-color font12 fl mg-top">Сегодня в 22:14</p>
				<span class="icon-message brand-blue mg-top fl"></span><span class="dark-gray b font14 mg-top fl">15 967</span>
			</div>
		</div>
		<div class="col-wop mg-top quote">
			<div class="quote-sign fl"><img src="<?php echo get_template_directory_uri() . '/assets/images/quote.jpg'; ?>" alt="" /></div>
			<div class="text-box fl">
				<p class="font14">Встреча клуба в Санкт-Петербурге 15 июля </p>
				<p class="placeholder-color font12 fl mg-top">Сегодня в 22:14</p>
				<span class="icon-message brand-blue mg-top fl"></span><span class="dark-gray b font14 mg-top fl">15 967</span>
			</div>
		</div>
		<div class="col-wop mg-top quote">
			<div class="quote-sign fl"><img src="<?php echo get_template_directory_uri() . '/assets/images/quote.jpg'; ?>" alt="" /></div>
			<div class="text-box fl">
				<p class="font14">Фильмы для серьёзных обзоров</p>
				<p class="placeholder-color font12 fl mg-top">Сегодня в 22:14</p>
				<span class="icon-message brand-blue mg-top fl"></span><span class="dark-gray b font14 mg-top fl">15 967</span>
			</div>
		</div>
		<h1 class="fl mg-top">Контакты</h1>
		<div class="clear"></div>
		<div class="image-info-box mg-top">
			<div class="img-holder">
		 		<img src="images/test-img-1.jpg" class="circle">
		 	</div>
		 	<div class="info-holder">
		 		<p>Константин Константиновский</p>
		 		<p class="sub-info">Сегодня в 22:14</p>
		 	</div>
		</div>
		<div class="image-info-box mg-top">
			<div class="img-holder">
		 		<img src="images/test-img-1.jpg" class="circle">
		 	</div>
		 	<div class="info-holder">
		 		<p>Константин Константиновский</p>
		 		<p class="sub-info">Сегодня в 22:14</p>
		 	</div>
		</div>
	</div>
</div>



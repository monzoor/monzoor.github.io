<?php get_header();

global $wp_query, $profile_user, $user_data, $user_avatar, $display_name;
get_profile_user_details();

$user_data = get_socbet_usermeta( $profile_user->ID );
$display_name = ( empty($user_data['first_name']) && empty($user_data['last_name']) ) ? $profile_user->display_name : $user_data['first_name'] . '<br/>' . $user_data['last_name'];
$user_avatar = empty( $user_data['avatar'] ) ? get_template_directory_uri() . '/assets/images/default_avatar.png' : $user_data['avatar'];
?>


<div class="main-container">

	<div class="left-container-wrapper t-d-view">
		<div class="top-info-box">
			
			<div class="top-lf-info">
				
				<div class="img-box pos-rel" id="usr-img-box" style="background-image: url('<?php echo $user_avatar; ?>');">
					<img src="<?php echo get_template_directory_uri() . '/assets/images/blank.png'; ?>" alt="" />
				<?php if ( is_own_profile() ): ?>
					<span class="icon-photo" id="user-photo-trigger"></span>
					<div class="shadow" id="user-photo-text"><?php esc_html_e('Новое фото', 'socialbet'); ?></div>
					<form class="user-change-photo" id="photo-swap-<?php echo $profile_user->ID; ?>" method="post" enctype="multipart/form-data">
						<?php wp_nonce_field( 'socbet-user-photo', '_wpajaxnonce', true, true ); ?>
						<input name="user-photo" type="file" />
						<input name="userId" type="hidden" value="<?php echo esc_attr($profile_user->ID); ?>" />
						<input name="action" type="hidden" value="socbet_upload_profile_img" />
					</form>
				<?php endif; ?>
				</div>
				<?php if ( is_own_profile() ): ?>
				<p class="balance"><?php print __('Balance', 'socialbet'); ?></p>

				<p><span class="rubel">18 245</span><?php print __('rubles', 'socialbet'); ?></p>
				<?php endif; ?>
			</div>
			
			<div class="top-rt-info">
				<h2 class="name"><?php print $display_name; ?></h2>
				<p class="age"><?php print socbet_get_user_age( $profile_user->ID ); ?></p>
				<p class="address">St. Petersburg</p>
				<?php if ( is_own_profile() ): ?>
				<div class="fill-balance">
					<?php print __('Fill up balance', 'socialbet'); ?>
				</div>
				<?php endif; ?>
			</div>

		</div>
		<?php
		if ( ! is_own_profile() ) {
		?>
		<div class="polygon-wrapper">
			<div class="circle polygon fl brand-red-bg">
				<p class="font32 pl white pos-abs">3200</p>
				<p class="mg-top">место</p>
			</div>

			<div class="circle polygon fl brand-blue-bg">
				<p class="font32 pl white pos-abs">412</p>
				<p class="mg-top">прогнозов</p>
			</div>

			<div class="circle polygon fl yellow-bg">
				<p class="font32 pl white pos-abs">+ 120</p>
				<p class="mg-top">% прибыли</p>
			</div>
		</div>

		<?php if ( current_user_is_follow( $profile_user->ID ) ) { ?>
		<div class="fill-balance full-width mg-all" id="press-to-follow">
			<?php esc_html_e('подписан', 'socialbet'); ?>
		</div>
		<?php } else { ?>
		<div class="fill-balance full-width mg-all md-trigger" data-modal="modal-user-follow" id="press-to-follow">
			<?php esc_html_e('подписаться', 'socialbet'); ?>
		</div>
		<?php } ?>

		<div class="fill-balance gray full-width mg-all md-trigger" data-modal="modal-sent-message">
			<?php esc_html_e('отправить сообщение', 'socialbet'); ?>
		</div>
		<?php
		}
		?>
		<div class="profile-menu">
		<?php
			if ( is_own_profile() ) {

				get_template_part('layouts/dashboard/inner', 'menus');

			} else {

				get_template_part('layouts/dashboard/public', 'menus');

			}
		?>
		</div>
		<?php
			if ( is_own_profile() ) {
		?>
		<div class="polygon-wrapper">
			<div class="circle polygon fl brand-red-bg">
				<p class="font32 pl white pos-abs">3200</p>
				<p class="mg-top">место</p>
			</div>

			<div class="circle polygon fl brand-blue-bg">
				<p class="font32 pl white pos-abs">412</p>
				<p class="mg-top">прогнозов</p>
			</div>

			<div class="circle polygon fl yellow-bg">
				<p class="font32 pl white pos-abs">+ 120</p>
				<p class="mg-top">% прибыли</p>
			</div>
		</div>
		<?php } else { ?>
			
			<?php if ( is_user_logged_in() ) { ?>

				<?php if ( current_user_is_blocked( $profile_user->ID ) ) { ?>
					<p class="placeholder-color font14 middle" id="press-to-block"><u><?php esc_html_e('Заблокированные.', 'socialbet'); ?></u></p>
				<?php } else { ?>
					<p class="placeholder-color font14 middle md-trigger" data-modal="modal-block-user" id="press-to-block"><u><?php esc_html_e('Добавить в черный список', 'socialbet'); ?></u></p>
				<?php } ?>

			<?php } ?>

		<?php
			}
		?>
	</div>

<?php
	$upage_now = isset( $wp_query->query_vars['user_page'] ) ? $wp_query->query_vars['user_page'] : '';
	$class_container = 'middle-container-wrapper';
	if ( $upage_now == 'gruppy') {
		$class_container = 'middle-container-wrapper-2col';
	}
?>

	<div class="<?php echo $class_container; ?>">

<?php 
		// call a template based on user page
		if ( isset( $wp_query->query_vars['user_page'] ) ) {

			if ( strpos( $wp_query->query_vars['user_page'], 'moi-' ) === 0 ) 
			{
				
				get_template_part('layouts/dashboard/moi', str_replace('moi-', '', $wp_query->query_vars['user_page'] ) );
			
			
			} else {

				get_template_part('layouts/dashboard/user', $wp_query->query_vars['user_page'] );
			
			} 
		
		} else {

			get_template_part('layouts/profile');

		}

?>

	</div>

<?php if ( $upage_now != 'gruppy' ) { ?>
	<div class="right-container-wrapper t-d-view tab-por-no-view">
		asdas
	</div>
<?php } ?>
</div>
<!-- end .main-container -->


<?php get_footer(); ?>
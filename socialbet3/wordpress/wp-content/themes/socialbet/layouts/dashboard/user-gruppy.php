<?php
/**
 * user group
 * @ver 1.0
 */

global $wp_query, $profile_user, $user_data, $SocBet_Theme;
$groups = empty( $user_data['group_joined'] ) ? array() : maybe_unserialize( $user_data['group_joined'] );
$group_admin = empty( $user_data['group_admin'] ) ? array() : maybe_unserialize( $user_data['group_admin'] );
$sts = isset( $_GET['status'] ) ? $_GET['status'] : 'uchastiye';
$groupy = isset( $_GET['status'] ) && $_GET['status'] == 'upravleniye' ? $group_admin : $groups;
?>

<h1 class="fl wd-auto mg-top"><?php ( is_own_profile() ? printf( esc_html__('Мои группы %d', 'socialbet'), count($groups) ) : printf( esc_html__('Группы %d', 'socialbet'), count($groups) ) ); ?></h1>
	<div class="profile-groups-wrapper">
		<div class="fill-balance fr md-trigger" data-modal="modal-create-group">
			<?php esc_html_e('пополнить баланс', 'socialbet'); ?>
		</div>
		<div class="search-box2 fr mg-top">
			<form method="post" action="">
				<input type="text" name="s" placeholder="Начните вводить название">
				<button type="submit" class="search-button"><span class="icon-search"></span></button>
			</form>
		</div>
		<div class="filter-box mg-bottom fl">
			<ul>
				<li<?php if ( $sts == 'uchastiye' ) echo ' class="selected"'; ?>><a href="?status=uchastiye"><?php printf( esc_html__('Участие (%d)', 'socialbet'), count($groups) ); ?></a></li>
				<li<?php if ( $sts == 'upravleniye' ) echo ' class="selected"'; ?>><a href="?status=upravleniye"><?php printf( esc_html__('Управление (%d)', 'socialbet'), count($group_admin) ); ?></a></li>
			</ul>
		</div>

		<div class="groups-wrapper">
		<?php

			if ( empty($groupy) ) {
				
				print '<div class="clear"></div>';
				print __('No Groups Found!', 'socialbet');
			
			} else {

				$args = array(
					'hide_empty' => 0,
					'include'	=> $groupy
					);

				$listgroups = get_terms('group_name', $args);

				if ( ! empty( $listgroups ) && ! is_wp_error( $listgroups ) ){
		?>
			<ul>

				<?php
				foreach( $listgroups as $gr ) {
					$meta_group = get_option('taxonomy_meta_'.$gr->term_id);
					$thumbnail = "";
					$image = "";
					$member = '0';
					if( is_array($meta_group) && isset($meta_group['theme']) ) {
						$theme = $meta_group['theme'];
						$member = isset( $meta_group['subscriber'] ) ? $meta_group['subscriber'] : '0';
						$theme_meta = get_option('taxonomy_meta_'.$theme);
						
						if( is_array($theme_meta) ) {
							$thumbnail = isset($theme_meta['thumbnail']) ? wp_get_attachment_url( $theme_meta['thumbnail'] ) : '';
							$image = isset($theme_meta['image']) ? wp_get_attachment_thumb_url( $theme_meta['image'] ) : '';	
						}

						if ( isset( $meta_group['image'] ) && $meta_group['image'] != "" ) {
							$image = wp_get_attachment_url( $meta_group['image'] );	
						}
						if ( isset( $meta_group['thumbnail'] ) && $meta_group['thumbnail'] != "" ) {
							$thumbnail = wp_get_attachment_thumb_url( $meta_group['thumbnail'] );	
						}
					}
				?>
				<li class="fl">
					<div class="grp-img1"><img src="<?php echo $image; ?>"></div>
					<div class="grp-img2" style="background-image: url(<?php echo $thumbnail; ?>)"></div>
					<h2><a class="dark-link" href="<?php echo esc_url( get_term_link($gr) ); ?>"><?php print $gr->name; ?></a></h2>
					<p class="font12"><?php printf( __('%d участников', 'socialbet'), count($member) ); ?> </p>
					<div class="fill-balance">
						<?php esc_html_e('подписан', 'socialbet'); ?>
					</div>
					<div class="user-add mob-view no-bg brand-blue">
						<span class="icon-useradd"></span>
					</div>
				</li>

				<?php } ?>

			</ul>

		<?php
				}
			}
		?>
		</div>

	</div>
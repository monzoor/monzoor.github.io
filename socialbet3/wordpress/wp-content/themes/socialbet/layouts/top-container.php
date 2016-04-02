<?php
/**
 * top container template,
 * will use this in almost all pages
 *
 * @version 1.0
 */
?>

<!-- Right top container -->
<div class="right-top-container">
	<!-- Top navigation -->
	<div class="top-navigation-wrapper">
		<span class="icon-burgerbutton mob-nav"></span>
		<div class="left-nav-box pos-rel">
			<ul>
				<li class="t-d-view mob-view">
					<a onClick="return true" href="" class="mob-head mob-view">разделы<span class="icon-arrowdropdown"></span></a>
					<?php socbet_theme_top_nav_menus(); ?>
				</li>
			</ul>
			
		</div>
		<div class="search-box t-d-view">
			<form method="get" action="<?php echo home_url('/'); ?>">
				<input type="text" name="s" value="">
				<button type="submit" class="search-button"><span class="icon-search"></span></button>
			</form>
		</div>
		<?php if ( is_user_logged_in() ) {?>
		<div class="toggle-box only-mob-hide">
			<label class="switch-light switch-ios" style="width: 100px" onclick="">
	        	<input type="checkbox">
        		<span>
            	&nbsp;
            		<span><?php print __('Профи', 'socialbet'); ?></span>
		            <span><?php print __('Любитель', 'socialbet'); ?></span>
          		</span>
	         	<a></a>
        	</label>
		</div>
		<?php } ?>
		<div class="top-right-nav">
			<ul>
			<?php if ( !is_user_logged_in() ) {?>
				<li class="fr"><a><span class="icon-enter md-trigger" data-modal="modal-4"></span></a></li>
			<?php } else {	
					global $current_user;
					get_currentuserinfo();
				?>
				<li class="<?php if ( is_own_profile() && !is_socbet_user_settings_page() ) echo 'selected '; ?>pos-rel">
					<a href="<?php socbet_loggedin_profile_url(); ?>"><span class="icon-profile"></span></a>
					<div class="notification-counter"><span>12</span></div>
				</li>
				<li class="<?php if ( is_own_profile() && is_socbet_user_settings_page() == 'moi-soobshcheniya' ) echo 'selected '; ?>">
					<a href="<?php echo get_socbet_user_dashboard_url( $current_user->ID, 'moi-soobshcheniya'); ?>"><span class="icon-message"></span></a>
				</li>
				<li>
					<a href=""><span class="icon-notifications"></span></a>
				</li>
				<li class="<?php if ( is_own_profile() && is_socbet_user_settings_page() == 'moi-nastroyki' ) echo 'selected '; ?>">
					<a href="<?php echo get_socbet_user_dashboard_url( $current_user->ID, 'moi-nastroyki'); ?>"><span class="icon-settings"></span></a>
				</li>
				<li>
					<a href="<?php echo esc_url( wp_logout_url( home_url() ) ); ?>"><span class="icon-exit"></span></a>
				</li>
			<?php } ?>
			</ul>
		</div>
		<div class="search-button md-trigger tab-por-view mob-view" data-modal="modal-1"><span class="icon-search"></span></div>
	</div>
	<!-- End of top navigation -->
</div>
<!-- End of Right top Container -->
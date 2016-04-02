<?php
/**  
 * Functions related to theme's menus
 * 
 * @since version 1.0
 */

/**
 * Top menus
 *
 * @return string (HTML of menu lists)
 */
function socbet_theme_top_nav_menus() {
	if ( socbet_have_custom_menu('top') ) {

	    $main_nav_args = array(
	      'container'       => '',
		  'menu_class'      => 'topmenu', 
		  'menu_id'         => 'topnav',
	      'items_wrap'		=> '<ul id="%1$s" class="%2$s" itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement">%3$s</ul>',
	      'echo'            => true,
	      'depth'           => 0,
	      'theme_location'  => 'top'
	    );
	    
	    wp_nav_menu($main_nav_args);

	} else {
		print '<ul id="topnav"><li><a href="' . get_admin_url() . 'nav-menus.php">' . __('No top menu', 'socialbet') . '</a></li></ul>' . "\n";
	}
}
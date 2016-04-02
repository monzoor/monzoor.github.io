<?php
/**
 * Admin page
 *
 */

if ( ! defined('ABSPATH') )
	exit;

if( ! class_exists('Socbet_Admin') ) {

class Socbet_Admin {
	public $admin_pages = array();
	private $max_num_pages = 0;

	/**
	 * init class
	 *
	 * @access public
	 * @return void
	 */
	public static function init() {
		ob_start();

		static $instance = false;

		if ( ! $instance )
			$instance = new Socbet_Admin;

		return $instance;
	}


	public function Socbet_Admin() {
		$this->admin_includes();
		$this->admin_init();
	}

	/** 
	 * admin init actions
	 *
	 * @access public
	 * @return void
	 */
	public function admin_init() {
		$this->max_pages();
		add_action( 'admin_menu', array($this,'build_admin_menu') );
		add_action( 'admin_enqueue_scripts', array($this,'admin_enqueue_scripts') );
	}


	function admin_includes() {
		require_once( get_template_directory() .'/inc/admin/admin-functions.php' );
	}

	/**
	 * Register new admin menu for theme settings
	 *
	 * @return void
	 */
	public function build_admin_menu() {
		$this->admin_pages[] = add_menu_page( esc_html__( 'Theme Settings', 'socialbet' ), esc_html__( 'SocialBet', 'socialbet' ), 'edit_users', 'socbet-theme-settings' , array(&$this,'admin_settings') );
		$this->admin_pages[] = add_submenu_page( 'socbet-theme-settings', esc_html__( 'Theme Settings', 'socialbet' ),  esc_html__( 'Theme Settings', 'socialbet' ) , 'edit_users', 'socbet-theme-settings', array(&$this,'admin_settings') );
		$this->admin_pages[] = add_submenu_page( 'socbet-theme-settings', esc_html__( 'Email Settings', 'socialbet' ),  esc_html__( 'Email Settings', 'socialbet' ) , 'edit_users', 'socbet-email-settings', array(&$this,'email_settings') );
		$this->admin_pages[] = add_submenu_page( 'socbet-theme-settings', esc_html__( 'Email Lists', 'socialbet' ),  esc_html__( 'Email Lists', 'socialbet' ) , 'edit_users', 'socbet-email-listing', array(&$this,'email_listing') );
	}

    public function admin_enqueue_scripts( $hook ) {
        if ( ! in_array( $hook, $this->admin_pages ) )
            return;

        wp_enqueue_style( 'socbet_admin',get_template_directory_uri() . '/inc/admin/css/settings.css', '', SBSOON_VERSION );
    }


    public function email_listing() {
    	global $wpdb, $max_pages;

		if ( isset( $_GET['action'] ) && $_GET['action'] == 'delete' ) {
	
			// check for security
	    	if ( empty( $_GET['_wpnonce'] ) || ! wp_verify_nonce( $_GET['_wpnonce'], 'socbet-remove-email' ) ) {
				wp_safe_redirect( admin_url( 'admin.php?page=socbet-email-listing' ) );
				exit;
	    	}

	    	$emid = esc_sql( isset( $_GET['eid'] ) ? absint( $_GET['eid'] ) : '0');

	    	//remove odds
	    	$wpdb->delete( $wpdb->prefix."socbet_subscribes", array( 'id' => $emid ), array( '%d' ) );

			wp_safe_redirect( admin_url( 'admin.php?page=socbet-email-listing&removed=1' ) );
			exit; 
		}

    	$max_pages = $this->max_num_pages;
    	$tablename = $wpdb->prefix . "socbet_subscribes";
    	$paged = 1;
    	if ( isset( $_GET['paged'] ) ) {
    		$paged = absint( $_GET['paged'] );
    	}
        $diff = (int) ( ( $paged - 1 ) * 20 );
    	$limits = "LIMIT $diff, 20";
    	$emails = $wpdb->get_results( "SELECT * FROM {$tablename} ORDER BY id DESC $limits" );

    	?>
	<div class="wrap">

		<h2><?php print __('Email Lists', 'socialbet'); ?> </h2>

		<div id="socbet-body">
			<?php
				if ( isset( $_GET['removed'] ) && $_GET['removed'] == '1' ) {
					echo '<div id="message" class="updated fade"><p><strong>' . esc_html__('Email removed from list.', 'socialbet') . '</strong></p></div>';
				}
		
		if ( $emails ) {
			?>

			<table class="wp-list-table widefat fixed">
				<thead>
					<tr>
						<th scope="col" class="manage-column"><?php print esc_html__('Email', 'socialbet'); ?></th>
						<th scope="col" class="manage-column"><?php print esc_html__('Subscribed Time', 'socialbet'); ?></th>
						<th scope="col" class="manage-column"><?php print esc_html__('Status', 'socialbet'); ?></th>
						<th scope="col" class="manage-column"><?php print esc_html__('Action', 'socialbet'); ?></th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th scope="col" class="manage-column"><?php print esc_html__('Email', 'socialbet'); ?></th>
						<th scope="col" class="manage-column"><?php print esc_html__('Subscribed Time', 'socialbet'); ?></th>
						<th scope="col" class="manage-column"><?php print esc_html__('Status', 'socialbet'); ?></th>
						<th scope="col" class="manage-column"><?php print esc_html__('Action', 'socialbet'); ?></th>
					</tr>
				</tfoot>
				<tbody>
					<?php
					foreach( $emails as $email ) { ?>
					<tr>
						<td><?php echo $email->email; ?></td>
						<td><?php echo date('dS F Y', strtotime($email->registered)); ?></td>
						<td><?php echo ( $email->email_status == '0' ? '<span class="info-box danger">' . esc_html__( 'Unverified', 'socialbet' ) : '<span class="info-box success">' . esc_html__( 'Verified', 'socialbet' ) ); ?></span></td>
						<td><a href="<?php echo wp_nonce_url( admin_url("admin.php?page=socbet-email-listing&eid={$email->id}&action=delete"), 'socbet-remove-email', '_wpnonce'); ?>"><?php print __( 'Remove', 'socialbet' ); ?></a></td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
			<?php
					if( $max_pages > 1 ) {
						$this->display_pages( $max_pages, $paged );
					}


				} else {

					echo '<div id="error" class="error fade"><p><strong>' . __('No data.', 'socialbet') . '</strong></p></div>';
				}

			?>

		</div>

	</div>
    	<?php
    }


    private function max_pages() {
    	global $wpdb;

    	$tablename = $wpdb->prefix . "socbet_subscribes";
    	$count = $wpdb->get_var( "SELECT COUNT(*) FROM $tablename" );

    	if ( $count ) {
    		$this->max_num_pages = ceil( $count / 20 );
    	}
    }


    public function display_pages( $max , $paged) {

    	$pagi = '<ul class="pagination">' . "\n";
    	for( $i=1; $i<=$max; $i++ ) {
    		$pagi .= '<li'. ($paged == $i ? ' class="active"' : '') .'><a href="'.add_query_arg( array('paged'=>$i), admin_url( 'admin.php?page=socbet-email-listing' ) ).'">'.$i.'</a></li>' . "\n";
    	}
    	unset($i);
    	$pagi .= '</ul>';

    	echo $pagi;

    }

	/**
	 * Settings page
	 *
	 */
	public function admin_settings() {
		$http_post = ('POST' == $_SERVER['REQUEST_METHOD']);
		$settings = get_socbet_settings();

		if ( $http_post ) {

			if ( empty( $_POST['_wpnonce'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], 'socbet-admin-settings' ) ) {
				wp_die( __('Security check failed!', 'socialbet') );
			}

			foreach ($settings as $set) {
				if ( isset($set['setting_id']) && isset($_POST[$set['setting_id']]) ) {
					if ( "" == $_POST[$set['setting_id']] ) {
						delete_option( $set['setting_id'] );
					} else {
						update_option( $set['setting_id'], $_POST[$set['setting_id']] );
					}
				}
			}
			unset($set);

			$redirect = add_query_arg( 'saved', 'true', admin_url( 'admin.php?page=socbet-theme-settings' ) );

			wp_safe_redirect( $redirect );
			exit;
		}

		?>
	<div class="wrap">

		<h2><?php print __('Content Settings', 'socialbet'); ?> </h2>

       <div id="socbet-body">

		<?php
		if ( isset($_GET['saved']) && $_GET['saved'] == 'true' ) {
			echo '<div id="message" class="updated fade"><p><strong>' . __('Settings saved.', 'socialbet') . '</strong></p></div>';
		}
		?>

            <form action="<?php echo admin_url('admin.php?page=socbet-theme-settings'); ?>" method="post">
            	
            	<?php wp_nonce_field( 'socbet-admin-settings', '_wpnonce', true, true ); ?>
            	
            	<?php
            		foreach( $settings as $setting ) {
            			echo '<div class="setting-box '. ( isset($setting['type']) && !empty($setting['type']) ? $setting['type'] : '' ) .'">';
            			if ( isset($setting['label']) && !empty($setting['label']))
            				echo '<h3>' . stripslashes($setting['label']) . '</h3>';

            			$this->field_machine( $setting );
            			echo '</div>';
            		}
            		unset($setting);
            	?>

            	<input type="submit" name="submit" class="button button-primary" value="<?php esc_attr_e('Save Settings', 'socialbet'); ?>" />
    	    </form>

        </div>

	</div>
		<?php
	}


	/**
	 * email settings page
	 *
	 */
	public function email_settings() {
		$http_post = ('POST' == $_SERVER['REQUEST_METHOD']);
		$settings = get_socbet_email_settings();

		if( $http_post ) {

			if ( empty( $_POST['_wpnonce'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], 'socbet-email-settings' ) ) {
				wp_die( __('Security check failed!', 'socialbet') );
			}

			foreach ($settings as $set) {
				if ( isset($set['setting_id']) && isset($_POST[$set['setting_id']]) ) {
					if ( "" == $_POST[$set['setting_id']] ) {
						delete_option( $set['setting_id'] );
					} else {
						update_option( $set['setting_id'], $_POST[$set['setting_id']] );
					}
				}
			}
			unset($set);

			$redirect = add_query_arg( 'saved', 'true', admin_url( 'admin.php?page=socbet-email-settings' ) );

			wp_safe_redirect( $redirect );
			exit;
		}

		?>
	<div class="wrap">

		<h2><?php print __('Email Settings', 'socialbet'); ?> </h2>

       <div id="socbet-body">

		<?php
		if ( isset($_GET['saved']) && $_GET['saved'] == 'true' ) {
			echo '<div id="message" class="updated fade"><p><strong>' . __('Settings saved.', 'socialbet') . '</strong></p></div>';
		}
		?>

            <form action="<?php echo admin_url('admin.php?page=socbet-email-settings'); ?>" method="post">
            	
            	<?php wp_nonce_field( 'socbet-email-settings', '_wpnonce', true, true ); ?>
            	
            	<?php
            		foreach( $settings as $setting ) {
            			echo '<div class="setting-box '. ( isset($setting['type']) && !empty($setting['type']) ? $setting['type'] : '' ) .'">';
            			if ( isset($setting['label']) && !empty($setting['label']))
            				echo '<h3>' . stripslashes($setting['label']) . '</h3>';

            			$this->field_machine( $setting );
            			echo '</div>';
            		}
            		unset($setting);
            	?>

            	<input type="submit" name="submit" class="button button-primary" value="<?php esc_attr_e('Save Settings', 'socialbet'); ?>" />
    	    </form>

        </div>

	</div>
		<?php
	}


    /**
     * Create a field based on the field type passed in.
     */
    public function field_machine($args) {
        extract($args);
    	$value = get_option( $setting_id );
    	switch($type){
    	    case 'textbox':
    	        echo "<input id='$id' class='".(empty($class) ? 'regular-text' : $class)."' name='{$setting_id}' type='text' value='".esc_attr(empty($value) ? $default_value : $value)."' />
    	        <br><small class='description'>".(empty($desc) ? '' : $desc)."</small>";
    	        break;
    	    case 'email':
    	        echo "<input id='$id' class='".(empty($class) ? 'regular-text' : $class)."' name='{$setting_id}' type='email' value='".esc_attr(empty($value) ? $default_value : $value)."' />
    	        <br><small class='description'>".(empty($desc) ? '' : $desc)."</small>";
    	        break;
    	    case 'textarea':
                echo "<textarea id='$id' class='".(empty($class) ? '' : $class)."' name='{$setting_id}'>".esc_textarea( stripslashes( empty($value) ? $default_value : $value ) )."</textarea>
    	        <br><small class='description'>".(empty($desc) ? '' : $desc)."</small>";
    	        break;

            case 'wpeditor':
                $content   = esc_textarea( empty($value) ? $default_value : $value );
                $editor_id = 'editor_'.$setting_id;
                $args      = array(
                     'textarea_name' => "{$setting_id}"
                );

                wp_editor( $content, $editor_id, $args );

                break;
    	    case 'radio':
    	        foreach($option_values as $k=>$v){
    	            echo "<input type='radio' name='{$setting_id}' value='$k'".((empty($value) ? $default_value : $value) == $k ? 'checked' : '')."  /> $v<br/>";
                }
    	        echo "<small class='description'>".(empty($desc) ? '' : $desc)."</small>";
    	        break;
    	    case 'checkbox':
    	        $count = 0;
    	        foreach($option_values as $k=>$v){
    	            echo "<input type='checkbox' name='{$setting_id}[]' value='$k'".(in_array($k,(empty($value) ? (empty($default_value) ? array(): $default_value) : $value)) ? 'checked' : '')."  /> $v<br/>";
                    $count++;
                }
    	        echo "<small class='description'>".(empty($desc) ? '' : $desc)."</small>";
    	        break;
    	    case 'section':
    	    	echo '<h2 class="section-title">' . stripslashes($title) . '</h2>';
    	    	break;
    	}

    }
}

add_action( 'init', array('Socbet_Admin','init') );

}
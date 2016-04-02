<?php
/**
 * Main class for admin
 */

if ( ! defined( 'ABSPATH' ) )
	exit;

if ( ! class_exists('Socbet_Admin') ) {

class Socbet_Admin {
	
	public $_metaboxes;

	/**
	 * init class
	 *
	 * @access public
	 * @return void
	 */
	public static function init() {
		ob_start();

		static $instance = false;

		if ( !$instance ) {
			$instance = new Socbet_Admin;
		}

		return $instance;
	}

	public function Socbet_Admin() {
		$this->admin_includes();
		$this->admin_init();
	}

	/** 
	 * Call required files for admin
	 *
	 * @access public
	 * @return void
	 */
	public function admin_includes() {
		require_once( get_template_directory() . '/inc/admin/class-admin-menus.php' );
		require_once( get_template_directory() . '/inc/admin/metabox.class.php' );
		require_once( get_template_directory() . '/inc/admin/metabox.option.php' );
		require_once( get_template_directory() . '/inc/admin/metabox.function.php' );
		require_once( get_template_directory() . '/inc/admin/custom-post-edit-columns.php' );
	}

	/** 
	 * admin init actions
	 *
	 * @access public
	 * @return void
	 */
	public function admin_init() {
		$this->_metaboxes = new Socbet_Post_Metabox();

		add_action( 'add_meta_boxes', array($this, 'create_metaboxes') );
		add_action( 'save_post', array($this, 'save_event_metabox'), 1, 2 );
		add_action( 'save_post', array($this, 'save_competition_metabox'), 1, 2 );
		add_action( 'before_delete_post',array($this, 'double_check_before_delete') );
			
		add_action( "admin_print_styles-event_page_create-market", array($this, 'metabox_print_scripts') );
		add_action( "admin_print_styles-event_page_edit-market", array($this, 'metabox_print_scripts') );
		add_action( "admin_print_styles-event_page_show-markets", array($this, 'metabox_print_scripts') );
		add_action( "admin_print_styles-edit-tags.php", array($this, 'metabox_print_scripts') );
		add_action( "admin_print_styles-post.php", array($this, 'metabox_print_scripts') );
		add_action( "admin_print_styles-post-new.php", array($this, 'metabox_print_scripts') );
	}

	/**
	 * add new metaboxes
	 *
	 * @return void
	 */
	public function create_metaboxes() {
		if ( function_exists('add_meta_box') ) {
			global $_wp_post_type_features;

			if ( post_type_exists('event') ) {
				if ( isset($_wp_post_type_features['event']['editor']) && $_wp_post_type_features['event']['editor'] ) {
					// remove the default wp editor
					unset($_wp_post_type_features['event']['editor']);
					add_meta_box( 'new-meta-event', __('Event Info', 'socialbet'), array($this, 'event_metabox_content'), 'event', 'normal', 'high' );
					add_meta_box( 'description_section', __('Description', 'socialbet'), array($this, 'inner_custom_box'), 'event', 'normal', 'high' );
				}

				add_meta_box( 'markets-meta-event', __('Event Markets', 'socialbet'), array($this, 'event_metabox_markets_content'), 'event', 'normal', 'high' );
				add_meta_box( 'tips-meta-event', __('Tips', 'socialbet'), array($this, 'event_metabox_tips_content'), 'event', 'normal', 'high' );
			}

			if ( post_type_exists('competition') ) {
				add_meta_box( 'competition-meta-data', __('Competition Data', 'socialbet'), array($this, 'competition_metabox_content'), 'competition', 'normal', 'high' );
			}
		}
	}

	public function inner_custom_box() {
		global $post;

		echo '<div class="wp-editor-wrap">';

		wp_editor( $post->post_content, 'content', array('dfw' => true, 'tabindex' => 1) );

		echo '<div class="clear"></div>';
		echo '</div>';
	}

	/**
	 * metabox
	 *
	 * @return void
	 */
	public function event_metabox_content() {
		return $this->_metaboxes->metabox_builder( socbet_event_meta_options() );
	}

	/**
	 * metabox
	 *
	 * @return void
	 */
	public function event_metabox_tips_content() {
		return $this->_metaboxes->metabox_builder( socbet_event_tiplist_options() );
	}

	/**
	 * metabox
	 *
	 * @return void
	 */
	public function event_metabox_markets_content() {
		return $this->_metaboxes->metabox_builder( socbet_event_marketlist_options() );
	}


	public function competition_metabox_content() {
		return $this->_metaboxes->metabox_builder( socbet_competition_options() );
	}

	/**
	 * Print js and css for metabox
	 *
	 * @return void
	 */
	public function metabox_print_scripts() {
		global $post;
		
		if ( !empty($post) && ( $post->post_type == 'event' || $post->post_type == 'competition' ) ) {
			global $wp_version, $wp_scripts;

			wp_enqueue_script( 'jquery', 'jquery-ui-core', 'jquery-ui-slider', 'jquery-ui-datepicker' );
			wp_enqueue_script( 'jquery-ui-timepicker-addon', get_template_directory_uri() . '/inc/admin/js/time-picker-addon.js', array('jquery', 'jquery-ui-core', 'jquery-ui-slider', 'jquery-ui-datepicker' ), SOCIALBET_VERSION );
			wp_enqueue_script( 'socbet-admin-helper', get_template_directory_uri() . '/inc/admin/js/admin.js', array('jquery-ui-timepicker-addon'), SOCIALBET_VERSION );

			wp_enqueue_style( 'jquery-ui-css', 'https://code.jquery.com/ui/1.11.2/themes/cupertino/jquery-ui.css', '', SOCIALBET_VERSION  );
			wp_enqueue_style( 'socbet-admin-metabox', get_template_directory_uri() . '/inc/admin/css/metabox.css', '', SOCIALBET_VERSION );

		} else if ( isset($_GET['page']) && ( $_GET['page'] == 'create-market' || $_GET['page'] == 'edit-market' || $_GET['page'] == 'show-markets' ) ) {
			
			wp_enqueue_script( 'jquery' );
			wp_enqueue_script( 'socbet-admin-helper', get_template_directory_uri() . '/inc/admin/js/admin.js', array('jquery'), SOCIALBET_VERSION );
			wp_localize_script( 'socbet-admin-helper', 'sbL10n', array(
				'errorMarketEntry' => __('Entry name and odds fields are required!', 'socialbet'),
				'edit' => __('Edit', 'socialbet'),
				'delete' => __('Delete', 'socialbet'),
				'saveChanges' => __('Save Changes', 'socialbet')
				)
			);
			wp_enqueue_style( 'socbet-admin-metabox', get_template_directory_uri() . '/inc/admin/css/metabox.css', false, SOCIALBET_VERSION );
		} else if ( isset($_GET['taxonomy']) && $_GET['taxonomy'] == 'group_theme' ) {
			wp_enqueue_script( 'jquery' );
			wp_enqueue_media();
			wp_enqueue_script( 'socbet-tax-helper', get_template_directory_uri() . '/inc/admin/js/admin-taxs.js', array('jquery'), SOCIALBET_VERSION );
			wp_enqueue_style( 'socbet-tax-metabox', get_template_directory_uri() . '/inc/admin/css/admin-taxs.css', false, SOCIALBET_VERSION );
		}
	}

	/**
	 * Save event post metabox
	 *
	 * @return void
	 */
	function save_event_metabox( $postID, $post ) {
		global $wpdb;
		
		// no $_POST ?
		if ( !$_POST ) {
			return $postID;
		}
		// autosave?
		if ( is_int( wp_is_post_autosave( $postID ) ) ) {
			return;
		}
		// again, autosave?
		if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
			return;
		}
		// dont have role to edit event ?
		if ( ! current_user_can( 'edit_event', $postID ) ) {
			return $postID;
		}
		// not event post type ?
		if ( isset($_POST['post_type']) && ( 'event' != $_POST['post_type'] ) ) {
			return;
		}

		if ( isset($_POST['update']) || isset($_POST['save']) || isset($_POST['publish']) ) {
			$options = socbet_event_meta_options();

			foreach( $options as $key => $meta_option ) {

				$meta_id = isset( $meta_option['id'] ) ? $meta_option['id'] : 'undefined';
				
				$data = "";
				if ( isset( $_POST[$meta_id] ) ) {
					$data = $_POST[$meta_id];
				}
				
				if( $meta_id == '_'.SOCIALBET_NAME.'_event_datetime' ) {
					if ( $data != "" ) {
						$data = date('Y-m-d H:i:s', strtotime($data.':00') );
					}
				}

				if ( get_post_meta($postID, $meta_id) == "" )
					add_post_meta($postID, $meta_id, $data, true);
				elseif ( $data != get_post_meta( $postID, $meta_id, true ) )
					update_post_meta( $postID, $meta_id, $data );
				elseif ( $data == "" )
					delete_post_meta( $postID, $meta_id, get_post_meta( $postID, $meta_id, true ) );

			}
			unset($key);
			unset($meta_option);
		}
	}

	/**
	 * Save competition post metabox
	 *
	 * @return void
	 */
	public function save_competition_metabox( $postID, $post ) {
		global $wpdb;
		
		// no $_POST ?
		if ( !$_POST ) {
			return $postID;
		}
		// autosave?
		if ( is_int( wp_is_post_autosave( $postID ) ) ) {
			return;
		}
		// again, autosave?
		if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
			return;
		}
		// dont have role to edit competition ?
		if ( ! current_user_can( 'edit_competition', $postID ) ) {
			return $postID;
		}
		// not competition post type ?
		if ( isset($_POST['post_type']) && ( 'competition' != $_POST['post_type'] ) ) {
			return;
		}

		if ( isset($_POST['update']) || isset($_POST['save']) || isset($_POST['publish']) ) {
			$options = socbet_competition_options();

			foreach( $options as $key => $meta_option ) {

				$meta_id = isset( $meta_option['id'] ) ? $meta_option['id'] : 'undefined';
				
				$data = "";
				if ( isset( $_POST[$meta_id] ) ) {
					$data = $_POST[$meta_id];
				}

				if( $meta_id == '_'.SOCIALBET_NAME.'_competition_end' ) {
					if ( $data != "" ) {
						$data = date('Y-m-d H:i:s', strtotime($data.':00') );
					}
				}

				// set the term based on price value
				if( $meta_id == '_'.SOCIALBET_NAME.'_competition_price' ) {
					if ( $data == "" || $data == '0' ) {
						wp_set_object_terms( $postID, array(esc_html('Бесплатные')), 'competition_type', false );
					} else {
						wp_set_object_terms( $postID, array(esc_html('Платные')), 'competition_type', false );
					}
				}
			
				if ( get_post_meta($postID, $meta_id) == "" )
					add_post_meta($postID, $meta_id, $data, true);
				elseif ( $data != get_post_meta( $postID, $meta_id, true ) )
					update_post_meta( $postID, $meta_id, $data );
				elseif ( $data == "" )
					delete_post_meta( $postID, $meta_id, get_post_meta( $postID, $meta_id, true ) );

			}
			unset($key);
			unset($meta_option);
		}
	}

	public function double_check_before_delete( $postID ) {
		global $post_type;

		// if the deleted post is not event post, let it go
		if ( $post_type != 'event' )
			return;

		// get all custom post type name
		$tip_cpt = get_post_meta( $postID, '_cpt_tip_name', true );
		$prev_tip_cpts = get_option( 'socbet_tips_cpt' );

		if ( is_array( $prev_tip_cpts ) && array_key_exists($tip_cpt, $prev_tip_cpts) ) {
			unset( $prev_tip_cpts[$tip_cpt] );

			if ( count($prev_tip_cpts) < 1 ) {
				delete_option('socbet_tips_cpt');
			} else {
				update_option( 'socbet_tips_cpt', $prev_tip_cpts );
			}
			
		}

		// remove all custom data!
		delete_post_meta( $postID, '_cpt_tip_name', get_post_meta( $postID, '_cpt_tip_name', true ) );
		delete_post_meta( $postID, '_has_custom_post_types', get_post_meta( $postID, '_has_custom_post_types', true ) );
		delete_post_meta( $postID, '_'.SOCIALBET_NAME.'_event_datetime', get_post_meta( $postID, '_'.SOCIALBET_NAME.'_event_datetime', true ) );

		return;
	}
}

add_action( 'init', array('Socbet_Admin', 'init') );

}
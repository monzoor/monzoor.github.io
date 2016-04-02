<?php
/**
 * Custom post types class
 *
 * @since version 1.0
 */

if ( ! defined('ABSPATH') )
	exit;

if ( ! class_exists('Socbet_Custom_Cpt') ) {

class Socbet_Custom_Cpt {

	private $custom_post_tips;

	public function __construct() {
		// get all tip custom post types data
		$this->custom_post_tips = get_option('socbet_tips_cpt');

		if ( is_admin() ) {
			add_action( 'admin_menu', array( $this, 'remove_menu_page' ) );
			// save new post types name, and parent id
			// we will create unique post type for each event post
			add_action( 'save_post', array( $this, 'inject_more_cpt' ), 1, 2 );
		}

	}

	public function remove_menu_page() {
		if ( empty( $this->custom_post_tips ) )
			return;

		//print_r( $all_merges );
		foreach( $this->custom_post_tips as $cptname => $details ) {
			remove_menu_page('edit.php?post_type='.$cptname);
			remove_menu_page('post-new.php?post_type='.$cptname);
		}
		unset($cptname);
		unset($details);
	}

	public function register_custom_post_types() {
		$this->create_base_custonomies();
		$this->create_base_custom_post();
		$this->create_terms();
		$this->pre_register_tips_cpt();
	}

	/**
	 * Automatic create custom post types
	 *
	 * @return void
	 */
	public function pre_register_tips_cpt() {
		// still no data
		if ( empty( $this->custom_post_tips ) )
			return;

		foreach( $this->custom_post_tips as $cptname => $cpt_details ) {
			$parent_id = isset( $cpt_details['parent_id'] ) ? intval( $cpt_details['parent_id'] ) : 0;
			$name = isset( $cpt_details['cpt_name'] ) ? $cpt_details['cpt_name'] : 0;

			if ( ! $parent_id || ! $name )
				continue;

			if ( post_type_exists($name) )
				continue;

			// get the data from event parent
			$post_parent = get_post( $parent_id );

			// should never happen, but in case the db is become crap - well, or maybe another bugs?
			if ( 'event' != $post_parent->post_type )
				continue;

			$slugs = 'event-tip/'.socbet_terms_slug_tree( 'sport_type', $post_parent->ID ).'/'.$post_parent->post_name.'/';
			$archive_slug = $post_parent->post_name . "-tips";
				
			register_post_type( $name,
				array(
					'labels' => array(
							'name'               => sprintf(__( '"%s" Event Tips', 'socialbet' ), $post_parent->post_title),
							'singular_name'      => __( 'Event Tip', 'socialbet' ),
							'menu_name'          => _x( 'Event Tips', 'Admin menu name', 'socialbet' ),
							'add_new'            => __( 'Add New', 'socialbet' ),
							'add_new_item'       => sprintf( __( 'Add New Event Tip for "%s"', 'socialbet' ), $post_parent->post_title),
							'edit'               => __( 'Edit', 'socialbet' ),
							'edit_item'          => __( 'Edit Event Tip', 'socialbet' ),
							'new_item'           => __( 'New Event Tip', 'socialbet' ),
							'view'               => __( 'View Event Tip', 'socialbet' ),
							'view_item'          => __( 'View Event Tip', 'socialbet' ),
							'search_items'       => __( 'Search Event Tips', 'socialbet' ),
							'not_found'          => __( 'No Event Tips found', 'socialbet' ),
							'not_found_in_trash' => __( 'No Event Tips found in trash', 'socialbet' ),
							'parent'             => __( 'Parent Event Tip', 'socialbet' )
						),
					'description'         => __( 'This is where you can add tip for each event.', 'socialbet' ),
					'public'              => true,
					'show_ui'             => true,
					'capability_type'     => 'event',
					'map_meta_cap'        => true,
					'publicly_queryable'  => true,
					'exclude_from_search' => false,
					'hierarchical'        => false,
					'rewrite'             => array( 'slug' => untrailingslashit( $slugs ), 'with_front' => false, 'feeds' => true ),
					'query_var'           => true,
					'supports'            => array( 'title', 'editor', 'comments' ),
					'has_archive'         => $archive_slug,
					'show_in_nav_menus'   => false
				)
			);

		}
		unset($cptname);
		unset($cpt_details);
	}

	/**
	 * save custom post types data (unique name, and parent id)
	 *
	 * @return void
	 */
	public function inject_more_cpt( $postID, $post ) {
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

		// user update, save and publish the post
		if ( isset( $_POST['update'] ) || isset( $_POST['save'] ) || isset( $_POST['publish'] ) ) {
			// check if previously we have save the custom post types data
			$already_registered = get_post_meta( $postID, '_has_custom_post_types', true );

			// ignore this post
			if ( $already_registered == 'yes' )
				return $postID;

			$prev_tip_cpts = get_option( 'socbet_tips_cpt' );
			$parent_post = get_post( $postID );

			$tip_cpt = array(
				'event_tip_'.$postID => array('parent_id' => $postID, 'cpt_name' => 'event_tip_'.$postID )
			);
			

			if ( is_array( $prev_tip_cpts ) ) {
				$prev_tip_cpts = $prev_tip_cpts + (array) $tip_cpt;
			} else {
				$prev_tip_cpts = $tip_cpt;
			}

			update_option( 'socbet_tips_cpt', $prev_tip_cpts );
			update_post_meta( $postID, '_cpt_tip_name', 'event_tip_'.$postID );
			update_post_meta( $postID, '_has_custom_post_types', 'yes' );
		}

	}


	function create_base_custonomies() {
		if ( taxonomy_exists( 'sport_type' ) ) {
			return;
		}

		register_taxonomy('sport_type', array('event'), 
			array(
	            'hierarchical' 			=> true,
	            'label' 				=> __( 'Sport Types', 'socialbet'),
	            'labels' => array(
	                    'name' 				=> __( 'Sport Types', 'socialbet'),
	                    'singular_name' 	=> __( 'Sport Type', 'socialbet'),
						'menu_name'			=> _x( 'Sport Types', 'Admin menu name', 'socialbet' ),
	                    'search_items' 		=> __( 'Search Sport Types', 'socialbet'),
	                    'all_items' 		=> __( 'All Sport Types', 'socialbet'),
	                    'parent_item' 		=> __( 'Parent Sport Type', 'socialbet'),
	                    'parent_item_colon' => __( 'Parent Sport Type:', 'socialbet'),
	                    'edit_item' 		=> __( 'Edit Sport Type', 'socialbet'),
	                    'update_item' 		=> __( 'Update Sport Type', 'socialbet'),
	                    'add_new_item' 		=> __( 'Add New Sport Type', 'socialbet'),
	                    'new_item_name' 	=> __( 'New Sport Type Name', 'socialbet')
	            	),
	            'show_ui' 				=> true,
	            'query_var' 			=> true,
	            'capabilities'			=> array(
	            	'manage_terms' 		=> 'manage_event_terms',
					'edit_terms' 		=> 'edit_event_terms',
					'delete_terms' 		=> 'delete_event_terms',
					'assign_terms' 		=> 'assign_event_terms',
	            ),
	            'rewrite' 				=> array(
	            	'slug' => 'sport-type',
	            	'with_front' => false,
	            	'hierarchical' => true
	            ),
	        )
	    );

		register_taxonomy( 'competition_type', array('competition'),
			array(
				'hierarchical' => false,
				'show_ui' => false,
				'show_in_nav_menus' => true,
				'query_var' => true,
				'rewrite' => array(
					'slug' => 'konkursy',
					'with_front' => false,
					'hierarchical' => false
					),
				'public' => true
		    )
		);

		register_taxonomy('group_name', array('group-post'), 
			array(
	            'hierarchical' 			=> true,
	            'label' 				=> __( 'Group Name', 'socialbet'),
	            'labels' => array(
	                    'name' 				=> __( 'Groups', 'socialbet'),
	                    'singular_name' 	=> __( 'Group', 'socialbet'),
						'menu_name'			=> _x( 'Groups', 'Admin menu name', 'socialbet' ),
	                    'search_items' 		=> __( 'Search Groups', 'socialbet'),
	                    'all_items' 		=> __( 'All Groups', 'socialbet'),
	                    'parent_item' 		=> __( 'Parent Group', 'socialbet'),
	                    'parent_item_colon' => __( 'Parent Group:', 'socialbet'),
	                    'edit_item' 		=> __( 'Edit Group', 'socialbet'),
	                    'update_item' 		=> __( 'Update Group', 'socialbet'),
	                    'add_new_item' 		=> __( 'Add New Group', 'socialbet'),
	                    'new_item_name' 	=> __( 'New Group Name', 'socialbet')
	            	),
	            'show_ui' 				=> true,
	            'query_var' 			=> true,
	            'capabilities'			=> array(
	            	'manage_terms' 		=> 'manage_grouppost_terms',
					'edit_terms' 		=> 'edit_grouppost_terms',
					'delete_terms' 		=> 'delete_grouppost_terms',
					'assign_terms' 		=> 'assign_grouppost_terms',
	            ),
	            'rewrite' 				=> array(
	            	'slug' => 'gruppa',
	            	'with_front' => false,
	            	'hierarchical' => true
	            ),
	        )
	    );

		register_taxonomy('group_theme', array('group-post'), 
			array(
	            'hierarchical' 			=> false,
	            'label' 				=> __( 'Theme Group', 'socialbet'),
	            'labels' => array(
	                    'name' 				=> __( 'Themes', 'socialbet'),
	                    'singular_name' 	=> __( 'Theme', 'socialbet'),
						'menu_name'			=> _x( 'Themes', 'Admin menu name', 'socialbet' ),
	                    'search_items' 		=> __( 'Search Group Themes', 'socialbet'),
	                    'all_items' 		=> __( 'All Themes', 'socialbet'),
	                    'parent_item' 		=> __( 'Parent Theme', 'socialbet'),
	                    'parent_item_colon' => __( 'Parent Theme:', 'socialbet'),
	                    'edit_item' 		=> __( 'Edit Theme', 'socialbet'),
	                    'update_item' 		=> __( 'Update Theme', 'socialbet'),
	                    'add_new_item' 		=> __( 'Add New Theme', 'socialbet'),
	                    'new_item_name' 	=> __( 'New Theme Name', 'socialbet')
	            	),
	            'show_ui' 				=> true,
	            'query_var' 			=> true,
	            'capabilities'			=> array(
	            	'manage_terms' 		=> 'manage_grouppost_terms',
					'edit_terms' 		=> 'edit_grouppost_terms',
					'delete_terms' 		=> 'delete_grouppost_terms',
					'assign_terms' 		=> 'assign_grouppost_terms',
	            ),
	            'rewrite' 				=> array(
	            	'slug' => 'tematika-gruppy',
	            	'with_front' => false,
	            	'hierarchical' => false
	            ),
	        )
	    );
	}


	private function create_terms() {
		$taxonomies = array(
			'competition_type' => array(
				'Платные',
				'Бесплатные'
				)
			);

		foreach ( $taxonomies as $taxonomy => $terms ) {
			foreach ( $terms as $term ) {
				$slug = _transliteration_process( esc_html( urldecode($term) ), '?', 'ru' );

				if ( ! get_term_by( 'slug', sanitize_title($slug), $taxonomy ) ) {
					wp_insert_term( esc_html($term), $taxonomy, array('slug' => sanitize_title($slug)) );
				}
			}
		}
	}

	/**
	 * Base custom post types
	 *
	 * @return void
	 */
	function create_base_custom_post() {
		// check the existance of 'event' post type
		if ( post_type_exists('event') )
			return;

		register_post_type('event',
			array(
				'labels'              => array(
						'name'               => __( 'Events', 'socialbet' ),
						'singular_name'      => __( 'Event', 'socialbet' ),
						'menu_name'          => _x( 'Events', 'Admin menu name', 'socialbet' ),
						'add_new'            => __( 'Add New Event', 'socialbet' ),
						'add_new_item'       => __( 'Add New Event', 'socialbet' ),
						'edit'               => __( 'Edit', 'socialbet' ),
						'edit_item'          => __( 'Edit Event', 'socialbet' ),
						'new_item'           => __( 'New Event', 'socialbet' ),
						'view'               => __( 'View Event', 'socialbet' ),
						'view_item'          => __( 'View Event', 'socialbet' ),
						'search_items'       => __( 'Search Events', 'socialbet' ),
						'not_found'          => __( 'No Events found', 'socialbet' ),
						'not_found_in_trash' => __( 'No Events found in trash', 'socialbet' ),
						'parent'             => __( 'Parent Event', 'socialbet' )
					),
				'description'         => __( 'This is where you can add new event.', 'socialbet' ),
				'public'              => true,
				'show_ui'             => true,
				'capability_type'     => 'event',
				'map_meta_cap'        => true,
				'publicly_queryable'  => true,
				'exclude_from_search' => false,
				'hierarchical'        => false, // Hierarchical causes memory issues - WP loads all records!
				'rewrite'             => array( 'slug' => '/event/%sport_type%', 'with_front' => false, 'feeds' => true ),
				'query_var'           => true,
				'supports'            => array( 'title', 'editor', 'comments'),
				'has_archive'         => 'events',
				'show_in_nav_menus'   => true
			)
		);

		register_post_type('competition',
			array(
				'labels'              => array(
						'name'               => __( 'Competitions', 'socialbet' ),
						'singular_name'      => __( 'Competition', 'socialbet' ),
						'menu_name'          => _x( 'Competitions', 'Admin menu name', 'socialbet' ),
						'add_new'            => __( 'Add New Competition', 'socialbet' ),
						'add_new_item'       => __( 'Add New Competition', 'socialbet' ),
						'edit'               => __( 'Edit', 'socialbet' ),
						'edit_item'          => __( 'Edit Competition', 'socialbet' ),
						'new_item'           => __( 'New Competition', 'socialbet' ),
						'view'               => __( 'View Competition', 'socialbet' ),
						'view_item'          => __( 'View Competition', 'socialbet' ),
						'search_items'       => __( 'Search Competitions', 'socialbet' ),
						'not_found'          => __( 'No Competitions found', 'socialbet' ),
						'not_found_in_trash' => __( 'No Competitions found in trash', 'socialbet' ),
						'parent'             => __( 'Parent Competition', 'socialbet' )
					),
				'description'         => __( 'This is where you can add new Competition.', 'socialbet' ),
				'public'              => true,
				'show_ui'             => true,
				'capability_type'     => 'competition',
				'map_meta_cap'        => true,
				'publicly_queryable'  => true,
				'exclude_from_search' => false,
				'hierarchical'        => false,
				'rewrite'             => array( 'slug' => '/konkurs', 'with_front' => false, 'feeds' => true ),
				'query_var'           => true,
				'supports'            => array('title', 'editor', 'comments', 'thumbnail', 'excerpt'),
				'has_archive'         => 'konkursy',
				'show_in_nav_menus'   => true
			)
		);

		register_post_type('timeline',
			array(
				'labels'              => array(
						'name'               => __( 'User Timelines', 'socialbet' ),
						'singular_name'      => __( 'User Timeline', 'socialbet' ),
						'menu_name'          => _x( 'User Timelines', 'Admin menu name', 'socialbet' ),
						'add_new'            => __( 'Add New User Timeline', 'socialbet' ),
						'add_new_item'       => __( 'Add New User Timeline', 'socialbet' ),
						'edit'               => __( 'Edit', 'socialbet' ),
						'edit_item'          => __( 'Edit User Timeline', 'socialbet' ),
						'new_item'           => __( 'New User Timeline', 'socialbet' ),
						'view'               => __( 'View User Timeline', 'socialbet' ),
						'view_item'          => __( 'View User Timeline', 'socialbet' ),
						'search_items'       => __( 'Search Timelines', 'socialbet' ),
						'not_found'          => __( 'No User Timelines found', 'socialbet' ),
						'not_found_in_trash' => __( 'No User Timelines found in trash', 'socialbet' ),
						'parent'             => __( 'Parent User Timeline', 'socialbet' )
					),
				'public'              => true,
				'show_ui'             => true,
				'capability_type'     => 'timeline',
				'map_meta_cap'        => true,
				'publicly_queryable'  => true,
				'exclude_from_search' => false,
				'hierarchical'        => false,
				'rewrite'             => array( 'slug' => '/timeline', 'with_front' => false, 'feeds' => true ),
				'query_var'           => true,
				'supports'            => array('title', 'editor', 'comments', 'thumbnail'),
				'has_archive'         => 'timelines',
				'show_in_nav_menus'   => true
			)
		);

		register_post_type('group-post',
			array(
				'labels'              => array(
						'name'               => __( 'Posts', 'socialbet' ),
						'singular_name'      => __( 'Group Post', 'socialbet' ),
						'menu_name'          => _x( 'Group Posts', 'Admin menu name', 'socialbet' ),
						'add_new'            => __( 'Add New Group Post', 'socialbet' ),
						'add_new_item'       => __( 'Add New Group Post', 'socialbet' ),
						'edit'               => __( 'Edit', 'socialbet' ),
						'edit_item'          => __( 'Edit Group Post', 'socialbet' ),
						'new_item'           => __( 'New Group Post', 'socialbet' ),
						'view'               => __( 'View Group Post', 'socialbet' ),
						'view_item'          => __( 'View Group Post', 'socialbet' ),
						'search_items'       => __( 'Search Group Posts', 'socialbet' ),
						'not_found'          => __( 'No Group Posts found', 'socialbet' ),
						'not_found_in_trash' => __( 'No Group Posts found in trash', 'socialbet' ),
						'parent'             => __( 'Parent Group Post', 'socialbet' )
					),
				'public'              => true,
				'show_ui'             => true,
				'capability_type'     => 'grouppost',
				'map_meta_cap'        => true,
				'publicly_queryable'  => true,
				'exclude_from_search' => false,
				'hierarchical'        => false,
				'rewrite'             => array( 'slug' => '/gruppa-post', 'with_front' => false, 'feeds' => true ),
				'query_var'           => true,
				'supports'            => array('title', 'editor', 'comments', 'thumbnail'),
				'has_archive'         => 'gruppy',
				'show_in_nav_menus'   => true
			)
		);

	}

}
	// end class SocbetCustomCpt
}
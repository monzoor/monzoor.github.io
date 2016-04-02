<?php
/**
 * Class for custom metabox
 */

if ( ! defined( 'ABSPATH' ) )
	exit;

if ( ! class_exists('Socbet_Post_Metabox') ) {

class Socbet_Post_Metabox {

	/**
	 * create the metabox UI
	 * @param $formArray = array of metabox options
	 *
	 * @return string
	 */
	function metabox_builder( $formArray ) {
		global $post;

		if ( empty($formArray) ) 
			return false;
	
		$this->metabox_before();
		$this->metabox_content($formArray);
		$this->metabox_after();	

	}

	/** metabox ui wrapper */
	function metabox_before() {
		echo '<div class="socbet_custom_metabox">' . "\n";
	}
	
	/** generate the metabox content */
	function metabox_content( $opt ) {

		foreach( $opt as $option ):	
			
			$this->print_form($option);	
		
		endforeach;
		unset( $option );
	}
	
	/** metabox ui closed wrapper */
	function metabox_after() {
		echo '</div><!-- .socbet_custom_metabox -->' . "\n";
	}

	/**
	 * Returning form based on type
	 * @param $O = array of settings
	 * @return HTML string
	 */
	function print_form( $O ) {
	
		switch ( $O['type'] ){
		
			case 'text':
				$this->text_input( $O['id'], $O['label'], $O['inputtype'], $O['std'], $O['desc'] );
				break;

			case 'text_title':
				$this->text_input_title( $O['id'], $O['label'], $O['std'], $O['desc'] );
				break;

			case 'textarea':
				$style = ( isset($O['style']) ) ? $O['style'] : '';
				$this->textarea_input( $O['id'], $O['label'], $O['std'], $O['desc'], $style );
				break;

			case 'textarea_excerpt':
				$this->textarea_excerpt_input( $O['id'], $O['label'], $O['desc'] );
				break;

			case 'textarea_editor':
				$this->textarea_editor( $O['id'], $O['label'], $O['std'], $O['desc'] );
				break;
				
			case 'one_check':
				$this->onecheck_input( $O['id'], $O['label'], $O['std'], $O['desc'] );
				break;
				
			case 'select':
				$this->select_input( $O['id'], $O['label'], $O['std'], $O['desc'], $O['option'] );
				break;

			case 'select_id':
				$this->select_id_input( $O['id'], $O['label'], $O['std'], $O['desc'], $O['option'] );
				break;

			case 'color':
				$this->mt_color_input( $O['id'], $O['label'], $O['std'], $O['desc'] );
				break;
				
			case 'datetime':
				$this->date_time( $O['id'], $O['label'], $O['std'], $O['desc'] );
				break;

			case 'event_tip_lists':
				$this->show_tip_lists();
				break;

			case 'event_market_lists':
				$this->show_market_lists();
				break;

			case 'multi_market_events':
				$this->multi_market_fields();
				break;
		}

	}


	/**
	 * Show the tip lists
	 *
	 * @return string
	 */
	public function show_tip_lists() {
		global $post;
		
		$parentId = $post->ID;
		$cpt_name = get_post_meta( $post->ID, '_cpt_tip_name', true );

		$this->metabox_before();

		if ( ! post_type_exists( $cpt_name ) ) {
			print __( '<p>Please publish/save this event to enable tips!</p>', 'socialbet' );
		} else {

			$count_posts = wp_count_posts( $cpt_name );
			$published_post = $count_posts->publish;

			printf( __('<p>There are %1$d tips for this event, <a href="%2$s" class="button button-primary">Add New Tip</a> <a href="%3$s" class="button button-primary">View All Tips</a></p>', 'socialbet'), $published_post, admin_url('post-new.php?post_type='.$cpt_name) , admin_url('edit.php?post_type='.$cpt_name) );

			if ( $published_post > 0 ) {

			} else {

			}

		}

		$this->metabox_after();
	}

	/**
	 * Show the tip lists
	 *
	 * @return string
	 */
	public function show_market_lists() {
		global $post, $wpdb;
		
		$count_markets = $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->socbet_market} WHERE `event_id` = {$post->ID}" );

		$this->metabox_before();

		printf( __('<p>There are %1$d markets for this event, <a href="%2$s" class="button button-primary">View All</a>', 'socialbet'), $count_markets, admin_url('edit.php?post_type=event&page=show-markets&event='.$post->ID) );

		$this->metabox_after();
	}


	// text input
	function date_time( $id, $label, $std, $desc ) {
		global $post;

		$value = get_post_meta( $post->ID, $id, true);
		if ( !empty($value) ) {
			$value = date('Y-m-d H:i', strtotime($value) );
		}
		?>
		
			<div class="socbet-meta-form" id="<?php echo $id; ?>_wrap">
				
				<span class="socbet-label"><?php echo $label; ?></span>
			
				<input name="<?php echo $id; ?>" id="<?php echo $id; ?>" class="date-time-picker" type="text" value="<?php if ( $value != "" ) { echo stripslashes( esc_attr($value) ); } else { echo $std; } ?>" />
				
				<?php if ( $desc != "" ) { ?>
				<div class="socbet-desc"><?php echo stripslashes( $desc ); ?></div>
				<?php } ?>
			
			</div>
		
		<?php
	}


	// text input
	function text_input( $id, $label, $type='text', $std, $desc ) {
		global $post;

		$value = get_post_meta( $post->ID, $id, true);
		?>
		
			<div class="socbet-meta-form" id="<?php echo $id; ?>_wrap">
				
				<span class="socbet-label"><?php echo $label; ?></span>
			
				<input name="<?php echo $id; ?>" id="<?php echo $id; ?>" type="<?php echo $type; ?>" value="<?php if ( $value != "" ) { echo stripslashes( esc_attr($value) ); } else { echo $std; } ?>" />
				
				<?php if ( $desc != "" ) { ?>
				<div class="socbet-desc"><?php echo stripslashes( $desc ); ?></div>
				<?php } ?>
			
			</div>
		
		<?php
	}

	/** custom title form */
	function text_input_title( $id, $label, $std, $desc ) {
		global $post;

		$value = $post->post_title;
		?>
		
			<div class="socbet-meta-form" id="<?php echo $id; ?>_wrap">
				
				<span class="socbet-label"><?php echo $label; ?></span>
			
				<input name="post_title" id="post_title" type="text" value="<?php if ( $value != "" ) { echo stripslashes( $value ); } else { echo $std; } ?>" autocomplete="off" />
				
				<?php if ( $desc != "" ) { ?>
				<div class="socbet-desc"><?php echo stripslashes( $desc ); ?></div>
				<?php } ?>
			
			</div>
		
		<?php
	}

	// Textarea form
	function textarea_input( $id, $label, $std, $desc, $style = "" ) {
		global $post;
		
		$value = get_post_meta( $post->ID, $id, true);
		?>
		
			<div class="socbet-meta-form">
				
				<span class="socbet-label"><?php echo $label; ?></span>
			
				<textarea name="<?php echo $id; ?>" id="<?php echo $id; ?>" cols="20" rows="5" class="widefat" style="<?php echo $style; ?>"><?php if ( $value != "" ) { echo stripslashes( esc_textarea($value) ); } ?></textarea>
				
				<?php if ( $desc != "" ) { ?>
				<div class="socbet-desc"><?php echo stripslashes( $desc ); ?></div>
				<?php } ?>
			
			</div>
		
		<?php
	}

	// Excerpt form
	function textarea_excerpt_input( $id, $label, $desc ){
		global $post;
		
		$value = $post->post_excerpt;
		?>
		
			<div class="socbet-meta-form">
				
				<span class="socbet-label"><?php echo $label; ?></span>
			
				<textarea name="excerpt" id="excerpt" cols="20" rows="10" class="widefat"><?php if ( $value != "" ) { echo stripslashes($value); } ?></textarea>
				
				<?php if ( $desc != "" ) { ?>
				<div class="socbet-desc"><?php echo stripslashes( $desc ); ?></div>
				<?php } ?>
			
			</div>
		
		<?php
	}

	function textarea_editor( $id, $label, $std, $desc, $style = "" ) {
		global $post;
		
		$value = get_post_meta( $post->ID, $id, true);
		if ( !$value ) {
			$value = $std;
		}
		?>
		
			<div class="socbet-meta-form">
				
				<span class="socbet-label"><?php echo $label; ?></span>
				<br/>
				<?php
	                $editor_id = 'editor_'.$id;
	                $args = array(
	                     'textarea_name' => "{$id}",
	                     'media_buttons' => false,
	                     'textarea_rows' => 5
	                );

	                wp_editor( $value, $editor_id, $args );
				?>

				<?php if ( $desc != "" ) { ?>
				<div class="socbet-desc"><?php echo stripslashes( $desc ); ?></div>
				<?php } ?>
			
			</div>
		
		<?php
	}

	// Color chooser input (depecreated soon)
	function mt_color_input( $id, $label, $std, $desc = "" ){	
		global $post;
			
		$value = get_post_meta( $post->ID, $id, true);
	?>

		<div class="socbet-meta-form colorish">
	
			<span class="socbet-label"><?php echo $label; ?></span>

			<label class="color_label" for="<?php echo $id; ?>" style="background-color: #<?php if ( $value != "" ) { echo stripslashes( $value ); } else { echo $std; } ?>;">
				<input name="<?php echo $id; ?>" id="<?php echo $id; ?>" class="color_scheme_input" type="text" value="<?php if ( $value != "" ) { echo stripslashes( $value ); } else { echo $std; } ?>" />
			</label>

			<?php if ( $desc != "" ) { ?>
			<span class="socbet-desc"><?php echo stripslashes($desc); ?></span>
			<?php } ?>
	
		</div>

	<?php
	}
	
	// One check / ON-OFF option
	function onecheck_input( $id, $label, $std, $desc = "" ){
		global $post;
			
		$value = get_post_meta( $post->ID, $id, true);
		$value = ( $value == "" ) ? $std : $value;
	?>

		<div class="socbet-meta-form">
					
			<span class="socbet-label"><?php echo $label; ?></span>
					
			<input type="checkbox" value="yes" id="<?php echo $id; ?>" name="<?php echo $id; ?>" <?php checked( strtolower($value), "yes" ); ?>/>					
					
			<?php if ( $desc != "" ) { ?>
			<div class="socbet-desc"><?php echo $desc; ?></div>
			<?php } ?>
					
		</div>
	
	<?php
	}


	// Basic select input
	function select_input( $id, $label, $std, $desc = "", $select ){
		global $post;
			
		$value = get_post_meta( $post->ID, $id, true);
		$value = ( $value == "" ) ? $std : $value;
	?>
	
		<div class="socbet-meta-form">
			
			<span class="socbet-label"><?php echo $label; ?></span>
		
				<select name="<?php echo $id; ?>" id="<?php echo $id; ?>">
					
					<?php foreach ( $select as $opt ) { ?>
					
					<option <?php selected( $opt, $value, true ); ?>><?php echo $opt; ?></option>
					
					<?php } ?>
						
				</select>
				
			<?php if ( $desc != "" ) { ?>
			<div class="socbet-desc"><?php echo stripslashes( $desc ); ?></div>
			<?php } ?>
		
		</div>
	
	<?php
	}	

	// Select with custom label
	function select_id_input( $id, $label, $std, $desc = "", $select ){
		global $post;
			
		$value = get_post_meta( $post->ID, $id, true);
		$value = ( $value == "" ) ? $std : $value;
	?>
	
		<div class="socbet-meta-form">
			
			<span class="socbet-label"><?php echo $label; ?></span>
		
				<select name="<?php echo $id; ?>" id="<?php echo $id; ?>">
					
					<?php foreach ( $select as $opt => $opt_name ) { ?>
					
					<option value="<?php echo $opt; ?>" <?php selected( $opt, $value, true ); ?>><?php echo ucwords( stripslashes( $opt_name ) ); ?></option>
					
					<?php }
					unset( $opt_name );
					?>
						
				</select>
				
			<?php if ( $desc != "" ) { ?>
			<div class="socbet-desc"><?php echo stripslashes( $desc ); ?></div>
			<?php } ?>
		
		</div>
	
	<?php
	}


	/**
	 * Multiple market lists options
	 * Fields will be following
	 * Market entries name
	 * odds
	 * price
	 *
	 * Will be need some js helpers
	 *
	 * @return string
	 */
	function multi_market_fields() {
		global $wpbd, $post;

		$values = get_post_meta( $post->ID, '_socbet_market_entries', true );
	?>

		<div id="market-entries-wrap">

			<div id="market-entries-form">
				<div class="col-wrap">
					<div class="col-md-4">
						<input type="text" name="new_market_entry_name" id="new_market_entry_name" value="" placeholder="<?php print __('Market Entry Name', 'socialbet'); ?>" />
					</div>
					<div class="col-md-4">
						<input type="text" name="new_market_entry_odds" id="new_market_entry_odds" value="" placeholder="<?php print __('Odds', 'socialbet'); ?>" />
					</div>
					<div class="col-md-4">
						<input type="text" name="new_market_entry_price" id="new_market_entry_price" value="" placeholder="<?php print __('Price', 'socialbet'); ?>" />
					</div>
				</div>
				<p class="text-right">
					<a id="add-new-market-entry" class="button button-primary" href="#"><?php print __('Add New', 'socialbet'); ?></a>
				</p>
			</div>

			<table class="wp-list-table widefat fixed">
				<thead>
					<tr>
						<th scope="col" class="manage-column"><?php print __('Market Entry', 'socialbet'); ?></th>
						<th scope="col" class="manage-column"><?php print __('Odds', 'socialbet'); ?></th>
						<th scope="col" class="manage-column"><?php print __('Price', 'socialbet'); ?></th>
						<th scope="col" class="manage-column"><?php print __('Action', 'socialbet'); ?></th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th scope="col" class="manage-column"><?php print __('Market Entry', 'socialbet'); ?></th>
						<th scope="col" class="manage-column"><?php print __('Odds', 'socialbet'); ?></th>
						<th scope="col" class="manage-column"><?php print __('Price', 'socialbet'); ?></th>
						<th scope="col" class="manage-column"><?php print __('Action', 'socialbet'); ?></th>
					</tr>
				</tfoot>

				<tbody id="the-list-markets">

					<?php
					if ( ! empty($values) ) {

						foreach( $values as $key => $value ) {
							?>
						<tr>
							<td class="column-entry-name"><?php print $value['name']; ?></td>
							<td class="column-entry-odds"><?php print $value['odds']; ?></td>
							<td class="column-entry-price"><?php print $value['price']; ?></td>
							<td class="column-entry-action">
								<a href="#" class="entry-inline-edit"><?php print __('Edit'); ?></a>
								| <a href="#" class="entry-inline-remove"><?php print __('Delete'); ?></a>
							</td>
						</tr>
						<tr class="edit_event_entry">
							<td colspan="4">
								<div class="col-wrap">
									<div class="col-md-4"><input type="text" name="mentry_name[]" value="<?php print esc_attr( $value['name'] ); ?>" /></div>
									<div class="col-md-4"><input type="text" name="mentry_odds[]" value="<?php print esc_attr( $value['odds'] ); ?>" /></div>
									<div class="col-md-4"><input type="text" name="mentry_price[]" value="<?php print esc_attr( $value['price'] ); ?>" /></div>
								</div>
								<p class="text-right"><a href="#" class="button button-primary update-entry-data"><?php print __('Save Changes', 'socialbet'); ?></a></p>
							</td>
						</tr>
							<?php
						}
						unset($value);
						unset($key);
					}
					?>

					<tr id="socbet-noentry"<?php if ( ! empty($values) ) echo ' style="display:none;"'; ?>>
						<td colspan="4">
							<div class="socbet-alert alert-warning text-center"><?php print __('No data!', 'socialbet'); ?></div>
						</td>
					</tr>

				</tbody>
			</table>
		</div>

		<?php
	}

}

}
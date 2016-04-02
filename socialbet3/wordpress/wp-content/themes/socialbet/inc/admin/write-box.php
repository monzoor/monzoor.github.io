<?php
/**
 * Custom write box
 */

add_filter( 'manage_edit-group_theme_columns', 'adminGroupThemeColumns' );
function adminGroupThemeColumns( $columns ) {    
    if ( isset( $columns[ 'description' ] ) ) {
        unset( $columns[ 'description' ] );
    }

    return $columns;        
}

function admin_socbet_theme_group_add_fields() {
	?>
<script>
(function($){
	$("#tag-description").hide().removeAttr('id').closest('.form-field').remove();
})(window.jQuery);
</script>
	<input type="hidden" name="description" value="" />
	<div class="wip-upload-form form-field" data-input="theme-thumbnail">
		<label><?php _e( 'Default Thumbnail', 'socialbet' ); ?></label>
		<div class="wip_form_preview">


		</div>
		<a class="button-secondary wip-upload-handle" href="#"><?php _e('Add Image', 'socialbet'); ?></a>
		<input type="hidden" id="theme-thumbnail" name="term_meta[thumbnail]" value="" />
	</div>

	<div class="wip-upload-form form-field" data-input="theme-image">
		<label><?php _e( 'Default Image', 'socialbet' ); ?></label>
		<div class="wip_form_preview">


		</div>
		<a class="button-secondary wip-upload-handle" href="#"><?php _e('Add Image', 'socialbet'); ?></a>
		<input type="hidden" id="theme-image" name="term_meta[image]" value="" />
	</div>

	<?php
}
add_action( 'group_theme_add_form_fields', 'admin_socbet_theme_group_add_fields', 10, 2 );

function admin_socbet_theme_group_edit_fields( $term ) {
	$t_id = $term->term_id;
	$term_meta = get_option('taxonomy_meta_'.$t_id);
	?>
<script>
(function($){
	$("#description").hide().removeAttr('id').closest('.form-field').remove();
})(window.jQuery);
</script>
	<input type="hidden" name="description" value="" />
	<tr class="form-field">
		<th scope="row" valign="top"><label for=""><?php _e( 'Default Thumbnail', 'socialbet' ); ?></label></th>
		<td>
		<?php
            $thumbnail = "";
            $thumbnail_id = "";
            if ( is_array($term_meta) && isset($term_meta['thumbnail']) ) {
            	$thumbnail_id = $term_meta['thumbnail'];
            	if ( ! empty($thumbnail_id) ) {
            		$thumbnail = wp_get_attachment_thumb_url( $thumbnail_id );
            	}
            }
		?>
			<div class="wip-upload-form" data-input="theme-thumbnail">
				<div class="wip_form_preview">
				<?php if ( $thumbnail != "" ) { ?>
					<img src="<?php echo esc_url($thumbnail); ?>" alt="" />
					<a class="file-remove" href="#" title="Remove">&times;</a>
				<?php } ?>
				</div>
				<a class="button-secondary wip-upload-handle" href="#"><?php _e('Add Image', 'socialbet'); ?></a>
				<input type="hidden" name="term_meta[thumbnail]" id="theme-thumbnail" value="<?php echo $thumbnail_id; ?>" />
			</div>
		</td>
	</tr>

	<tr class="form-field">
		<th scope="row" valign="top"><label for=""><?php _e( 'Default Image', 'socialbet' ); ?></label></th>
		<td>
		<?php
            $image = "";
            $image_id = "";
            if ( is_array($term_meta) && isset($term_meta['image']) ) {
            	$image_id = $term_meta['image'];
            	if ( ! empty($image_id) ) {
            		$image = wp_get_attachment_thumb_url( $image_id );
            	}
            }
		?>
			<div class="wip-upload-form" data-input="theme-image">
				<div class="wip_form_preview">
				<?php if ( $image != "" ) { ?>
					<img src="<?php echo esc_url($image); ?>" alt="" />
					<a class="file-remove" href="#" title="Remove">&times;</a>
				<?php } ?>
				</div>
				<a class="button-secondary wip-upload-handle" href="#"><?php _e('Add Image', 'socialbet'); ?></a>
				<input type="hidden" name="term_meta[image]" id="theme-image" value="<?php echo $image_id; ?>" />
			</div>
		</td>
	</tr>
	<?php
}
add_action( 'group_theme_edit_form_fields', 'admin_socbet_theme_group_edit_fields', 10, 2 );

function save_taxonomy_group_theme_meta( $term_id ) {
	if ( isset( $_POST['term_meta'] ) ) {
		$t_id = $term_id;
		$term_meta = get_option( 'taxonomy_meta_'.$t_id );
		$cat_keys = array_keys( $_POST['term_meta'] );
		foreach ( $cat_keys as $key ) {
			if ( isset ( $_POST['term_meta'][$key] ) ) {
				$term_meta[$key] = $_POST['term_meta'][$key];
			}
		}
		// Save the option array.
		update_option( 'taxonomy_meta_'.$t_id, $term_meta );
	}
}  
add_action( 'edited_group_theme', 'save_taxonomy_group_theme_meta', 10, 2 );  
add_action( 'create_group_theme', 'save_taxonomy_group_theme_meta', 10, 2 );


function prime_delete_group_theme($id){

	delete_option('taxonomy_meta_'.$id);
}
add_action( 'delete_group_theme', 'prime_delete_group_theme', 10, 2);


function prime_delete_group_name($id){

	delete_option('taxonomy_meta_'.$id);
}
add_action( 'delete_group_name', 'prime_delete_group_name', 10, 2);
<?php
/**
 * create a group modal box template
 */

?>

<div class="md-modal md-effect-1 create-groups" id="modal-create-group">
	<div class="md-content">
		<div class="header">
			<div class="close-abs no-bg"><span class="icon-close brand-blue-bg white md-close"></span></div>
			<h1 class="font30 white"><?php esc_html_e('Создать группу' ,'socialbet'); ?></h1>
		</div>
		<form class="form-wrapper ajaxify" data-reload="1" method="post" action="">
			<?php wp_nonce_field( 'socbet-new-group', '_socbetnewgroupnonce', true, true ); ?>
			<label><?php esc_html_e('Название' ,'socialbet'); ?></label>
			<input type="text" name="group-name-creation">
			<div class="clear"></div>
			<label><?php esc_html_e('Тематика группы' ,'socialbet'); ?></label>
			<select class="select" name="group-theme">
				<?php
					$temas = get_terms( 'group_theme', array('hide_empty'=>false) );
					if ( ! empty( $temas ) && ! is_wp_error( $temas ) ){
						foreach( $temas as $th ) {
							echo '<option value="'.$th->term_id.'">'.$th->name.'</option>';
						}
						unset($th);
					}
				?>
			</select>
			<div class="clear"></div>
			<label><?php esc_html_e('Описание' ,'socialbet'); ?></label>
			<textarea name="group-description-creation" placeholder="<?php esc_attr_e('Опишите направленность группы более подробно', 'socialbet'); ?>"></textarea>
			<input value="<?php esc_attr_e('создать группу', 'socialbet'); ?>" type="submit" class="fill-balance fr">
			<input type="hidden" name="action" value="socbet_add_new_group" />
		</form>
	</div>
</div>
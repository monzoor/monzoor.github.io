
<?php
if ( !is_user_logged_in() ) {
	get_template_part( 'layouts/modal', 'register' );
}

if ( is_singular('competition') ) {
	get_template_part( 'layouts/modal', 'competition' );
}

if ( is_user_logged_in() && ( is_socbet_user_page() && ! is_own_profile() ) ) {
	get_template_part( 'layouts/modal', 'message' );
}

if( is_socbet_user_page() && is_own_profile() && is_socbet_user_settings_page() == 'gruppy' ) {
	get_template_part( 'layouts/modal', 'group-create' );
}
?>

		<!-- search popup -->
		<div class="md-modal md-effect-1" id="modal-1">
			<div class="md-content">
				<div class="search-popup">
					<span class="icon-close close-abs md-close"></span>
					<p><?php esc_html_e('Поиск по сайту', 'socialbet'); ?></p>
					<form method="get" class="from" action="<?php echo home_url('/'); ?>">
						<input type="text" placeholder="<?php esc_attr_e('Введите любое слово', 'socialbet'); ?>">
						<button type="submit" class="fill-balance"><?php esc_html_e('искать', 'socialbet'); ?></button>
					</form>
				</div>
			</div>
		</div>


		<div class="md-overlay"></div><!-- the overlay element -->
	

	</div><!-- .content-sub-wrapper -->

	<div class="overlay"></div><!-- the overlay element -->

</div><!-- .content-wrapper -->

<?php wp_footer(); ?>

</body>
</html>
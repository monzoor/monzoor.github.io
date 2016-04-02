<?php get_header(); ?>


<div class="wrap">

	<div id="logo">
		<img src="<?php echo get_template_directory_uri() . '/assets/images/logo.png'; ?>" alt="" />
	</div>

	<div class="entry-content" id="first-content">
		<h1 class="entry-title"><?php
		if ( get_option('socbetsoon_thankyou_page_title') ) {
			print esc_html( stripslashes( get_option( 'socbetsoon_thankyou_page_title' ) ) );
		} else {
			esc_html_e( 'Thank you for subscribing to the Social Bet program', 'socialbet' ); 
		} ?></h1>

		<?php 
		if ( get_option( 'socbetsoon_thankyou_page_content' ) ) {
			echo apply_filters( 'the_content', stripslashes( get_option( 'socbetsoon_thankyou_page_content' ) ) );
		} else {
			print '<p>'. esc_html__( 'Thank you for subscribing to the Social Bet program.', 'socialbet' ) .'</p>';
		} ?>
	</div>

</div>

<script>
ga( 'send', 'event', 'subscribe', 'confirm' );
</script>


<?php get_footer(); ?>
<?php exit(); ?>
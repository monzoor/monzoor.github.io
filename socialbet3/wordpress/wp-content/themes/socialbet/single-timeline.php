<?php get_header(); ?>

<div class="main-container">
	<div class="middle-container-wrapper-1col">

		<?php while ( have_posts() ): the_post(); ?>
		
		<div class="center-small">
			<?php get_template_part('timeline', 'loop'); ?>
		</div>

		<?php endwhile; ?>
		<?php wp_reset_query(); ?>

	</div>
</div>


<?php get_footer(); ?>
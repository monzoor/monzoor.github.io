<?php get_header(); ?>


<div class="main-container">

	<div class="middle-container-wrapper-2col-wide">
	
		<h1 class="fl wd-auto mg-top"><?php esc_html_e('Kонкурсы', 'socialbet'); ?></h1>
	
		<div class="compitition-list-wrapper">
		
			<div class="profile-competition-wrapper fl">
			
			<div class="filter-box mg-bottom">
				<?php echo socbet_get_competition_type_links(); ?>
			</div>

			<div class="competition-box-wrapper">
			<?php
				if ( have_posts() ):
				
				echo '<ul>' . "\n";

					while ( have_posts() ) : the_post();
						global $post;

						get_template_part( 'competition', 'list' );

					endwhile;

				echo '</ul>' . "\n";

				else:

					print __('Sorry, we have no competition!', 'socialbet');

				endif;
				wp_reset_postdata();
			?>
			</div>

			</div>

		</div>

	</div>
	<!-- end .main-container -->
	<div class="right-container-wrapper t-d-view tab-por-no-view">
		<img src="<?php echo get_template_directory_uri() . '/assets/images/banner-1.jpg'; ?>" alt="" />
	</div>

</div>

<?php get_footer(); ?>
<?php get_header(); ?>

<?php
global $group_count;
$args = array(
	'hide_empty' => 0
	);

$listgroups = get_terms('group_name', $args);
$group_count = count($listgroups);
?>
<div class="main-container">

	<div class="left-container-wrapper t-d-view filter">
		<div class="col-wp">
			<?php get_template_part('group', 'filters'); ?>
		</div>
	</div>


	<div class="middle-container-wrapper-2col">
	
		<div class="profile-groups-wrapper groups-wrapper">
			
			<div class="col-wp mob-view">
				<?php get_template_part('group', 'filters'); ?>
			</div>

			<div class="search-box2 fl mg-top">
				<form methpd="post" action="/">
					<input type="text" placeholder="Начните вводить название">
					<button type="submit" class="search-button"><span class="icon-search"></span></button>
				</form>
			</div>
			<div class="clear"></div>
			
			<div class="groups-wrapper mg-top">
				<ul>
<?php
			if ( ! empty( $listgroups ) && ! is_wp_error( $listgroups ) ){
?>
				<?php
				foreach( $listgroups as $gr ) {
					$meta_group = get_option('taxonomy_meta_'.$gr->term_id);
					$thumbnail = "";
					$image = "";
					$member = '0';
					if( is_array($meta_group) && isset($meta_group['theme']) ) {
						$theme = $meta_group['theme'];
						$member = isset( $meta_group['subscriber'] ) ? $meta_group['subscriber'] : '0';
						$theme_meta = get_option('taxonomy_meta_'.$theme);
						
						if( is_array($theme_meta) ) {
							$thumbnail = isset($theme_meta['thumbnail']) ? wp_get_attachment_thumb_url( $theme_meta['thumbnail'] ) : '';
							$image = isset($theme_meta['image']) ? wp_get_attachment_thumb_url( $theme_meta['image'] ) : '';	
						}

						if ( isset( $meta_group['image'] ) && $meta_group['image'] != "" ) {
							$image = wp_get_attachment_url( $meta_group['image'] );	
						}
						if ( isset( $meta_group['thumbnail'] ) && $meta_group['thumbnail'] != "" ) {
							$thumbnail = wp_get_attachment_thumb_url( $meta_group['thumbnail'] );	
						}
					}
				?>
					<li class="fl">
						<div class="grp-img1"><img src="<?php echo $image; ?>"></div>
						<div class="grp-img2" style="background-image: url(<?php echo $thumbnail; ?>)"></div>
						<h2><a class="dark-link" href="<?php echo esc_url( get_term_link($gr) ); ?>"><?php print $gr->name; ?></a></h2>
						<p class="font12"><?php printf( __('%d участников', 'socialbet'), count($member) ); ?> </p>
						<div class="fill-balance">
							<?php esc_html_e('подписан', 'socialbet'); ?>
						</div>
						<div class="user-add mob-view no-bg brand-blue">
							<span class="icon-useradd"></span>
						</div>
					</li>
<?php
				}
			}
?>

				</ul>
			</div>
		</div>

	</div>
	<!-- end .main-container -->

</div>

<?php get_footer(); ?>
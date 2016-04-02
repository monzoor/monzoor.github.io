<?php
/**
 * user timeline template
 *
 * @ver 1.0
 */
global $post;

$tl_user_data = get_socbet_usermeta( $post->post_author );
$tl_user_avatar = empty( $tl_user_data['avatar'] ) ? get_template_directory_uri() . '/assets/images/default_avatar.png' : $tl_user_data['avatar'];
$tl_display_name = ( empty($tl_user_data['first_name']) && empty($tl_user_data['last_name']) ) ? $tl_user_data['nickname'] : $tl_user_data['first_name'] . '<br/>' . $tl_user_data['last_name'];
?>

	<div id="user-status-<?php the_ID(); ?>" <?php post_class('user-status-post'); ?>>
		<div class="col-wp">
			<div class="image-info-box">
				<div class="img-holder">
			 		<img src="<?php echo esc_url($tl_user_avatar); ?>" class="circle">
			 	</div>
			 	<div class="info-holder">
			 		<p><?php print strip_tags( str_replace('<br/>', ' ', $tl_display_name ) ); ?></p>
			 		<p class="sub-info"><?php print socbet_time_diff( get_the_time('U'), current_time('timestamp') ); ?></p>
			 	</div>
			</div>
			<div class="user-status-content">
				<?php the_content(); ?>
				<?php if( get_post_meta( get_the_ID(), '_is_update_profile_photo', true ) ) echo '<p class="placeholder-color">' . esc_html__('обновил фотографию на странице:', 'socialbet') . '</p>' . "\n"; ?>
				<?php
				if ( $attachs = socbet_has_attachments() ) {
					$im = 0;
					$thumbs = "";
					$files = "";
					foreach ( $attachs as $attachment ) {
						$mime_type = get_post_mime_type( $attachment->ID );
						//show the images
						if ( in_array( $mime_type, array('image/jpeg', 'image/png', 'image/gif') ) ) {
							$im++;
							if ( $im == 1 ) {

								echo '<div id="image-attachment-'.get_the_ID().'" class="image-attachment-large"><img src="'.wp_get_attachment_url($attachment->ID).'" alt="" /></div>';

							}

							$turl = wp_get_attachment_image_src( $attachment->ID, 'thumbnail' );
							if ( $turl && isset($turl[0]) )
								$thumbs .= '<div class="attachment-thumb-lists"><a href="'.wp_get_attachment_url($attachment->ID).'" data-placeholder="#image-attachment-'.get_the_ID().'"'. ( $im == 1 ? ' class="active"' : '' ) .'><img src="'.$turl[0].'" alt="" /></a></div>' . "\n";
						
						} else {
							$files .= '<li><a href="'.wp_get_attachment_url($attachment->ID).'"><img src="'.wp_mime_type_icon($mime_type).'" alt="" /> '.apply_filters('the_title', $attachment->post_title).'</a></li>';
						}
					}
					unset($attachment);
					

					if ( !empty($thumbs) && $im>1 )
						echo '<div class="attachment-thumb-wrap">' . $thumbs . '</div>' . "\n";

					unset($im);

					if ( !empty($files) )
						echo '<ul class="attachment-list-files">' . $files . '</ul>' . "\n";

				}
				?>
			</div>

			<?php get_template_part('layouts/poll', 'timelines'); ?>

			<div class="like-box">
				<div class="left-part fl">
					<ul>
						<li id="timeline-comment-counts"><a href="#"><span class="icon-message"></span></a><span class="timelines-comments-number-count-<?php the_ID(); ?>"><?php echo get_comments_number( get_the_ID() ); ?></span></li>
						<input type="hidden" id="timelines-comments-number-count-<?php the_ID(); ?>" name="timelines-comments-number-count" value="<?php echo get_comments_number( get_the_ID() ); ?>" />
					</ul>
				</div>
				<div class="right-part fr">
					<ul>
						<li id="timeline-likes-<?php the_ID(); ?>"><a href="#" class="ajx-timeline-misc" data-uri="<?php the_permalink(); ?>" data-qry="liked" data-postid="<?php the_ID(); ?>" data-load-likes="timeline-likes-<?php the_ID(); ?>" data-load-dislikes="timeline-dislikes-<?php the_ID(); ?>"><span class="icon-like"></span></a><?php echo get_timeline_likes_count(get_the_ID()); ?></li>
						<li id="timeline-dislikes-<?php the_ID(); ?>"><a href="" class="ajx-timeline-misc" data-uri="<?php the_permalink(); ?>" data-qry="disliked" data-postid="<?php the_ID(); ?>" data-load-likes="timeline-likes-<?php the_ID(); ?>" data-load-dislikes="timeline-dislikes-<?php the_ID(); ?>"><span class="icon-dontlike"></span></a><?php echo get_timeline_dislikes_count(get_the_ID()); ?></li>
						<li><a href=""><span class="icon-repost"></span></a>15</li>
					</ul>
				</div>
			</div>
		</div>
		<?php 
		global $withcomments;
		$withcomments = 1;
		comments_template('/layouts/timeline-comments.php'); 
		?>
	</div>

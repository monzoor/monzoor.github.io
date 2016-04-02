<?php
/**
 * poll timelines
 *
 */

global $post;
?>

		<?php
			if ( $poll_name = get_post_meta( get_the_ID(), '_socbet_poll_name', true ) ) {
				$poll_options = get_post_meta( get_the_ID(), '_socbet_poll_options', true );

				// already voted, show the results
				if ( user_is_voted_on_poll( get_the_ID() ) ) {
					$results = socbet_get_poll_results( get_the_ID() );
		?>

			<div class="poll" id="poll-single-wrap-<?php the_ID(); ?>">
				<p class="placeholder-color"><?php esc_html_e('Опрос', 'socialbet'); ?></p>
				<p class="question"><b><?php print esc_html( $poll_name ); ?></b></p>

				<div class="poll-res voting-result-wrapper">
				<?php
					foreach ( $poll_options as $po ) { 
						$val_this = isset( $results[$po] ) ? count( $results[$po] ) : 0;
						?>
					
					<p><?php print $po; ?></p>
					<div class="progessbar-wrapper mg-top">
						<div class="progess">
							<p><?php echo ( isset( $results[$po] ) ? count( $results[$po] ) : '0' ); ?></p>
							<div class="bar" style="width: <?php print ($val_this/socbet_get_poll_count( get_the_ID() ))*100 . '%'; ?>;"></div>
						</div>
						<p class="fr"><?php print ($val_this/socbet_get_poll_count( get_the_ID() ))*100 . '%'; ?></p>
					</div>

				<?php
					}
					unset($po);
				?>
				</div>

				<p class="placeholder-color"><?php printf( esc_html__('Проголосовало %d человек', 'socialbet'), socbet_get_poll_count( get_the_ID() ) ); ?></p>
			</div>
		<?php } else { ?>

			<div class="poll" id="poll-single-wrap-<?php the_ID(); ?>">
				<p class="placeholder-color"><?php esc_html_e('Опрос', 'socialbet'); ?></p>
				<p class="question"><b><?php print esc_html( $poll_name ); ?></b></p>

				<div class="checkbox">
					<form action="" method="post" class="poll-submission">
						<?php wp_nonce_field( 'socbet-voted-poll-'.get_the_ID(), '_socbetvotedpoll_'.get_the_ID(), true, true ); ?>
						<table>
						<?php
						$k = 0;
						foreach ( $poll_options as $po ) { 
							$k++;
							?>
							<tr>
								<td>
									<input type="radio" name="pool_me" id="poll_me<?php echo get_the_ID().$k; ?>" class="css-checkbox" value="<?php echo esc_attr( $po ); ?>" />
									<label for="poll_me<?php echo get_the_ID().$k; ?>" class="css-label radGroup2">
										<?php print esc_html( $po ); ?>
									</label>
								</td>
							</tr>
						<?php }
						unset($po);
						unset($k);
						?>
						</table>
						<input type="hidden" name="post_id" value="<?php echo esc_attr( get_the_ID() ); ?>" />
						<input type="hidden" name="action" value="voted_poll" />
					</form>
				</div>

				<p class="placeholder-color"><?php printf( esc_html__('Проголосовало %d человек', 'socialbet'), socbet_get_poll_count( get_the_ID() ) ); ?></p>
			</div>
		<?php
			}
		}
		?>
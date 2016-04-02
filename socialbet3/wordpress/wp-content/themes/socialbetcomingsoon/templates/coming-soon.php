<?php get_header(); ?>


<div class="wrap">

	<div id="logo">
		<img src="<?php echo get_template_directory_uri() . '/assets/images/logo.png'; ?>" alt="" />
	</div>

	<div class="entry-content" id="first-content">
		<h1 class="entry-title"><?php
		if ( get_option( 'socbetsoon_index_title' ) ) {
			print esc_html( stripslashes( get_option( 'socbetsoon_index_title' ) ) );
		} else {
			esc_html_e( 'Social Bet – это социальная сеть для игроков.', 'socialbet' ); 
		} ?>
		</h1>

		<?php if ( get_option( 'socbetsoon_index_content' ) ) {
			echo apply_filters( 'the_content', stripslashes( get_option( 'socbetsoon_index_content' ) ) );
		} else {
			print '<p>'. esc_html__( 'Здесь вы найдете для себя все, что нужно именно вам: лучшие коэффициенты букмекеров; возможность следить за лучшими прогнозистами, а также зарабатывать на своих прогнозах;  доступ к полной и подробной статистике ваших ставок.', 'socialbet' ) .'</p>';
		} ?>

		<?php
		if ( get_option( 'socbetsoon_index_before_email' ) ) {
			print '<h3 class="before-email-form">'. stripslashes( get_option( 'socbetsoon_index_before_email' ) ) . '</h3>';
		} else {
			print '<h3 class="before-email-form">' . esc_html__( 'Оставьте нам свой e-mail, и мы оповестим Вас об открытии!', 'socialbet' ) . '</h3>';
		}
		?>

		<p class="yellow-bold"><?php esc_html_e('Первые 5000 подписавшихся получат дополнительные очки в конкурсе прогнозов с призовым фондом 100,000 рублей.', 'socialbet'); ?></p>

		<div id="flip-user-count">
			<span class="flip-text before"><?php esc_html_e('С нами уже', 'socialbet'); ?></span>
			<div id="flip-count" data-counted="<?php print socbet_get_total_subscribed(); ?>">
				<p class="tick tick-flip"><?php print number_format( socbet_get_total_subscribed() ); ?></p>
			</div>
			<span class="flip-text after"><?php esc_html_e('игроков!', 'socialbet'); ?></span>
		</div>

		<form method="post" action="<?php echo home_url( '/' ); ?>" id="subscribe-form">
			<?php wp_nonce_field( 'socbet-user-subscribes', '_wpnonce', true, true ); ?>
			<input type="email" name="subscribe_email" value="" placeholder="<?php esc_attr_e( 'Введите ваш e-mail', 'socialbet' ); ?>"/>
			<button type="submit"><?php esc_html_e( 'Отправить', 'socialbet' ); ?></button>
			<input type="hidden" name="action" value="socbet_mailinglist_callback"/>
		</form>

		<h2 class="entry-title before-social"><?php esc_html_e('РАССКАЖИТЕ ДРУЗЬЯМ!', 'socialbet'); ?></h2>
		<div id="socbet-share-buttons">
			<div class="fb-share-button" data-href="http://socialbet.ru" data-layout="button_count" data-lang="ru"></div>
			<a class="twitter-share-button" href="https://twitter.com/share" data-lang="ru"></a>
		</div>

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/ru_RU/sdk.js#xfbml=1&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<script type="text/javascript">
window.twttr=(function(d,s,id){var t,js,fjs=d.getElementsByTagName(s)[0];if(d.getElementById(id)){return}js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);return window.twttr||(t={_e:[],ready:function(f){t._e.push(f)}})}(document,"script","twitter-wjs"));
</script>
<script>
			jQuery(document).ready(function() {
				jQuery('#socbet-share-buttons').prepend( VK.Share.button(false,{type: "round", text: "Поделиться"}) );
			});
</script>
	</div>

	<div class="entry-content" id="second-content">
		<h2 class="entry-title"><?php 
		if( get_option( 'socbetsoon_index_after_saved_title' ) ) {
			print esc_html( stripslashes( get_option( 'socbetsoon_index_after_saved_title' ) ) );
		} else {
			esc_html_e( 'Thank you for subscribing to the Social Bet program', 'socialbet' ); 
		} ?></h2>

		<?php 
		if ( get_option( 'socbetsoon_index_after_saved_content' ) ) {
			echo apply_filters( 'the_content', stripslashes( get_option( 'socbetsoon_index_after_saved_content' ) ) );
		} else {
			print '<p>'. esc_html__( 'We have sent you an email, Please confirm your subscription by clicking on the link contained in the e-mail.', 'socialbet' ) .'</p>';
		} ?>

	</div>
</div>


<?php get_footer(); ?>
<?php exit(); ?>
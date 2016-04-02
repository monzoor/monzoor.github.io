<?php
/**
 * competition modal box
 *
 */
?>

<?php 
global $post;
if( ! user_is_participant( $post->ID ) ) { ?>
<!-- notificatios -->
<div class="md-modal md-effect-1 notifications" id="modal-competition-success">
	<div class="md-content">
		<div class="header">
			<div class="close-abs no-bg"><span class="icon-close brand-blue-bg white md-close"></span></div>
			<h1 class="font30 white">Участие в конкурсе</h1>
		</div>
		<div class="infos col-wp">
			<p class="font14 b">Теперь Вы участвуете в конкурсе «Звезды НБА»!</p>
			<p class="font14">Сделайте как можно больше выигрышных ставок в этом рынке и выиграйте 40 000 руб.!</p>

			<div class="more-user pos-rel mg-top">
				<div class="text center"><span class="brand-blue font32 more" >Желаем удачи!</span></div>
			</div>
			<p class="font13 mg-top links">Следить за результатами вы можете в разделе <a class="brand-blue" href="">Мои конкурсы</a>.</p>
			<div class="fill-balance-yellow">
				К матчам конкурса!
			</div>
		</div>
	</div>
</div>

<!-- error -->
<div class="md-modal md-effect-1 notifications" id="modal-competition-error">
	<div class="md-content">
		<div class="header">
			<div class="close-abs no-bg"><span class="icon-close brand-blue-bg white md-close"></span></div>
			<h1 class="font30 white"><?php esc_html_e('Ошибка', 'socialbet'); ?></h1>
		</div>
		<div class="infos col-wp">
			<p class="font14 b"><?php esc_html_e('Что-то пошло не так...', 'socialbet'); ?></p>
			<p class="font14 nmg"><?php esc_html_e('К сожалению,  сейчас мы не можем обработать Ваш запрос, пожалуйста, попробуйте еще раз чуть позже.', 'socialbet'); ?></p>
			<img src="<?php echo get_template_directory_uri() . '/assets/images/error.jpg'; ?>" align="center" width="50%"> 
		</div>
	</div>
</div>

<!-- Participation in the competition -->
<div class="md-modal md-effect-1 notifications" id="modal-enter-contest">
	<div class="md-content">
		<div class="header">
			<div class="close-abs no-bg"><span class="icon-close brand-blue-bg white md-close"></span></div>
			<h1 class="font30 white">Участие в конкурсе</h1>
		</div>
		<div class="infos col-wp">
			<p class="font14 b">Участие в конкурсе «Звезды НБА» – платное.</p>
			<div class="more-user pos-rel mg-top">
				<div class="text center"><span class="brand-blue font32 more" >600 руб.</span></div>
			</div>
			<p class="font13 mg-top links">Эта сумма будет списана с Вашего счета в соответствии с <a class="brand-blue" href="">Правилами Socialbet</a>, <a class="brand-blue" href="">Еще правилами</a>, <a class="brand-blue" href="">и Длинным названием правил</a>.</p>
			<div class="fill-balance-yellow ajax-trigger-enter-competition">
				<?php esc_html_e('да, я хочу Участвовать!', 'socialbet'); ?>
			</div>
			<form class="ajax-enter-competition-form" method="post">
			<?php wp_nonce_field( 'socbet-enter-competition', '_wpajaxentercompetition', true, true ); ?>
			<input type="hidden" name="competition_id" value="<?php esc_attr_e( $post->ID ); ?>" />
			<input type="hidden" name="action" value="socbet_enter_competition" />
			</form>
			<a class="md-trigger trigger-compettion-error hdn-act" data-modal="modal-competition-error"></a>
			<a class="md-trigger trigger-compettion-success hdn-act" data-modal="modal-competition-success"></a>
		</div>
	</div>
</div>
<?php } ?>
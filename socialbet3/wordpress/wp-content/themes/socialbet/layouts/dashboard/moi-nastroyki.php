<?php
/**
 * User general settings template
 * 
 * @version 1.0
 */

if ( ! is_own_profile() )
	return;

global $wp_query, $profile_user, $user_data, $SocBet_Theme;
$errors = "";
$http_post = ('POST' == $_SERVER['REQUEST_METHOD']);

if ( $http_post ) {
	$errors = socbet_save_user_general_settings();
}
?>

<?php get_template_part('layouts/dashboard/setting', 'bar' ); ?>

<div class="user-settings-wrap">

<?php $SocBet_Theme->print_messages($errors); ?>

<form method="post" action="" id="user-settings-general">

<?php wp_nonce_field( 'socbet-user-mysettings', '_wpnonce', true, true ); ?>
<?php wp_nonce_field( 'socbet-user-ajax-mysettings', '_wpajaxsettingnonce', true, true ); ?>

<div class="user-form-row">
	
	<label for="first_name"><?php esc_html_e('Имя', 'socialbet'); ?></label>
	<div class="user-field-col">
		<input type="text" name="first_name" id="first_name" value="<?php esc_attr_e( $user_data['first_name'] ); ?>" />
	</div>
</div>

<div class="user-form-row">
	<label for="last_name"><?php esc_html_e('Фамилия', 'socialbet'); ?></label>
	<div class="user-field-col">
		<input type="text" name="last_name" id="last_name" value="<?php esc_attr_e( $user_data['last_name'] ); ?>" />
	</div>
</div>

<div class="user-form-row">
	<label for="user_sex"><?php esc_html_e('Пол', 'socialbet'); ?></label>
	<div class="user-field-col">
		<select name="user_sex" id="user_sex" class="select">
			<option value="m" <?php selected('m', ( isset($user_data['user_sex']) ? $user_data['user_sex'] : '' ) , true ); ?>><?php print __('Male', 'socialbet'); ?></option>
			<option value="f" <?php selected('f', ( isset($user_data['user_sex']) ? $user_data['user_sex'] : '' ), true ); ?>><?php print __('Female', 'socialbet'); ?></option>
		</select>
	</div>
</div>

<?php
	$userbd = !empty($user_data['user_birthday']) ? explode('-', $user_data['user_birthday'] ) : array( date('d'), date('m'), date('Y'));
?>
<div class="user-form-row">
	<label for="user_birthday"><?php esc_html_e('Дата рождения', 'socialbet'); ?></label>
	<div class="user-field-col">
		<select name="user_birthday[]" class="sel-wd-birth-date select">
			<?php
			for ( $i = 1; $i<32; $i++ ) {
				echo '<option value="'.$i.'" '. selected( $i, $userbd[0], false ) .'>'. ( $i < 10 ? '0'.$i : $i ) .'</option>' . "\n";
			}
			unset($i);
			?>
		</select>
		<select name="user_birthday[]" class="sel-wd-birth-month select">
			<?php
			for ( $i = 1; $i<13; $i++ ) {
				echo '<option value="'.$i.'" '. selected( $i, $userbd[1], false ) .'>'. date('F', mktime(0,0,0, $i, 10) ) .'</option>' . "\n";
			}
			unset($i);
			?>
		</select>
		<select name="user_birthday[]" class="sel-wd-birth-year select">
			<?php
			for ( $i = intval(date('Y')); $i>1930; $i-- ) {
				echo '<option value="'.$i.'" '. selected( $i, $userbd[2], false ) .'>'. $i .'</option>' . "\n";
			}
			unset($i);
			?>
		</select>
	</div>
</div>

<div class="user-form-row">
	<label for="user_country"><?php esc_html_e('Страна', 'socialbet'); ?></label>
	<div class="user-field-col">
		<select name="user_country" id="user_country" class="select full">
			<option value=""<?php if( empty($user_data['user_country']) ) echo ' selected="selected"'; ?>><?php print __('Select a country', 'socialbet'); ?></option>
			<?php
			foreach( $SocBet_Theme->countries->countries as $CD => $CN ) {
				echo '<option value="'.$CD.'" '.selected($CD, ( isset($user_data['user_country'] ) ? $user_data['user_country'] : '' ), false ).'>'.$CN.'</option>' . "\n";
			}
			unset($CN);
			unset($CD);
			?>
		</select>
	</div>
</div>

<div class="user-form-row">
	<label for="user_city"><?php esc_html_e('Город', 'socialbet'); ?></label>
	<div class="user-field-col">
		<select name="user_city" id="user_city" class="select">
		<?php
			$ucountry = isset($user_data['user_country'] ) ? $user_data['user_country'] : '';
			$ustate = isset($user_data['user_city'] ) ? $user_data['user_city'] : '';

			if ( $ucountry != "" )
				$SocBet_Theme->countries->country_dropdown_options( $ucountry, $ustate, false );
			
		?>
		</select>
	</div>
</div>

<h3 class="user-setting-section"><?php esc_html_e('Aккаунт', 'socialbet'); ?></h3>

<div class="user-form-row">
	<label for="user_plan"><?php esc_html_e('Ваш аккаунт', 'socialbet'); ?></label>
	<div class="user-field-col">
		<select name="user_plan" id="user_plan" class="select">
			<option value=""><?php print __('Select a plan', 'socialbet'); ?></option>
			<option value="basic" <?php selected( 'basic', ( isset($user_data['user_plan']) ? $user_data['user_plan'] : '' ) , true ); ?>><?php print __('Basic Plan', 'socialbet'); ?></option>
			<option value="premium" <?php selected( 'premium', ( isset($user_data['user_plan']) ? $user_data['user_plan'] : '' ), true ); ?>><?php print __('Premium Plan', 'socialbet'); ?></option>
		</select>
	</div>
</div>

<div class="user-form-row">
	<label for="user_plan_cost"><?php esc_html_e('Стоимость', 'socialbet'); ?></label>
	<div class="user-field-col">
		<select name="user_plan_cost" class="select" id="user_plan_cost"<?php if( empty($user_data['user_plan']) || $user_data['user_plan'] == 'basic' ) echo ' disabled="disabled"'; ?>>
			<option value=""><?php print __('Select a plan cost', 'socialbet'); ?></option>
			<option value="premium1" <?php selected( 'premium1', ( isset($user_data['user_plan_cost']) ? $user_data['user_plan_cost'] : '' ) , true ); ?>><?php print __('1000 rub/month', 'socialbet'); ?></option>
			<option value="premium2" <?php selected( 'premium2', ( isset($user_data['user_plan_cost']) ? $user_data['user_plan_cost'] : '' ), true ); ?>><?php print __('2900 rub/3 months', 'socialbet'); ?></option>
			<option value="premium3" <?php selected( 'premium3', ( isset($user_data['user_plan_cost']) ? $user_data['user_plan_cost'] : '' ), true ); ?>><?php print __('5500 rub/6 months', 'socialbet'); ?></option>
			<option value="premium4" <?php selected( 'premium4', ( isset($user_data['user_plan_cost']) ? $user_data['user_plan_cost'] : '' ), true ); ?>><?php print __('11000 rub/year', 'socialbet'); ?></option>
		</select>
	</div>
</div>

<p class="user-form-description">
<?php esc_html_e('Премиум аккаунт позволяет Вам получить доступ к статистике игроков за любое время. Сумма списывается раз в месяц с Вашего счета.', 'socialbet'); ?>
</p>

<h3 class="user-setting-section"><?php esc_html_e('Настройки подписки', 'socialbet'); ?></h3>

<div class="user-form-row">
	<label for="user_subscription"><?php esc_html_e('Вид подписки', 'socialbet'); ?></label>
	<div class="user-field-col">
		<select name="user_subscription" id="user_subscription" class="select">
			<option value="free" <?php selected( 'free', ( isset($user_data['user_subscription']) ? $user_data['user_subscription'] : '' ) , true ); ?>><?php print __('Free Subscription', 'socialbet'); ?></option>
			<option value="paid" <?php selected( 'paid', ( isset($user_data['user_subscription']) ? $user_data['user_subscription'] : '' ), true ); ?>><?php print __('Paid Subscription', 'socialbet'); ?></option>
		</select>
	</div>
</div>


<div class="user-form-row only-paid-subscription"<?php if( !isset($user_data['user_subscription']) || ( isset($user_data['user_subscription']) && $user_data['user_subscription'] != 'paid' ) ) echo ' style="display:none;"';  ?>>
	<label for="user_subscription_price"><?php esc_html_e('Сумма списания', 'socialbet'); ?></label>
	<div class="user-field-col">
		<select name="user_subscription_price" id="user_subscription_price" class="sel-wd-half select">
			<option value="0" <?php selected( '0', ( isset($user_data['user_subscription_price']) ? $user_data['user_subscription_price'] : '0' ) , true ); ?>><?php print __('Free', 'socialbet'); ?></option>
			<?php
			$prices = array( '50', '70', '80', '100', '120' );
			foreach( $prices as $price ) {
				echo '<option value="'.$price.'" '.selected( $price, ( isset($user_data['user_subscription_price']) ? $user_data['user_subscription_price'] : '' ) , false ).'>'. $price .' rub.</option>' . "\n";
			}
			unset($price);
			?>
		</select><span class="per-form"><?php esc_html_e('в месяц', 'socialbet'); ?></span>
	</div>
</div>

<div class="user-form-row only-paid-subscription"<?php if( !isset($user_data['user_subscription']) || ( isset($user_data['user_subscription']) && $user_data['user_subscription'] != 'paid' ) ) echo ' style="display:none;"';  ?>>
	<label for="user_subscription_bets"><?php esc_html_e('Количество прогнозов', 'socialbet'); ?></label>
	<div class="user-field-col">
		<select name="user_subscription_bets" id="user_subscription_bets" class="sel-wd-half select">
			<option value="0" <?php selected( '0', ( isset($user_data['user_subscription_bets']) ? $user_data['user_subscription_bets'] : '0' ) , true ); ?>>0</option>
			<?php
			$bets = array( '10', '25', '50', '75', '100' );
			foreach( $bets as $bet ) {
				echo '<option value="'.$bet.'" '.selected( $bet, ( isset($user_data['user_subscription_bets']) ? $user_data['user_subscription_bets'] : '' ) , false ).'>'. $bet .'</option>' . "\n";
			}
			unset($bet);
			?>
		</select><span class="per-form"><?php esc_html_e('в месяц', 'socialbet'); ?></span>
	</div>
</div>

<p class="user-form-description only-paid-subscription"<?php if( ! isset($user_data['user_subscription']) || ( isset($user_data['user_subscription']) && $user_data['user_subscription'] != 'paid' ) ) echo ' style="display:none;"';  ?>>
<?php esc_html_e('У вас выбрана платная единоразовая подписка, теперь Ваши новые подписчики получат доступ к вашей Статистике, Ставкам и Информации только после оплаты. Вы получаете 70% от суммы, указанной вами для списания. Еще текст бла бла бла, здесь мы рассказываем о всяких важных штуках, про оплату и так далее.', 'socialbet'); ?>
</p>

<p class="text-center">
	<button type="submit" class="fill-balance big-button"><?php esc_html_e('создать группу', 'socialbet'); ?></button>
</p>

</form>

</div>


<script>
( function($){
	$(document).ready( function() {
		// first init
		var usrct = $('#user_country').val(), usrpl = $('#user_plan').val();

		$('#user_country').unbind().on('change', function() {
			$('#user_country').prop("disabled", true);
			var data = {
				'action': 'socbet_get_state',
				'_wpajaxsettingnonce' : $('input[name="_wpajaxsettingnonce"]').val(),
				'ajx_country': $('#user_country').val()
			};
			jQuery.post(socbet.ajax_url, data, function(response) {
				$('#user_country').prop("disabled", false);
				$('#user_city').prop("disabled", false);
				if ( response === "" )
					$('#user_city').prop("disabled", true);

				$('#user_city').html( response );
			});
		});


		$('#user_plan').unbind().on('change', function() {
			var vv = $(this).val();
			vv == 'premium' ? $('#user_plan_cost').prop("disabled", false) : $('#user_plan_cost').prop("disabled", true);
		});

		$('#user_subscription').unbind().on('change', function() {
			if ( $(this).val() === 'paid' ) {
				$('.only-paid-subscription').each(function(){
					$(this).is(':hidden') && $(this).slideDown(200, function(){
						$(window).trigger('resize');
					});
				})
			} else {
				$('.only-paid-subscription').each(function(){
					$(this).not(':hidden') && $(this).slideUp(200, function(){
						$(window).trigger('resize');
					});
				})
			}

		});
	});
})( window.jQuery );
</script>
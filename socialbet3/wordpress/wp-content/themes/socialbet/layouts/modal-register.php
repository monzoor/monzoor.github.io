<?php
/**
 * Login and register modal box template
 */
?>

<!-- login -->
<div class="md-modal md-effect-1 loginreg" id="modal-4">
	<div class="md-content">
		<div class="log-reg-wrapper">
			<div class="head brand-blue-bg white">
				<h2 class="fl"><?php esc_html_e('Войти на сайт', 'socialbet'); ?></h2>
				<span class="icon-close md-close fr"></span>
			</div>
			<div class="form-body light-gray-bg">

			<form id="popup-login" action="<?php echo esc_url( site_url( 'wp-login.php', 'login_post' ) ); ?>" method="post">
				<?php wp_nonce_field( 'socbet-user-login', '_wpnonce', true, true ); ?>
				
				<div class="col-wp">
					<p class="mg-bottom"><?php esc_html_e('Войти с помощью', 'socialbet'); ?></p>
					<div class="social-box">
						<?php
						do_action( 'login_form' );
						?>
					</div>
				</div>

				<div class="col-wp npd-top npd-bottom">
					<div class="border-box pos-rel">
						<div class="border"></div>
						<p class="light-gray-bg center"><?php esc_html_e('или', 'socialbet'); ?></p>
					</div>
				</div>

				<div class="col-wp npd-top">
					<div class="form-box form">
							<?php
							$redirect_to = ( is_ssl() ? 'https://' : 'http://' ) . "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
							?>
							<div class="col-wop pos-rel">
								<input type="email" name="log" placeholder="<?php esc_attr_e('почта', 'socialbet'); ?>">
								<div class="form-icon"><span class="icon-email"></span></div>
							</div>

							<div class="col-wop">
								<input type="password" name="pwd" placeholder="<?php esc_attr_e('Пароль', 'socialbet'); ?>">
								<div class="form-icon"><span class="icon-password"></span></div>
							</div>
							<div class="col-wop">
								<input class="fl" type="checkbox" name="rememberme" checked>
								<p class="fl"><?php esc_html_e('Запомнить меня', 'socialbet'); ?></p>
								<a class="fr brand-red mg-top" href="<?php echo esc_url( wp_lostpassword_url( $redirect_to ) ); ?>"><?php esc_html_e('Забыли пароль?', 'socialbet'); ?></a>
							</div>
							<div class="col-wop">

								<input type="hidden" name="redirect_to" value="<?php echo esc_attr($redirect_to); ?>" />
								<input type="hidden" name="testcookie" value="1" />
								<button type="submit" class="fill-balance md-top"><?php esc_html_e('войти', 'socialbet'); ?></button>
							</div>
					</div>
				</div>
				<div class="col-wp npd-top npd-bottom">
					<div class="border"></div>
				</div>
				<div class="col-wp bottom-text">
					<span class="dark-gray mg-top display-blk"><?php esc_html_e('Пока не зарегистрированы на Socialbet?', 'socialbet'); ?></span>
					<span class="brand-red pd-top display-blk md-trigger" data-modal="modal-5"><?php esc_html_e('Зарегистрироваться', 'socialbet'); ?></span>
					<!--<span class="brand-red pd-top display-blk"><a href="<?php echo esc_url( wp_registration_url() ); ?>"><?php esc_html_e('Зарегистрироваться', 'socialbet'); ?></a></span>-->
				</div>

			</form>

			</div>
		</div>
	</div>
</div>
<!-- registration -->
<div class="md-modal md-effect-1 loginreg" id="modal-5">
	<div class="md-content">
		<div class="log-reg-wrapper">
			<div class="head brand-blue-bg white">
				<h2 class="fl"><?php esc_html_e('Регистрация', 'socialbet'); ?></h2>
				<span class="icon-close md-close fr"></span>
			</div>
			<div class="form-body light-gray-bg">

			<form id="popup-register" action="<?php echo esc_url( site_url('wp-login.php?action=register', 'login_post') ); ?>" method="post" novalidate="novalidate">
				<?php wp_nonce_field( 'socbet-user-register', '_wpnonce', true, true ); ?>

				<div class="col-wp">
					<p class="mg-bottom"><?php esc_html_e('Войти с помощью', 'socialbet'); ?></p>
					<div class="social-box">
						<?php
						/**
						 * Fires following the 'Password' field in the login form.
						 *
						 * @since 2.1.0
						 */
						do_action( 'register_form' );
						?>
					</div>
				</div>
				<div class="col-wp npd-top npd-bottom">
					<div class="border-box pos-rel">
						<div class="border"></div>
						<p class="light-gray-bg center"><?php esc_html_e('или', 'socialbet'); ?></p>
					</div>
				</div>
				
				<div class="col-wp">
					<div class="form form-box">
	
						<div class="col-wop">
							<input type="text" name="reg_username" placeholder="<?php esc_attr_e('Имя пользователя', 'socialbet'); ?>" value="" />
							<div class="form-icon"><span class="icon-userlogin"></span></div>
						</div>

						<div class="col-wop">
							<input type="text" name="reg_firstname" placeholder="<?php esc_attr_e('Имя', 'socialbet'); ?>">
							<div class="form-icon"><span class="icon-userlogin"></span></div>
						</div>

						<div class="col-wop">
							<input type="text" name="reg_lastname" placeholder="<?php esc_attr_e('Фамилия', 'socialbet'); ?>">
							<div class="form-icon"><span class="icon-userlogin"></span></div>
						</div>


						<div class="col-wop">
							<input type="email" name="reg_email" placeholder="<?php esc_attr_e('Электронная почта', 'socialbet'); ?>">
							<div class="form-icon"><span class="icon-email"></span></div>
						</div>

						<div class="col-wop">
							<input type="password" name="reg_pwd" placeholder="<?php esc_attr_e('Пароль', 'socialbet'); ?>">
							<div class="form-icon"><span class="icon-password"></span></div>
						</div>

						<div class="col-wop">
							<input type="password" name="reg_pwdc" placeholder="<?php esc_attr_e('Подтвердите пароль', 'socialbet'); ?>">
							<div class="form-icon"><span class="icon-password"></span></div>
						</div>

						<div class="col-wop">
							<input class="fl" type="checkbox" value="yes" name="reg_notify"  checked>
							<p class="fl"><?php esc_html_e('Сообщать мне о новостях Socialbet', 'socialbet'); ?></p>
						</div>

						<div class="col-wop">
							<p class="fl"><?php esc_html_e('Регистрируясь, вы соглашаетесь с', 'socialbet'); ?> <a class="brand-blue" href=""><?php esc_html_e('Условиями предоставления услуг', 'socialbet'); ?></a>, <a class="brand-blue" href=""><?php esc_html_e('Политикой конфиденциальности', 'socialbet'); ?></a>, <a class="brand-blue" href=""><?php esc_html_e('Правилами компенсации', 'socialbet'); ?></a> Socialbet.</p>
						</div>

						<div class="col-wop">
							<button type="submit" name="wp-submit" class="fill-balance md-top"><?php esc_html_e('зарегистрироваться', 'socialbet'); ?></button>
						</div>

					</div>
					<div class="col-wp">
						<div class="border"></div>
					</div>
					<div class="col-wp bottom-text">
						<span class="dark-gray mg-top display-blk"><?php esc_html_e('Вы уже зарегистрированы на Socialbet?', 'socialbet'); ?></span>
						<a href="" class="brand-red pd-top display-blk md-close" data-modal="modal-4"><?php esc_html_e('Войти', 'socialbet'); ?></a>
					</div>
				</div>

			</form>
			</div>
		</div>
	</div>
</div>

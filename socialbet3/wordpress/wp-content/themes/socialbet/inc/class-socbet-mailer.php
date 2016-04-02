<?php
/**
 * mail Class
 *
 */
if ( ! defined( 'ABSPATH' ) )
	exit;

class Socbet_Mailer {
	private $_email_from_name;
	private $_email_from_mail;
	private $_mail_content_type;

	public function __construct() {
		add_action( 'socbet_email_header', array($this,'socbet_email_header') );
		add_action( 'socbet_email_footer', array($this,'socbet_email_footer') );
	}


	function socbet_email_header( $email_subject ) {
		extract( array('email_subject' => $email_subject) );
		include( get_template_directory() . '/layouts/email/header.php' );
	}


	function socbet_email_footer() {
		include( get_template_directory() . '/layouts/email/footer.php' );
	}

	function sent_mail( $email_to, $subject, $content, $headers = "Content-Type: text/html\r\n", $content_type = 'text/html', $attachments = '' ){
		$this->_mail_content_type = $content_type;

		add_filter( 'wp_mail_from', array($this,'get_from_email') );
		add_filter( 'wp_mail_from_name', array($this,'get_from_name') );
		add_filter( 'wp_mail_content_type', array($this,'get_content_type') );

		wp_mail( $email_to, $subject, $content, $headers, $attachments );

		// Unhook filters
		remove_filter( 'wp_mail_from', array($this,'get_from_email') );
		remove_filter( 'wp_mail_from_name', array($this,'get_from_name') );
		remove_filter( 'wp_mail_content_type', array($this,'get_content_type') );
	}


	public function sent_subscribtion_verify( $email, $link ) {
		$email_to = $email;
		$subject = stripslashes( get_option( 'socbetsoon_email_subject', 'Please Confirm Subscription' ) );

		$button_text = stripslashes( get_option( 'socbetsoon_email_button_text', 'Yes, subscribe me to this list' ) );
		$content = '<a href="' . esc_url( $link ) . '" style="color:#ffffff!important;display:inline-block;font-weight:500;font-size:16px;line-height:42px;font-family:\'Helvetica\',Arial,sans-serif;width:auto;white-space:nowrap;min-height:42px;margin:12px 5px 12px 0;padding:0 22px;text-decoration:none;text-align:center;border:0;border-radius:3px;vertical-align:top;background-color:#76c0c4!important" target="_blank"><span style="display:inline;font-family:\'Helvetica\',Arial,sans-serif;text-decoration:none;font-weight:500;font-style:normal;font-size:16px;line-height:42px;border:none;background-color:#76c0c4!important;color:#ffffff!important">' . $button_text . '</span></a><br/><br/>';
		
		if ( get_option( 'socbetsoon_email_content' ) ) {
			$content .= stripslashes( nl2br( get_option( 'socbetsoon_email_content' ) ) );
		} else {
			$content .= esc_html__( 'If you received this email by mistake, simply delete it. You won\'t be subscribed if you don\'t click the confirmation link above.', 'socialbet' ) . '<br/>';
			$content .= esc_html__( 'Best Regards.', 'socialbet' ) . '<br/><br/>';
			$content .= esc_html__( 'For questions about this list, please contact:', 'socialbet' ) . '<br/>';
			$content .= get_bloginfo( 'admin_email' );
		}

		$emailBody = $this->general_mail_content( $content, $subject );
		$email_text_content = $emailBody;

		$this->sent_mail( $email_to, $subject, $email_text_content, "Content-Type: text/html\r\n", 'text/html', '' );

		return true;
	}


	public function new_member_email( $body_text, $first_name, $confirmation_id, $user_login, $user_mail ){
		if ( !$first_name || !$confirmation_id ) 
			return;	

		$confirmation_url = $this->create_confirmation_url( $confirmation_id, $user_login  );
		$email_to = $user_mail;
		$subject = esc_html__( 'Добро пожаловать в SocialBet', 'socialbet' );
		
		$button_text = esc_html__( 'Проверьте Мой e-mail', 'socialbet' );
		$button_link = '<br/><a href="' . esc_url( $confirmation_url ) . '" style="color:#ffffff!important;display:inline-block;font-weight:500;font-size:16px;line-height:42px;font-family:\'Helvetica\',Arial,sans-serif;width:auto;white-space:nowrap;min-height:42px;margin:12px 5px 12px 0;padding:0 22px;text-decoration:none;text-align:center;border:0;border-radius:3px;vertical-align:top;background-color:#76c0c4!important" target="_blank"><span style="display:inline;font-family:\'Helvetica\',Arial,sans-serif;text-decoration:none;font-weight:500;font-style:normal;font-size:16px;line-height:42px;border:none;background-color:#76c0c4!important;color:#ffffff!important">' . $button_text . '</span></a><br/><br/>';

		$content = str_replace( '{confirmation_link}', $button_link, $body_text );
		$content = str_replace( '{firstname}', $first_name, $content );

		$emailBody = $this->general_mail_content( $content, $subject );

		$this->sent_mail( $email_to, $subject, $emailBody, "Content-Type: text/html\r\n", 'text/html', '' );
	}


	public function new_invitation_email( $body_text, $confirmation_id, $user_mail ) {
		if ( !$confirmation_id ) 
			return;

		$confirm_url = $this->create_invitation_url( $confirmation_id, $user_mail );
		$email_to = $user_mail;
		$subject = esc_html__( 'Приглашение присоединиться к SocialBet', 'socialbet' );

		$button_text = esc_html__( 'Принять приглашение', 'socialbet' );
		$button_link = '<br/><a href="' . esc_url( $confirm_url ) . '" style="color:#ffffff!important;display:inline-block;font-weight:500;font-size:16px;line-height:42px;font-family:\'Helvetica\',Arial,sans-serif;width:auto;white-space:nowrap;min-height:42px;margin:12px 5px 12px 0;padding:0 22px;text-decoration:none;text-align:center;border:0;border-radius:3px;vertical-align:top;background-color:#76c0c4!important" target="_blank"><span style="display:inline;font-family:\'Helvetica\',Arial,sans-serif;text-decoration:none;font-weight:500;font-style:normal;font-size:16px;line-height:42px;border:none;background-color:#76c0c4!important;color:#ffffff!important">' . $button_text . '</span></a><br/><br/>';

		$content = str_replace( '{confirmation_link}', $button_link, $body_text );
		$emailBody = $this->general_mail_content( $content, $subject );

		$this->sent_mail( $email_to, $subject, $emailBody, "Content-Type: text/html\r\n", 'text/html', '' );
	}


	public function password_reset_email( $body_text, $subject, $user_mail ) {

		$emailBody = $this->general_mail_content( $body_text, $subject );
		$this->sent_mail( $user_mail, $subject, $emailBody, "Content-Type: text/html\r\n", 'text/html', '' );
	}

	function create_confirmation_url( $confirmation_id, $user_login ){

		return network_site_url("wp-login.php?action=emailconfirmation&emailkey=$confirmation_id&login=" . rawurlencode($user_login), 'login');
	}

	function create_invitation_url( $confirmation_id, $email ){

		return network_site_url("wp-login.php?action=invitation&invitekey=$confirmation_id&invite_email=" . rawurlencode($email), 'login');
	}

	function get_from_email() {
		if ( $this->_email_from_mail ) 
			return $this->_email_from_mail;

		return $this->_email_from_mail = get_option( 'socbetsoon_email_sender', get_bloginfo( 'admin_email' ) );
	}


	function get_from_name() {
		if ( $this->_email_from_name ) 
			return $this->_email_from_name;

		return $this->_email_from_name = get_bloginfo('name');
	}

	function get_content_type() {
		return $this->_mail_content_type;
	}


	function general_mail_content( $content, $heading ) {
		ob_start();
		
		extract( array(
			'email_subject' => $heading,
			'emailContent' => $content
		));

		include( get_template_directory() . '/layouts/email/email-body.php' );

		return ob_get_clean();
	}
}
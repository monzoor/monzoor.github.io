<?php
/**
 * Admin functions
 */

if ( ! defined('ABSPATH') ) 
	exit;

function get_socbet_email_settings() {
	$settings = array();

	$content = 'If you received this email by mistake, simply delete it. You won\'t be subscribed if you don\'t click the confirmation link above.' . "\n";
	$content .= 'Best Regards.' . "\n\n";
	$content .= 'For questions about this list, please contact:' . "\n";
	$content .= get_bloginfo('admin_email');

	$settings[] = array(
		'id' 		=> 'socbetsoon_email_sender',
		'setting_id' => 'socbetsoon_email_sender',
		'default_value' => get_bloginfo('admin_email'),
		'type'			=> 'email',
		'label'			=> __('Email', 'socialbet'),
		'desc'			=> __('"From/Sender" email setting.', 'socialbet'),
		'class'			=> ''
		);

	$settings[] = array(
		'id' 		=> 'socbetsoon_email_subject',
		'setting_id' => 'socbetsoon_email_subject',
		'default_value' => 'Please Confirm Subscription',
		'type'			=> 'textbox',
		'label'			=> __('Email Subject', 'socialbet'),
		'desc'			=> __('Email subject for confirmation email', 'socialbet'),
		'class'			=> ''
		);

	$settings[] = array(
		'id' 		=> 'socbetsoon_email_button_text',
		'setting_id' => 'socbetsoon_email_button_text',
		'default_value' => 'Yes, subscribe me to this list',
		'type'			=> 'textbox',
		'label'			=> __('Button Text', 'socialbet'),
		'desc'			=> '',
		'class'			=> ''
		);

	$settings[] = array(
		'id' 		=> 'socbetsoon_email_content',
		'setting_id' => 'socbetsoon_email_content',
		'default_value' => $content,
		'type'			=> 'textarea',
		'label'			=> __('Content', 'socialbet'),
		'desc'			=> __('Enter the email content.', 'socialbet'),
		'class'			=> 'large'
		);

	return $settings;
}


/**
 * get setting lists
 * 
 * @return array()
 */
function get_socbet_settings() {

	$settings = array();

	$settings[] = array(
		'id' => '',
		'setting_id' => '',
		'type'			=> 'section',
		'label'			=> '',
		'title'			=> __('Index Page Content', 'socialbet'),
		);

	$settings[] = array(
		'id' 		=> 'socbetsoon_index_title',
		'setting_id' => 'socbetsoon_index_title',
		'default_value' => 'Social Bet – это новый проект как для начинающих, так и для уже опытных игроков.',
		'type'			=> 'textbox',
		'label'			=> __('Content Title', 'socialbet'),
		'desc'			=> __('Enter the title for index page', 'socialbet'),
		'class'			=> ''
		);

	$settings[] = array(
		'id' 		=> 'socbetsoon_index_content',
		'setting_id' => 'socbetsoon_index_content',
		'default_value' => 'Здесь вы найдете для себя все, что нужно именно вам: лучшие коэффициенты от крупных и надежных букмекеров; сообщества, подходящие Вам по интересам; возможность следить за лучшими прогнозистами, а также зарабатывать на своих прогнозах;  доступ к полной и подробной статистике ваших ставок.',
		'type'			=> 'textarea',
		'label'			=> __('Content', 'socialbet'),
		'desc'			=> '',
		'class'			=> ''
		);

	$settings[] = array(
		'id' => 'socbetsoon_index_before_email',
		'setting_id' => 'socbetsoon_index_before_email',
		'default_value' => 'Оставьте нам свой e-mail, и мы оповестим Вас об открытии!',
		'type'			=> 'textbox',
		'label'			=> __('Text Before Subscribe Form', 'socialbet'),
		'desc'			=> __('Some teaser before the subscribe form', 'socialbet'),
		'class'			=> ''
		);

	$settings[] = array(
		'id' => '',
		'setting_id' => '',
		'type'			=> 'section',
		'label'			=> '',
		'title'			=> __('"After Submission" Page Content', 'socialbet'),
		);

	$settings[] = array(
		'id' 		=> 'socbetsoon_index_after_saved_title',
		'setting_id' => 'socbetsoon_index_after_saved_title',
		'default_value' => 'Thank you for subscribing to the Social Bet program',
		'type'			=> 'textbox',
		'label'			=> __('Title', 'socialbet'),
		'desc'			=> __('Enter the title for page after email submission', 'socialbet'),
		'class'			=> ''
		);

	$settings[] = array(
		'id' 		=> 'socbetsoon_index_after_saved_content',
		'setting_id' => 'socbetsoon_index_after_saved_content',
		'default_value' => 'We have sent you an email, Please confirm your subscription by clicking on the link contained in the e-mail.',
		'type'			=> 'textarea',
		'label'			=> __('Content', 'socialbet'),
		'desc'			=> __('Enter the content', 'socialbet'),
		'class'			=> ''
		);


	$settings[] = array(
		'id' => '',
		'setting_id' => '',
		'type'			=> 'section',
		'label'			=> '',
		'title'			=> __('"Thank You" Page Content - After Email Address Confirmed', 'socialbet'),
		);

	$settings[] = array(
		'id' 		=> 'socbetsoon_thankyou_page_title',
		'setting_id' => 'socbetsoon_thankyou_page_title',
		'default_value' => 'Thank you for subscribing to the Social Bet program',
		'type'			=> 'textbox',
		'label'			=> __('Title', 'socialbet'),
		'desc'			=> __('Enter the title for page after email submission', 'socialbet'),
		'class'			=> ''
		);

	$settings[] = array(
		'id' 		=> 'socbetsoon_thankyou_page_content',
		'setting_id' => 'socbetsoon_thankyou_page_content',
		'default_value' => 'Thank you for subscribing to the Social Bet program.',
		'type'			=> 'textarea',
		'label'			=> __('Content', 'socialbet'),
		'desc'			=> __('Enter the content', 'socialbet'),
		'class'			=> ''
		);

	return $settings;
}
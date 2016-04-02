<?php
/**
 * email template content
 *
 */
if ( ! defined( 'ABSPATH' ) ) exit;

do_action( 'socbet_email_header', $email_subject ); ?>

<?php print $emailContent; ?>

<?php do_action( 'socbet_email_footer' ); ?>
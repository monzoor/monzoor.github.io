<?php

function make_gmail_pop3_connection() {
	global $pop3temp;

	if ( ! empty( $pop3temp ) )
		return;

	if ( empty( $phpmailer->Username ) )
		return;

	require_once( ABSPATH . 'wp-includes/class-pop3.php' );

	//$start = microtime( true );

	$pop3temp = new POP3( '', 1 );
	$pop3temp->connect( 'ssl://pop.gmail.com', 995 );

	// Not necessarily required
	$pop3temp->user( $phpmailer->Username );
	$pop3temp->pass( $phpmailer->Password );


	//error_log( 'gmail connection took: ' . ( microtime( true ) - $start ) );
}

//add_action( 'phpmailer_init', 'make_gmail_pop3_connection' );


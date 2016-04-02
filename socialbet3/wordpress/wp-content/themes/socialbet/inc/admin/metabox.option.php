<?php
/**
 * Options for metaboxes
 */

if ( ! defined( 'ABSPATH' ) )
	exit;

function socbet_event_meta_options() {
	global $post;
	
	$meta_options = array(
		'event_datetime' => array(
			'type' 	=> 'datetime',
			'id'	=> '_'.SOCIALBET_NAME.'_event_datetime',
			'label' => __( 'Event Date and Time', 'socialbet' ),
			'desc' 	=> __( 'Set the date and time of the event!', 'socialbet' ),
			'std' 	=> ''
		),
		'event_id' => array(
			'type' 	=> 'text',
			'id'	=> '_'.SOCIALBET_NAME.'_event_id',
			'label' => __( 'Event ID', 'socialbet' ),
			'desc' 	=> __( 'The unique identifier of event/game', 'socialbet' ),
			'std' 	=> ''
		),
		'event_live' => array(
			'type' 	=> 'one_check',
			'id'	=> '_'.SOCIALBET_NAME.'_event_live',
			'label' => __( 'is Live?', 'socialbet' ),
			'desc' 	=> __( 'Whether or not the event is live', 'socialbet' ),
			'std' 	=> 'no'
		),
		'event_live_status' => array(
			'type' 	=> 'text',
			'id'	=> '_'.SOCIALBET_NAME.'_event_live_status',
			'label' => __( 'Live Status', 'socialbet' ),
			'desc' 	=> __( 'Live status of the event', 'socialbet' ),
			'std' 	=> '0'
		),
		'event_status' => array(
			'type' 	=> 'text',
			'id'	=> '_'.SOCIALBET_NAME.'_event_status',
			'label' => __( 'Event Status', 'socialbet' ),
			'desc' 	=> __( 'Status of the event.', 'socialbet' ),
			'std' 	=> '0'
		),
		'event_drawRotNum' => array(
			'type' 	=> 'text',
			'id'	=> '_'.SOCIALBET_NAME.'_event_drawRotNum',
			'label' => __( 'Rotation number for draw', 'socialbet' ),
			'desc' 	=> __( 'Present only for sports/leagues where draw is possible.', 'socialbet' ),
			'std' 	=> '0'
		),
	);
	
	return $meta_options;
}

function socbet_event_tiplist_options() {
	$meta_options = array(
		'event_tips' => array(
			'type' => 'event_tip_lists',
			'form' => false,
		),
	);

	return $meta_options;
}

function socbet_event_marketlist_options() {
	$meta_options = array(
		'event_markets' => array(
			'type' => 'event_market_lists',
			'form' => false,
		),
	);

	return $meta_options;
}

function socbet_competition_options() {
	$meta_options = array(
		'competition_end' => array(
			'type' 	=> 'datetime',
			'id'	=> '_'.SOCIALBET_NAME.'_competition_end',
			'label' => __( 'Ending Date', 'socialbet' ),
			'desc' 	=> __( 'Set the ending date and time of the competition!', 'socialbet' ),
			'std' 	=> ''
		),
		'competition_price' => array(
			'type' 	=> 'text',
			'inputtype' => 'number',
			'id'	=> '_'.SOCIALBET_NAME.'_competition_price',
			'label' => __( 'The Price', 'socialbet' ),
			'desc' 	=> __( 'Set the price of the competition, put 0 for free competition', 'socialbet' ),
			'std' 	=> '0'
		),
		'competition_prize' => array(
			'type' 	=> 'text',
			'inputtype' => 'number',
			'id'	=> '_'.SOCIALBET_NAME.'_competition_prize',
			'label' => __( 'The Prize', 'socialbet' ),
			'desc' 	=> __( 'Set the main prize of the competition!', 'socialbet' ),
			'std' 	=> '0'
		),
		'competition_rules_desciption' => array(
			'type' 	=> 'textarea_editor',
			'id'	=> '_'.SOCIALBET_NAME.'_competition_rules_desciption',
			'label' => __( 'Competition Rules Info', 'socialbet' ),
			'desc' 	=> '',
			'std' 	=> ''
		),
	);
	
	return $meta_options;
}
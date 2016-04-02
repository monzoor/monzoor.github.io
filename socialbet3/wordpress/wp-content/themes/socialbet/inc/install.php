<?php
/**
 * Register some custom tables 
 * 
 * @since 1.0
 */


function socbet_20141029_installation() {
	socbet_create_tables();
}

function socbet_create_tables() {
	global $wpdb;

	$wpdb->hide_errors();

	// change the table creation and follow this http://codex.wordpress.org/Creating_Tables_with_Plugins
	$charset_collate = $wpdb->get_charset_collate();
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );


	// create event details table
	$eventDetailsTable = $wpdb->prefix . 'socbet_event_detail';
	if ( $wpdb->get_var("show tables like '$eventDetailsTable'") != $eventDetailsTable ) {
		$eventDetailssql = "CREATE TABLE IF NOT EXISTS $eventDetailsTable (
			  `id` bigint(20) UNSIGNED NOT NULL auto_increment,
			  `post_id` bigint(20),
			  `event_id` bigint(20),
			  `startDateTime` varchar(20),
			  `isLive` varchar(20),
			  `live_status` varchar(20),
			  `status` varchar(20),
			  `drawRotNum` varchar(20),
			  UNIQUE KEY id (`id`) ) $charset_collate;";

		dbDelta( $eventDetailssql );
	}

	// create teams on event table
	$eventTeamsTable = $wpdb->prefix . 'socbet_event_team';
	if ( $wpdb->get_var("show tables like '$eventTeamsTable'") != $eventTeamsTable ) {
		$eventTeamssql = "CREATE TABLE IF NOT EXISTS $eventTeamsTable (
			  `id` bigint(20) UNSIGNED NOT NULL auto_increment,
			  `event_id` bigint(20),
			  `homeTeam_type` varchar(20),
			  `homeTeam_name` varchar(20),
			  `homeTeam_rotNum` varchar(20),
			  `homeTeam_pitcher` varchar(20),
			  `homeTeam_redCards` varchar(20),
			  `homeTeam_score` varchar(20),
			  `awayTeam_type` varchar(20),
			  `awayTeam_name` varchar(20),
			  `awayTeam_rotNum` varchar(20),
			  `awayTeam_pitcher` varchar(20),
			  `awayTeam_redCards` varchar(20),
			  `awayTeam_score` varchar(20),
			  UNIQUE KEY id (`id`) ) $charset_collate;";

		dbDelta( $eventTeamssql );
	}

	// create periods on event table
	$eventPeriodTable = $wpdb->prefix . 'socbet_event_period';
	if ( $wpdb->get_var("show tables like '$eventPeriodTable'") != $eventPeriodTable ) {
		$eventPeriodsql = "CREATE TABLE IF NOT EXISTS $eventPeriodTable (
			  `id` bigint(20) UNSIGNED NOT NULL auto_increment,
			  `event_id` bigint(20),
			  `lineID` bigint(20),
			  `altLineId` bigint(20) NOT NULL DEFAULT '0',
			  `preiodNumber` varchar(20),
			  `description` text,
			  `cutoffDateTime` varchar(20),
			  `moneyLine_awayPrice` varchar(20),
			  `moneyLine_homePrice` varchar(20),
			  `moneyLine_drawPrice` varchar(20),
			  `homeTeamTotal` varchar(20),
			  `homeTeamTotal_overprice` varchar(20),
			  `homeTeamTotal_underprice` varchar(20),
			  `awayTeamTotal` varchar(20),
			  `awayTeamTotal_overprice` varchar(20),
			  `awayTeamTotal_underprice` varchar(20),
			  `maxBetAmount_spread` varchar(20),
			  `maxBetAmount_totalPoints` varchar(20),
			  `maxBetAmount_moneyLine` varchar(20),
			  `maxBetAmount_teamTotals` varchar(20),
			  UNIQUE KEY id (`id`) ) $charset_collate;";

		dbDelta( $eventPeriodsql );
	}

	// create spreads on event table
	$eventSpreadTable = $wpdb->prefix . 'socbet_event_spreads';
	if ( $wpdb->get_var("show tables like '$eventSpreadTable'") != $eventSpreadTable ) {
		$eventSpreadsql = "CREATE TABLE IF NOT EXISTS $eventSpreadTable (
			  `id` bigint(20) UNSIGNED NOT NULL auto_increment,
			  `period_lineID` bigint(20),
			  `spread_altLineId` bigint(20) NOT NULL DEFAULT '0',
			  `awaySpread` varchar(20),
			  `awayPrice` varchar(20),
			  `homeSpread` varchar(20),
			  `homePrice` varchar(20),
			  UNIQUE KEY id (`id`) ) $charset_collate;";

		dbDelta( $eventSpreadsql );
	}

	// create spreads on event table
	$eventTotalsTable = $wpdb->prefix . 'socbet_event_totals';
	if ( $wpdb->get_var("show tables like '$eventTotalsTable'") != $eventTotalsTable ) {
		$eventTotalsql = "CREATE TABLE IF NOT EXISTS $eventTotalsTable (
			  `id` bigint(20) UNSIGNED NOT NULL auto_increment,
			  `period_lineID` bigint(20),
			  `total_altLineId` bigint(20) NOT NULL DEFAULT '0',
			  `points` varchar(20),
			  `overPrice` varchar(20),
			  `underPrice` varchar(20),
			  UNIQUE KEY id (`id`) ) $charset_collate;";

		dbDelta( $eventTotalsql );
	}

	// create event market table
	$marketTable = $wpdb->prefix . 'socbet_markets';
	if ( $wpdb->get_var("show tables like '$marketTable'") != $marketTable ) {
		$marketsql = "CREATE TABLE IF NOT EXISTS $marketTable (
			  `id` bigint(20) UNSIGNED NOT NULL auto_increment,
			  `event_id` bigint(20),
			  `name` text,
			  `slug` varchar(200),
			  `meta_data` longtext,
			  UNIQUE KEY id (`id`) ) $charset_collate;";

		dbDelta( $marketsql );
	}

	// create odds tables
	$oddsTable = $wpdb->prefix . 'socbet_odds';
	if ( $wpdb->get_var("show tables like '$oddsTable'") != $oddsTable ) {
		$sqlodds = "CREATE TABLE IF NOT EXISTS $oddsTable (
			  `id` bigint(20) UNSIGNED NOT NULL auto_increment,
			  `market_id` bigint(20),
			  `name` text,
			  `slug` varchar(200),
			  `odds` varchar(20),
			  `decimal_odds` varchar(20),
			  `shop_url` varchar(200),
			  `price` varchar(50),
			  `meta_data` longtext,
			  UNIQUE KEY id (`id`) ) $charset_collate;";

		dbDelta( $sqlodds );
	}

	// create a table to log user betting history
	$bets_table = $wpdb->prefix . 'socbet_bets';
	if ( $wpdb->get_var("show tables like '$bets_table'") != $bets_table ) {
		$sqlbets = "CREATE TABLE IF NOT EXISTS $bets_table (
			  `id` bigint(20) UNSIGNED NOT NULL auto_increment,
			  `user_id` bigint(20),
			  `odds_id` bigint(20),
			  `bet` varchar(200),
			  `status` int(11) NOT NULL DEFAULT '0',
			  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
			  `meta_data` longtext,
			  UNIQUE KEY id (`id`) ) $charset_collate;";

		dbDelta( $sqlbets );
	}

	$msg_table = $wpdb->prefix . 'socbet_messages';
	if ( $wpdb->get_var("show tables like '$msg_table'") != $msg_table ) {
		$sqlmsg = "CREATE TABLE IF NOT EXISTS $msg_table (
			  `id` bigint(20) UNSIGNED NOT NULL auto_increment,
			  `user_id` bigint(20),
			  `user_id_to` bigint(20),
			  `message` longtext NOT NULL,
			  `attachment_ids` longtext NOT NULL,
			  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
			  `status` int(11) NOT NULL DEFAULT '0',
			  UNIQUE KEY id (`id`) ) $charset_collate;";

		dbDelta( $sqlmsg );
	}

	$msg_reply_table = $wpdb->prefix . 'socbet_message_replies';
	if ( $wpdb->get_var("show tables like '$msg_reply_table'") != $msg_reply_table ) {
		$sqlrply = "CREATE TABLE IF NOT EXISTS $msg_reply_table (
			  `id` bigint(20) UNSIGNED NOT NULL auto_increment,
			  `message_id` bigint(20),
			  `user_id` bigint(20),
			  `message` longtext NOT NULL,
			  `attachment_ids` longtext NOT NULL,
			  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
			  `status` int(11) NOT NULL DEFAULT '0',
			  UNIQUE KEY id (`id`) ) $charset_collate;";

		dbDelta( $sqlrply );
	}

	$invitation_table = $wpdb->prefix . 'socbet_invitation';
	if ( $wpdb->get_var("show tables like '$invitation_table'") != $invitation_table ) {
		$sqlinvite = "CREATE TABLE IF NOT EXISTS $invitation_table (
			  `ID` bigint(20) UNSIGNED NOT NULL auto_increment,
			  `email` varchar(100) NOT NULL DEFAULT '',
			  `invitation_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
			  `invitation_by` bigint(20) NOT NULL DEFAULT '0',
			  `invitation_key` varchar(60) NOT NULL DEFAULT '',
			  `status` int(11) NOT NULL DEFAULT '0',
			  UNIQUE KEY id (`ID`) ) $charset_collate;";

		dbDelta( $sqlinvite );
	}
}
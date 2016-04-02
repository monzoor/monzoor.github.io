<?php
/**
 * DB class, 
 * just helper to make some queries
 *
 * @since ver 1.0
 */

if ( ! defined('ABSPATH') )
	exit;

if ( ! class_exists('SBDB') ) {

class SBDB {

	public function __construct () {
		global $wpdb;
	}

	/**
	 * get results from db
	 *
	 * @param $table = string table name
	 * @param $ids = array || int
	 * @param $int = define if the col value is int or string
	 *
	 * @return object || bool
	 */
	public static function get_results( $table = "", $col = "", $ids = array(), $int = true ) {
		global $wpdb;

		if ( empty($table) )
			return false;

		if ( empty($ids) )
			return false;

		$where = "";
		if ( is_array($ids) ) {
			$idused = join(', ', $ids );
			$where = " WHERE {$col} IN ('{$idused}')";
		} else {
			$dbid = $int ? absint( $ids ) : $ids;
			$where = " WHERE {$col} = '{$dbid}'";
		}

		$results = $wpdb->get_results("SELECT * FROM {$wpdb->$table}{$where}");
		
		//error_log("SELECT * FROM {$wpdb->$table}{$where}");
		
		if ( $results )
			return $results;
		else
			return false;

	}

	public static function count( $table = "", $where = "" ) {
		global $wpdb;

		if ( empty($table) )
			return false;

		$dbwhere = "";
		if ( !empty($where) )
			$dbwhere = " WHERE ".$where;

		$count = $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->$table}{$dbwhere}" );

		return $count;
	}

	public static function get_row( $table = "", $where = ""  ) {
		global $wpdb;

		if ( empty($table) )
			return false;

		if ( empty($where) )
			return false;

		$row = $wpdb->get_row( "SELECT * FROM {$wpdb->$table} WHERE {$where}" );

		return $row;
	}

}

$GLOBALS['sbdb'] = new SBDB();

}
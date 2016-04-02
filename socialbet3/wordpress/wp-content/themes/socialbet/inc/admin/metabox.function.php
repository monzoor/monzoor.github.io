<?php
/**
 * admin functions
 */

if ( ! defined( 'ABSPATH' ) )
	exit;

if ( ! function_exists('limit_text') ) {
	function limit_text( $text, $limit, $more = '...' ) {
		# figure out the total length of the string
		if ( strlen($text)>$limit ) {
			# cut the text
			$text = substr( $text,0,$limit );
			$text = $text . $more;
		}

		# return the processed string
		return $text;
	}
}
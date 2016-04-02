<?php
/**
 * Php class json helper
 * to get data from api
 */

if ( ! defined('ABSPATH') )
	exit;

if ( ! class_exists('SocbetJsonHndler') ) {

	class SocbetJsonHndler {
		// var $api_url
		protected $api_url = 'http://api.odds24.com/';
		protected $api_id;
		protected $api_key;
		public $output_lang;

		public function __construct( $id = false, $key = false, $lang = 'en' ) {
			if ( ! $id || ! $key )
				return false;

			// set the api id
			$this->api_id = $id;
			// set the api key
			$this->api_key = $key;
			// set the output languange
			$this->output_lang = $lang;
		}

		public function get_event_categories() {
			if( ! $this->api_id || ! $this->api_key ) {
				error_log('Fail: cannot accesing api id and api key');
				return 'Fail: cannot accesing api id and api key';
			}

			$url = $this->api_url . 'odds?app_id='. $this->api_id . '&app_key='. $this->api_key . '&lang='.$this->output_lang.'&format=json';

			$Context = stream_context_create( array(
			'http' => array(
			    'method' => 'GET',
			    'timeout' => 30,
			)
			));
			$request  = @file_get_contents( $url, false, $Context );
			$response = json_decode( $request );

			if ( isset( $response->message ) ) {
				
				error_log('Failed: to get data - ' . $response->message );
				return false;
			}

			return $response;
		}


		public function insert_update_event_cats() {
			$json = $this->get_event_categories();

			if ( !$json ) {
				error_log('Failed to generated json data');
				return false;
			}

			// info: the category code, thumbail URL and image URL are saved in other fields (we use option option table)
			// since WP only provide small fields for each taxonomy

			// first: get top parent of tree
			if ( isset( $json->p0 ) && is_array( $json->p0 ) ) {

				foreach( $json->p0 as $key => $data ) {
					
					$term_misc_data = array(
						'code' 	=> $data->c,
						'logo'	=> $data->l,
						'thumbnail' => $data->t
						);
					
					// well we are updating this then
					if ( $prntId = term_exists( $data->s, 'sport_type', 0 ) ) {
						
						$this->inject_tax_loop( $data->i, $json, $prntId['term_id'] );
						update_option( "sport_type_{$prntId['term_id']}_data", $term_misc_data );

					} else {
						$saved = wp_insert_term( $data->n, 'sport_type', array( 'slug' => $data->s ));
						$thisId = $saved['term_id'];

						$this->inject_tax_loop( $data->i, $json, $thisId );
						update_option( "sport_type_{$thisId}_data", $term_misc_data );
					}

				}
				unset( $data );
				unset( $key );

			}
		}

		// loop into the data, and start fill the db
		public function inject_tax_loop( $array_key, $json, $parent_term_id ) {
			$ak = 'p'.$array_key;

			if ( isset( $json->$ak ) && is_array( $json->$ak ) ) {

				foreach( $json->$ak as $key => $data ) {
					$term_misc_data = array(
						'code' 	=> $data->c,
						'logo'	=> $data->l,
						'thumbnail' => $data->t
						);

					if( $prntId = term_exists( $data->s, 'sport_type', absint($parent_term_id) ) ) {
						
						$this->inject_tax_loop( $data->i, $json, $prntId['term_id'] );

						update_option( "sport_type_{$prntId['term_id']}_data", $term_misc_data );

					} else {

						$saved = wp_insert_term( $data->n, 'sport_type', array( 'slug' => $data->s, 'parent' => absint($parent_term_id) ));
						if ( ! is_wp_error( $saved ) ) {
							$thisId = $saved['term_id'];
							$this->inject_tax_loop( $data->i, $json, $thisId );

							update_option( "sport_type_{$thisId}_data", $term_misc_data );
						}
					}

				}
				unset( $data );
				unset( $key );
			}

			return false;
		}

	}


}
<?php

/**
 * Jobs
 *
 * This class handles API management
 *
 * @package     WP support
 * @subpackage  Classes/Tasks
 * @copyright   Copyright (c) 2018, Language table - WP support
 * @license     http://opensource.org/license/gpl-2.1.php GNU Public License
 * @since       1.0
 */


// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

//create a task
	//this remains the users task
		// a task is turned into a job advertised
	

/**
 * WPS_logs
 *
 * @since 1.0
 */


class WPS_api {



	/**
	 * Assign some values to "this"
	 *
	 * @since   1.5
	 * @return  void
	 */
	function __construct() {
		global $wpdb;
			$this->api_db_name = $wpdb->prefix."WPS_api";
	}

	
	

	 /**
	 * Generate a rand hash.
	 *
	 * @since  1.1
	 * @return string
	 */

	static function wpsc_rand_hash() {
		if ( ! function_exists( 'openssl_random_pseudo_bytes' ) ) {
			return sha1( wp_rand() );
		}
		return bin2hex( openssl_random_pseudo_bytes( 20 ) ); // @codingStandardsIgnoreLine
	}



	/**
	 * WPSC API - Hash.
	 *
	 * @since  1.1
	 * @param  string $data Message to be hashed.
	 * @return string
	 */

	static function wpsc_api_hash( $data ) {
		return hash_hmac( 'sha256', $data, 'wpsc-api' );
	}

	/**
	 * Delete API key
	 *
	 * @since  1.1
	 * @param  
	 * @return 
	 */

	static function delete_api_backup_key(){
		global $wpdb;
		$table = $wpdb->prefix.'WPS_api_keys';
		$wpdb->query( "DELETE FROM $table" );
	}

	static function insert_new_api_keys(){
		global $wpdb;


		$table = $wpdb->prefix.'WPS_api_keys';

 
		// delete all previous entries
			//working for v1
		$wpdb->query( "DELETE FROM $table" );


		$description = 'wpscomplete_base_api';
		$permissions = 'read/write';
		$user_id = get_current_user_id();
		$consumer_key    = 'wpsck_' . self::wpsc_rand_hash();
		$consumer_secret = 'wpscs_' . self::wpsc_rand_hash();
		$stored_consumer_key = self::wpsc_api_hash( $consumer_key );

		

		$add = $wpdb->query(
			$wpdb->prepare(
				"INSERT INTO $table SET
					`user_id`         = '%d',
					`description`     = '%s',
					`permissions`     = '%s',
					`consumer_key`    = '%s',
					`consumer_secret` = '%s',
					`truncated_key`   = '%s'
				;",

 				$user_id,
				$description,
 				$permissions,
				$stored_consumer_key,
				$consumer_secret,
				substr( $consumer_key, -7 )
			)
		);

		return [$add,$consumer_key,$consumer_secret];
	}
}

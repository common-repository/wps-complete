<?php 

/**
 * Admin Actions funcitons
 *
 * @package     wp_support
 * @subpackage  user_actions
 * @copyright   Copyright (c) 2018, Restrict Content Pro
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */


if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Add new API - Redirect to custom tab for new API key.
 *
 * @since  1.1
 * @param  
 * @return none
 */


function wpsc_create_api_key(){
	global $wpdb;
	if ( ! wp_verify_nonce( $_POST['wpsc_create_key_api'], 'wpsc_create_key_api' ) ) {
		wp_die( __( 'Nonce verification failed.', 'wps' ), __( 'Error', 'wps' ), array( 'response' => 403 ) );
	}
	if( current_user_can('manage_options')  ){
		$url =  admin_url( 'admin.php?page=WPS&tab=new_api_setup&wps_message=new_api' );
	} else {
		$url =  admin_url( 'admin.php?page=WPS&tab=api_setup&wps_message=error' );
	}
	wp_safe_redirect( $url ); 
}
add_action('WPS_action_create-new-api-key','wpsc_create_api_key');



/**
 * Test API / Deliver backup after a request is made
 *
 * @since  1.1
 * @param  
 * @return none
 */


function wpsc_generate_backup_request(){
	global $wpdb;

	if( ! isset( $_POST['type'] ) ){
		$_POST['type'] = '';
	}

	$description = 'wpscomplete_base_api';
	$keys = $wpdb->get_row( $wpdb->prepare( "SELECT key_id, user_id, permissions, consumer_key, consumer_secret, nonces FROM {$wpdb->prefix}WPS_api_keys WHERE description = '%s' ", $description ), ARRAY_A );
	if( ! $keys ){
		$url = admin_url( 'admin.php?page=wpsc_backup&tab=data_remote_files&url=leoday.one&wps_message=disconnect' );
		wp_safe_redirect( $url );
	}

	$dm = new WPS_data_management;
	$sqlScript = $dm->wpsc_generate_mysql_backup();
	if( $dirpath = $dm->setup_directory_for_writing() ){
		$dm->clearup_temp_directory( $dirpath );
		$file_name = $dm->write_file_to_directory( $dirpath , $sqlScript );
		$zip_name = $dm->zip_backup_directory( $dirpath, $file_name );
	}

	$url = 'https://wpscomplete.com/wp-json/wpscb/v1/backup/1';

	$file = @fopen( $dirpath.'/'.$zip_name, 'r' );
	$file_size = filesize( $dirpath."/".$zip_name );
	$file_data = fread( $file, $file_size );
	$file_data = base64_encode( $file_data );

	$response = wp_remote_post( $url, array(
	    'method'      => 'POST',
	    'timeout'     => 45,
	    'redirection' => 5,
	    'httpversion' => '1.0',
	    'blocking'    => true,
	    // 'headers'     => array(	
	    // 	'accept'	=> 'application/json', // The API returns JSON				
	    // 	'content-type'  => 'application/binary', // Set content type to binary			
	    // ),
	    'headers' 	  => array(),
	    'body'        => array(
	    	'type' => $_POST['type'],
	        'consumer_key' => $keys['consumer_key'],
	        'consumer_secret' => $keys['consumer_secret'],
	        'db_file' => $file_data,
	        'db_file_name' => $zip_name,
	    ), 
	    'cookies'     => array()
	    )
	);
	 
	if ( is_wp_error( $response ) ) {
	    $error_message = $response->get_error_message();
	    echo "Something went wrong: $error_message";
	} else {
	    return $response['body'];
	}
}
add_action('WPS_action_test-new-api-key','wpsc_generate_backup_request');



add_action( 'rest_api_init', function () {
  register_rest_route( 'wpsc/v1', '/backup_request/(?P<id>\d+)', array(
    'methods' => WP_REST_Server::ALLMETHODS,
    'callback' => 'initiate_backup',
    'args' => array(
      'id' => array(
        'validate_callback' => function($param, $request, $key) {
          return is_numeric( $param );
        }
      ),
    ),
    'permission_callback' => function () {
      // return current_user_can( 'edit_others_posts' );
    	return true;
    },
  ) );
} );


/**
 * Run the generate backup request
 *
 * @param 
 * @return 
 */
function initiate_backup() {
	return wpsc_generate_backup_request();
}


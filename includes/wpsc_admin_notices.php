<?php
/**
 * Admin notices, all WPS notices are in the admin area....
 *
 * @package     wp_support
 * @subpackage  user_actions
 * @copyright   Copyright (c) 2018, Restrict Content Pro
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */


// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Process all WP Support actions sent via POST and GET
 *
 * @since 1.0
 * @return void
 */
function wpsc_admin_notices( ) {
	global $wpsc_options;

	$message = ! empty( $_GET['wps_message'] ) ? urldecode( $_GET['wps_message'] ) : false;
	$class   = 'updated';
	$text    = '';

	// chat messages
	switch( $message ){
		case 'chat_remove_user' :
				$text = __( 'The user was removed.', 'wps' );
				$class = 'notice notice-success is-dismissible';
			break;
		case 'chat_added_user' :
				$text = __( 'The user was added.', 'wps' );
				$class = 'notice notice-success is-dismissible';
			break;
		case 'session_deleted' :
				$text = __( 'The session was deleted.', 'wps' );
				$class = 'notice notice-success is-dismissible';
			break;
		case 'session_left' :
				$text = __( 'You have left the chat session.', 'wps' );
				$class = 'notice notice-success is-dismissible';
			break;
	}


	//general messages
	switch( $message ){
		case 'error' :
				$text = __( 'There was an error.', 'wps' );
				$class = 'notice error is-dismissible';
			break;
	}

	//backup
	switch( $message ){
		case 'success_backup_restore' :
				$text = __( 'The backup was restored.', 'wps' );
				$class = 'notice notice-success is-dismissible';
			break;
		case 'success_backup_download' :
				$text = __( 'The backup was downloaded.', 'wps' );
				$class = 'notice notice-success is-dismissible';
			break;
		case 'success_backup_create' :
				$text = __( 'A backup was created.', 'wps' );
				$class = 'notice notice-success is-dismissible';
			break;
		case 'plugins_restored':
				$text = __( 'Plugins local backup was restored.', 'wps' );
				$class = 'notice notice-success is-dismissible';
			break;
		case 'plugins_backed_up':
				$text = __( 'Plugins local backed up.', 'wps' );
				$class = 'notice notice-success is-dismissible';
			break;
			
			
	}

	//api
	switch( $message ){
		case 'new_api' :
				$text = __( 'A new API key was generated.', 'wps' );
				$class = 'notice notice-success is-dismissible';
			break;
		case 'error_no_api' :
				$text = __( 'A new API key was generated.', 'wps' );
				$class = 'notice notice-success is-dismissible';
			break;
	}



	//Job messages
	switch( $message ){

		case 'no_caps' :
				$text = __( 'You do not have the capability for this.', 'wps' );
				$class = 'notice error is-dismissible';
			break;

		case 'delete_successful' :
				$text = __( 'You have deleted the file.', 'wps' );
				$class = 'notice notice-success is-dismissible';
			break;
		case 'too_many_files' :
				$text = __( 'You have uploaded over maximum 10 files.', 'wps' );
				$class = 'notice error is-dismissible';
			break;
		case 'file_upload_too_big' :
				$text = __( 'One of your file uploads is over the max 2mb', 'wps' );
				$class = 'notice error is-dismissible';
			break;
		
		case 'only_draft_editing' :
				$text = __( 'Once advertised, you can only change the job status, editing the job is not allowed.', 'wps' );
				$class = 'notice error is-dismissible';
			break;

		case 'update_error' :
				$text = __( 'There was an error, please try again.', 'wps' );
				$class = 'notice error is-dismissible';
			break;
		case 'max_advertisements' :
				$text = __( 'You have reached your maximum 4 advertisements.', 'wps' );
				$class = 'notice error is-dismissible';
			break;
		case 'max_consultations' :
				$text = __( 'You have reached your maximum monthly subscription inclusive consultations. Please upgrade your subscription in the Account tab or choose another job type.', 'wps' );
				$class = 'notice error is-dismissible';
			break;
	}

		if( $message ) {
			echo '<div class="' . $class . '"><p>' . $text . '</p></div>';
		}
}
add_action( 'admin_notices', 'wpsc_admin_notices' );


/**
 * Dismiss an admin notice for current user
 *
 * @access      private
 * @return      void
*/
// function rcp_dismiss_notices() {

// 	if( empty( $_GET['rcp_dismiss_notice_nonce'] ) || empty( $_GET['rcp_notice'] ) ) {
// 		return;
// 	}

// 	if( ! wp_verify_nonce( $_GET['rcp_dismiss_notice_nonce'], 'rcp_dismiss_notice') ) {
// 		wp_die( __( 'Security check failed', 'rcp' ), __( 'Error', 'rcp' ), array( 'response' => 403 ) );
// 	}

// 	$notice = sanitize_key( $_GET['rcp_notice'] );

// 	update_user_meta( get_current_user_id(), "_rcp_{$notice}_dismissed", 1 );

// 	do_action( 'rcp_dismiss_notices', $notice );

// 	wp_redirect( remove_query_arg( array( 'rcp_notice' ) ) );
// 	exit;

// }
// add_action( 'admin_init', 'rcp_dismiss_notices' );
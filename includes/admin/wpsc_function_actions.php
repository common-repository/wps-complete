<?php
/**
 * Admin Actions
 *
 * @package     wp_support
 * @subpackage  user_actions
 * @copyright   Copyright (c) 2018, Restrict Content Pro
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */


// ini_set('display_startup_errors', 1);
// ini_set('display_errors', 1);
// error_reporting(-1);
// var_dump($_POST);

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Process all WP Support actions sent via POST and GET
 *
 * @since 1.0
 * @return void
 */
function WPS_process_actions() {
// echo 'WPS_action_' . $_POST['WPS-action'];
	if ( isset( $_POST['WPS-action'] ) ) {
		do_action( 'WPS_action_' . $_POST['WPS-action'], $_POST );
		// echo 'Do: WPS_action_' . $_POST['WPS-action'];
	}

	if ( isset( $_GET['WPS-action'] ) ) {
		do_action( 'WPS_action_' . $_GET['WPS-action'], $_GET );
	}
}
add_action( 'admin_init', 'WPS_process_actions' );
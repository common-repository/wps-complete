<?php

/*
Plugin Name: WPS Complete
Plugin URI: https://wpscomplete.com/wps-complete-plugin/
Description: Default plugin required to support our plugin suite available at <a target="_blank" href="https://wpscomplete.com/plugins/">WPS Complete</a>
Author: WPScomplete.com
Version: 0.8.2
Author URI: https://wpscomplete.com
*/
// function dothis(){
// $role = 'subscriber';
//  $addMemberToGroup = new WP_User(2);
//  $addMemberToGroup->remove_role( $role );
// }
//  add_action('init','dothis');
// ini_set('display_startup_errors', 1);
// ini_set('display_errors', 1);
// error_reporting(-1);

if ( !defined( 'WPS_PLUGIN_DIR' ) ) {
	define( 'WPS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}
if ( !defined( 'WPS_PLUGIN_URL' ) ) {
	define( 'WPS_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}
if ( !defined( 'WPS_PLUGIN_FILE' ) ) {
	define( 'WPS_PLUGIN_FILE', __FILE__ );
}
if ( !defined( 'WPS_PLUGIN_VERSION' ) ) {
	define( 'WPS_PLUGIN_VERSION', '1.0' );
}
if ( !defined( 'WPS_PLUGIN_DIR_STORAGE' ) ) {
	define( 'WPS_PLUGIN_DIR_STORAGE', 'wpsc_complete' );
}


//********************************************
//includes
//********************************************


require( WPS_PLUGIN_DIR . 'includes/class_wps_file_util.php' );
require( WPS_PLUGIN_DIR . 'includes/class_wps_api.php' );
require( WPS_PLUGIN_DIR . 'includes/api/wpsc_api_functions.php' );
require( WPS_PLUGIN_DIR . 'includes/wpsc_setup_scripts.php' );
require( WPS_PLUGIN_DIR . 'includes/wpsc_template_wp_support.php' );
require( WPS_PLUGIN_DIR . 'includes/wpsc_admin_notices.php' );
require( WPS_PLUGIN_DIR . 'includes/admin/wpsc_function_actions.php' );


global $WPS_api_db_version;
$WPS_api_db_version = '1.2';

function WPS_api_database() {
    global $wpdb;
    global $WPS_api_db_version;

    if ( $WPS_api_db_version != get_option('WPS_api_db_version' ) ){
        update_option( 'lt_dd_subscriptions_version', $WPS_api_db_version );
    }

    $table_name = $wpdb->prefix . 'WPS_api_keys';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
 				`key_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
 				`user_id` bigint(20) unsigned NOT NULL,
 				`description` varchar(200) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
 				`permissions` varchar(10) COLLATE utf8mb4_unicode_520_ci NOT NULL,
 				`consumer_key` char(64) COLLATE utf8mb4_unicode_520_ci NOT NULL,
 				`consumer_secret` char(43) COLLATE utf8mb4_unicode_520_ci NOT NULL,
 				`nonces` longtext COLLATE utf8mb4_unicode_520_ci,
 				`truncated_key` char(7) COLLATE utf8mb4_unicode_520_ci NOT NULL,
 				`last_access` datetime DEFAULT NULL,
 				PRIMARY KEY (`key_id`),
 				KEY `consumer_key` (`consumer_key`),
 				KEY `consumer_secret` (`consumer_secret`)
		) $charset_collate;";



    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	@dbDelta( $sql );
    add_option( 'WPS_api_db_version', $WPS_api_db_version );
}

register_activation_hook( __FILE__, 'WPS_api_database' );


// deactivations


// register_deactivation_hook(__FILE__, 'my_deactivation');

// function my_deactivation() {
//     wp_clear_scheduled_hook('my_hourly_event');
// }





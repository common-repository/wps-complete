<?php

/**
 * Load admin stylesheets
 *
 * @param string $hook Page hook.
 *
 * @return void
 */

function WPS_admin_styles( $hook ) {
	if($hook != 'toplevel_page_WPS') {
        return;
     }
		wp_enqueue_style( 'WPS_admin_styles',  WPS_PLUGIN_URL . 'includes/css/WPS_admin_styles.css', array(), WPS_PLUGIN_VERSION );
		wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'); 
}
add_action( 'admin_enqueue_scripts', 'WPS_admin_styles' );


/**
 * Display user role in page
 *
 * @param string $hook Page hook.
 *
 * @return void
 */
if( ! function_exists('wpsc_get_user_role') ){
	function wpsc_get_user_role( $user = null ) {
		$user = $user ? new WP_User( $user ) : wp_get_current_user();
		return $user->roles ? $user->roles[0] : false;
	}
}

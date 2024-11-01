<?php

/**
 * Template prepared for adding features in next version.
 *
 * @package     Central setup for admin area
 * @subpackage  Admin/System Info
 * @copyright   Copyright (c) 2018 WPScomplete.com
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */

//create WPS backend menu option
add_action( 'admin_menu', 'wpsc_support_menu' );

/** Step 1. */
function wpsc_support_menu() {
	$page_title = "Your support";
	$menu_title = "WPS Complete";
	$capability = 'manage_options';
	$menu_slug = "WPS";
	$function = "wpsc_support_plugin_options";
	$icon_url = 'dashicons-feedback';
	$position = 4;
	
	add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );

	if ( is_plugin_active( 'wps-admin-menus/wps_admin_menus.php' ) ) {
		add_submenu_page( 'WPS', __( 'Admin Menu', 'wpsc' ), __( 'Admin Menu', 'wpsc' ), 'manage_options', 'wpsc_menu', 'wpsc_admin_menus_setup' );
	}
	if ( is_plugin_active( 'wps-backup/wps_backup.php' ) ) {
		add_submenu_page( 'WPS', __( 'Backup', 'wpsc' ), __( 'Backup', 'wpsc' ), 'manage_options', 'wpsc_backup', 'wpsc_backup_setup' );
	}
}


/** Step 3. */
function wpsc_support_plugin_options() {

	if ( ! current_user_can( 'read' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	settings_errors();

	echo '<div class="wrap">';
	
	function wpsc_admin_tabs( $current = 'homepage' ) {
	    $tabs = array( 	'homepage' => 'WPS Complete' );

	    if( current_user_can( 'manage_options' ) ){
	    	$tabs['tools'] = ' Dev Tools';
	    	$tabs['api_setup'] = ' API Setup';
	    	// $tabs['wps_account'] = ' WPS Account';
	    }
	    switch($current){
	    	case 'new_api_setup':
	    		$tabs['new_api_setup'] = ' New API';
	    	 	break;

	    }

	    $current === 'profile' ? $tabs['profile'] = "Profile" : "";

	    echo '<div id="icon-themes" class="icon32"><br></div>';
	    echo '<h2 class="nav-tab-wrapper">';
	    foreach( $tabs as $tab => $name ){
	        $class = ( $tab == $current ) ? ' nav-tab-active' : "";
	        $url_include = "";
    		'jobs' === $tab  ? $url_include .= '&job_list_view=my_jobs' : "";
    		'quotes' === $tab  ? $url_include .= '&user_quotes_nav=sent_quotes' : ""; 
    		echo "<a class='nav-tab$class' href='?page=WPS&tab=$tab" . $url_include . "'>$name</a>";
	    }
	    echo '</h2>';
	}

	//subnav used for tasks
	function wpsc_sub_tabs($current = 'current'){

		$url_include = "";
		$tabs = array();

		//upgrading to this switch

		switch( $current ){
			case 'quotes_sent':
					// $tabs['quotes_sent'] = 'Sent';
					// $tabs['quotes_received'] = 'Received';
				break; 
			case 'quotes_received':
					// $tabs['quotes_sent'] = 'Sent';
					// $tabs['quotes_received'] = 'Received';
				break; 
			case 'homepage':
					$tabs['dashboard'] = 'Dashboard';
					$tabs['about'] = 'About';
				break; 
			case 'dashboard':
					$tabs['dashboard'] = 'Dashboard';
					$tabs['about'] = 'About';
				break; 
			case 'about':
					$tabs['dashboard'] = 'Dashboard';
					$tabs['about'] = 'About';
				break; 
			case 'account':
					$tabs['general_account'] = 'General';
					$tabs['notifications'] = 'Notifications';
				break; 
			case 'general_account':
					$tabs['general_account'] = 'General';
					$tabs['notifications'] = 'Notifications';
				break; 
			case 'notifications':
					$tabs['general_account'] = 'General';
					$tabs['notifications'] = 'Notifications';
				break; 
			case 'admin_area':
					$tabs['notes'] = 'Notes';
					$tabs['functions'] = 'Functions';
				break; 
			case 'notes':
					$tabs['notes'] = 'Notes';
					$tabs['functions'] = 'Functions';
				break;
			case 'functions':
					$tabs['notes'] = 'Notes';
					$tabs['functions'] = 'Functions';
				break;
			case 'cron':
			case 'current_user':
			case 'user_roles':
			case 'system':
			case 'plugins':
			case 'wordpress':
			case 'registered_image_sizes':
			case 'menus':
					$tabs['plugins'] = 'Plugins';
					$tabs['cron'] = 'Cron Job';
					$tabs['system'] = 'System';
					$tabs['current_user'] = 'Current User';
					$tabs['user_roles'] = 'User roles';
					$tabs['wordpress'] = 'Wordpress';
					$tabs['registered_image_sizes'] = 'Image Sizes';
					$tabs['menus'] = 'Menus';
				break;
		}

		echo '<div id="icon-themes" class="icon32"><br></div>';
	    echo '<h2 class="nav-tab-wrapper">';
	    foreach( $tabs as $tab => $name ){
	        $class = ( $tab == $current ) ? ' nav-tab-active' : "";
	        $add_job_id = "&job_id=";  
	    	'edit_job_quote' === $tab || 'view_job_quote' === $tab ? $url_include .= '&quote_id='.$_GET['quote_id'] : ""; 
	    	'jobs' === $tab || 'current' === $tab ? $url_include .= '&job_list_view=my_jobs' : ""; 
	    	echo "<a class='nav-tab$class' href='?page=WPS&tab=$tab" . $add_job_id . $url_include . "'>$name</a>";
	    }
	    echo '</h2>';

	}
	

	//build the settings page
	function wpsc_settings_page() {
	   global $pagenow;

	   if( isset($_GET['tab']) && $_GET['tab'] != 'homepage' ){

		   switch( $_GET['tab'] ){
		   	 case 'current':
		   	 case 'create':
		   	 case 'available':
		   	 case 'view_job':
		   	 case 'edit_job':
		   	 case 'view_job_quote':
		   	 case 'edit_job_quote':
		   	 case 'job_logs':
		   	 		wpsc_admin_tabs('jobs');
		   	 	break;
		   	 case 'quotes_sent':
		   	 case 'quotes_received':
		   	 		wpsc_admin_tabs('quotes');
		   	 	break;
		   	 case 'about':
		   	 case 'dashboard':
		   	 		wpsc_admin_tabs('homepage');
		   	 	break;
		   	 case 'general_account':
		   	 case 'notifications':
		   	 		wpsc_admin_tabs('account');
		   	 	break;
		   	 case 'notes':
		   	 case 'functions':
		   	 		wpsc_admin_tabs('admin_area');
		   	 	break;
		   	 case 'cron':
		   	 case 'current_user':
		   	 case 'user_roles':
		   	 case 'system':
		   	 case 'plugins':
		   	 case 'wordpress':
		   	 case 'registered_image_sizes':
		   	 		wpsc_admin_tabs('tools');
		   	 	break;
		   	 default:
		   	 	wpsc_admin_tabs($_GET['tab']);
		   }
		} else {
			wpsc_admin_tabs('homepage');
		}
	}


	//call the setting page to be built
	wpsc_settings_page(); 

	//call the pages for each tab selected
	if( ! isset( $_GET['tab'] ) ){ $_GET['tab'] = 'homepage'; }



	//select content to display
	switch ( $_GET['tab'] ) {
	    case 'wps_account':
	    		include "account/wpsc_template_account_tab.php";
	        break;
	    case 'api_setup':
	    		include "api/wpsc_template_api_tab.php";
	        break;
	    case 'new_api_setup':
	    		include "api/wpsc_template_new_api_tab.php";
	        break;
	    case 'general_account':
	    		wpsc_sub_tabs( 'general_account' );
	        	include "WPS_account_tab.php";
	        break;
	    case 'homepage':
	    		wpsc_sub_tabs( 'dashboard' );
	        	include "wp_support_tab.php";
	        break;
	    case 'dashboard':
	    		wpsc_sub_tabs( 'dashboard' );
	        	include "wp_support_tab.php";
	        break;
	     case 'tools':
	    		wpsc_sub_tabs( 'plugins' );
	        	include "tools/WPS_dev_plugins_tab.php";
	        break;
        case 'cron':
     			wpsc_sub_tabs( 'cron' );
     			include "tools/WPS_dev_cron_tab.php";
     		break;
     	case 'current_user':
     			wpsc_sub_tabs( 'current_user' );
     	 		echo '<br/>';
     	 		include "tools/WPS_dev_user_tab.php";
        	break;
        case 'user_roles':
     			wpsc_sub_tabs( 'user_roles' );
     			global $wp_roles;
				echo '<pre>' . print_r( $wp_roles, true ) . '</pre>';
        	break;
        case 'registered_image_sizes':
     			wpsc_sub_tabs( 'registered_image_sizes' );
     			global $_wp_additional_image_sizes;
     			echo '<h3>' . 'Current registered images sizes' . '</h3>';
     			echo '<p>' . "New sizes are registered with:" . "</p>";
     			echo "<code>" . 'add_image_size( string $name, int $width, int $height, bool|array $crop = false )' . '</code>';
     			echo "<p><code> wp_get_attachment_image_src( $attachment->ID, 'attached-image') </code> is to retreive the original attahcment file" . '</p>';
				echo '<pre>' . print_r( $_wp_additional_image_sizes, true ) . '</pre>';
        	break;
        case 'system':
     			wpsc_sub_tabs( 'system' );
     	 		include "tools/WPS_dev_systems_tab.php";
        	break;
        case 'wordpress':
     			wpsc_sub_tabs( 'wordpress' );
     	 		include "tools/WPS_dev_wordpress_tab.php";
        	break;
         case 'plugins':
     			wpsc_sub_tabs( 'plugins' );
     	 		include "tools/WPS_dev_plugins_tab.php";
        	break;
	    case 'create':
	    		wpsc_sub_tabs( $_GET['tab'] );
				require "WPS_template_create_tasks_tab.php";
	    	break;
	    case 'available':
	    		wpsc_sub_tabs( $_GET['tab'] );
				require "WPS_template_available_tab.php";
	    	break;
	    case 'instructions':
	    		include "WPS_instructions.php";
	    	break;
	    case 'jobs':
	    		wpsc_sub_tabs( 'current' );
				require "WPS_template_current_tab.php";
	    	break;
	    case 'current':
	    		wpsc_sub_tabs( 'current');
	    		require "WPS_template_current_tab.php";
	    	break;
	     case 'view_job':
	     		wpsc_sub_tabs( 'view_job');
	       		include "WPS_template_view_job.php";
	        break;
	     case 'edit_job':
	     		wpsc_sub_tabs('edit_job');
	       		include "WPS_template_edit_job.php";
	        break;
	     case 'job_logs':
	     		wpsc_sub_tabs('job_logs');
	       		include "WPS_template_job_logs.php";
	        break;
	     case 'contractors':
	       		include "WPS_template_contractors_tab.php";
	        break;
	    case 'faq':
	    		include "wp_faq_tab.php";
	    	break;
	    case 'about':
	    wpsc_sub_tabs($_GET['tab']);
	    		include "wpsc_about_tab.php";
	    		
	    		// wpsc_sub_tabs( 'dashboard' );
	    	break;
	    case 'profile':
	       		include "WPS_template_profile_tab.php";
	    	break;
	    case 'admin_area':
	     		wpsc_sub_tabs('notes');
	     		include "WPS_template_admin_ref_notes_tab.php";
	        break;
	     case 'functions':
	     		wpsc_sub_tabs($_GET['tab']);
	       		include "WPS_template_admin_ref_functions_tab.php";
	        break;
	    case 'notes':
	     		wpsc_sub_tabs($_GET['tab']);
	     		include "WPS_template_admin_ref_notes_tab.php";
	        break;
	     case 'menus':
	     		wpsc_sub_tabs($_GET['tab']);
	     		include "tools/WPS_dev_menu_tab.php";
	        break;
	}
	echo '</div>';
}
?>
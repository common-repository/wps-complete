<?php 



if( current_user_can( 'manage_options' ) ){ //admin only ?

	/*
	*	Admin / Toolbar bar menu
	*/

	//to do
		///not firing correctly yet
	add_action( 'admin_bar_menu', 'remove_wp_logo');
	function remove_wp_logo( $wp_admin_bar ) {
		echo '<pre>' . print_r( $wp_admin_bar, true ) . '</pre>';
	}


	/*
	*	Admin side menu
	*
	*/

	global $menu, $submenu, $parent_file, $submenu_file;
	echo '<pre>' . print_r( array( $menu, $submenu, $parent_file, $submenu_file ), true ) . '</pre>';

}
?>


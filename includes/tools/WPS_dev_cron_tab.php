<?php 

if( current_user_can( 'manage_options' ) ){

	echo "<h4>A list of scheduled events to happen in your wordpres site</h4>";

	function wpsc_print_tasks() {
    	echo '<pre class="">'; print_r( _get_cron_array() ); echo '</pre>';
	}

	wpsc_print_tasks();
}

?>
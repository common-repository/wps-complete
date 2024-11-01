<?php 
if( current_user_can( 'manage_options' ) ){ //admin only ?
	
	$return="";
	$plugins = get_plugins();

	$updates = get_plugin_updates();

	$muplugins = get_mu_plugins();

	$return .= "\n" . '-- Must-Use Plugins' . "\n\n";

	if( count( $muplugins  ) > 0 ) {
		$return .= "\n" . '-- Must-Use Plugins' . "\n\n";

		foreach( $muplugins as $plugin => $plugin_data ) {
			$return .= $plugin_data['Name'] . ': ' . $plugin_data['Version'] . "\n";
		}

		$return = apply_filters( 'rcp_system_info_after_wordpress_mu_plugins', $return );
	}

	// WordPress active plugins
	$return .= "\n" . '-- WordPress Active Plugins' . "\n\n";

	$active_plugins = get_option( 'active_plugins', array() );

	foreach( $plugins as $plugin_path => $plugin ) {
		if( !in_array( $plugin_path, $active_plugins ) )
			continue;

		$update = ( array_key_exists( $plugin_path, $updates ) ) ? ' (needs update - ' . $updates[$plugin_path]->update->new_version . ')' : '';

		$return .= $plugin['Name'] . ': ' . $plugin['Version'] . $update . "\n";
	}

	// WordPress inactive plugins
	$return .= "\n" . '-- WordPress Inactive Plugins' . "\n\n";

	foreach( $plugins as $plugin_path => $plugin ) {
		if( in_array( $plugin_path, $active_plugins ) )
			continue;

		$update = ( array_key_exists( $plugin_path, $updates ) ) ? ' (needs update - ' . $updates[$plugin_path]->update->new_version . ')' : '';
		$return .= $plugin['Name'] . ': ' . $plugin['Version'] . $update . "\n";
	}

	$return .= "\n" . '-- All plugin information' . "\n\n";
	echo '<pre>' . print_r( $return, true ) . '</pre>';

	echo '<pre>' . print_r( $plugins, true ) . '</pre>';

}

?>


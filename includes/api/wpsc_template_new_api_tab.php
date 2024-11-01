<br/>

<?php  

	$api = WPS_api::insert_new_api_keys(); 
	$url = site_url();
	$is_https = substr( $url , 0 , 8 );
	$is_http = substr( $url , 0 , 7 );
	if($is_https == 'https://'){
		$url = substr( $url , 8 );
	}
	if($is_http == 'http://'){
		echo "WPS Backup requires ssl authenticated encryption on your site ( https:// )";
		exit;
	}
	$site_url = $url;

?>

<h4>Your API key: This will only be revealed once, a new one can be generated if you lose these details.</h4>

<h4>Before using 'Add key to WPScomplete.com' button please ensure you are registered an logged in at WPScomplete.com.&nbsp;&nbsp<a href="https://wpscomplete.com/register/" target="_blank" >Register</a>&nbsp;&nbsp;<a href="https://wpscomplete.com/wp-login.php" target="_blank" >Login</a></h4>

<form action="https://wpscomplete.com/wp-admin/admin.php?page=wpsc_account&tab=new_api_key" method="post" target="_blank" >
	<input style="width:75%" type="text" name="public_key" value="<?php echo $api[1] ?>" /><br/>
	<input style="width:75%" type="text" name="secret_key" value="<?php echo $api[2] ?>" />
	<input type="hidden" name="WPS-bridge" value="connect-new-api-key"/>
	<input type="hidden" name="client_url" value="<?php echo $site_url ?>" >
	<?php wp_nonce_field( 'wpsc_connect_key_api', 'wpsc_connect_key_api' ); ?>
	<?php submit_button("Add key to WPScomplete.com"); ?>
</form>


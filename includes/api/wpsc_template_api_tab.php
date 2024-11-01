


<?php 

global $wpdb;
$description = 'wpscomplete_base_api';
$keys = $wpdb->get_row( $wpdb->prepare( "SELECT key_id, user_id, permissions, consumer_key, consumer_secret, nonces FROM {$wpdb->prefix}WPS_api_keys WHERE description = '%s' ", $description ), ARRAY_A );
if(!$keys){
	$api_key_wpscomplete = false;
} else {
	$api_key_wpscomplete = true;
}

global $wpdb;
$table = $wpdb->prefix."WPS_api_keys";
$data = $wpdb->get_results("SELECT * FROM " . $table . " LIMIT 1");
if( $data ){
	$user_data = get_user_by('id',$data[0]->user_id);	
}


?>

<br/>

<?php if($data){ ?>
<p>Created by: <?php echo $user_data->data->display_name ?></p>
<p>API Public key ending in: ...<?php echo $data[0]->truncated_key ?></p>
<?php 
	if(! $api_key_wpscomplete ){
		echo '<p style="color:red;">If you do not have an account at WPScomplete.com <a href="https://wpscomplete.com/register/" target="_blank">Register Here</a></p>';
	}
 } else { ?>
<p>You have no API key created.</p>

<?php } ?>
<hr/>
<h4>Create a new API key to connect with WPScomplete.com</h4>

<form action="" method="post">
	<input type="hidden" name="WPS-action" value="create-new-api-key"/>
	<?php wp_nonce_field( 'wpsc_create_key_api', 'wpsc_create_key_api' ); ?>
	<?php submit_button("Create API key"); ?>
</form>

<h4>Disconnect this site.</h4>
<form action="" method="post">
	<input type="hidden" name="WPS-action" value="delete-backup-api-key"/>
	<?php wp_nonce_field( 'wpsc_delete_key_api' , 'wpsc_delete_key_api' ); ?>
	<?php submit_button("Disconnect API"); ?>
</form>

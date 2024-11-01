<?php if( current_user_can( 'manage_options' ) ){ //admin only ?>




<h4>Current logged in user role: <?php echo wpsc_get_user_role() ?></h4>
<h4>User data</h4>
<?php 
	$data = get_userdata( get_current_user_id() );
	if ( is_object( $data) ) {
		$current_user_caps = $data->allcaps;
		echo '<pre>' . print_r( $data->allcaps , true ) . '</pre>';
	} 
}

?>
<h4>User meta</h4>
<?php echo '<pre>' . print_r( get_user_meta( get_current_user_id() ), true ) . '</pre>'; ?>

?>


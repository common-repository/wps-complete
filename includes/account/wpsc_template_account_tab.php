<br/>


<?php 
// get status of the ligon to wpscomplete
$logged_in_wpscomplete = false;
$api_key_wpscomplete = false;

?>

<?php $user = wp_get_current_user(); ?>

<h4>Hello <?php echo $user->user_nicename; ?></h4>

<form action="" method="post">
	<input type="text" name="user_name" placeholder="WPS Complete username" /><br/>
	<input type="text" name="user_pass" placeholder="WPS Complete password" />
	<?php submit_button("Login"); ?>
</form>


<!-- <h4>You are: <?php echo $logged_in_wpscomplete ? '<span style="color:green;" >Logged in' : '<span style="color:red;" >Logged out'; ?></span></h4>
<h4>Your API key: <?php echo $api_key_wpscomplete ? '<span style="color:green;" >Connected' : '<span style="color:red;" >Not Connected'; ?></span></h4>
<p>Please login to your account for additional services</p>
<form action="" method="post">
	<input type="text" name="user_name" placeholder="WPS Complete username" /><br/>
	<input type="text" name="user_pass" placeholder="WPS Complete password" />
	<?php submit_button("Login"); ?>
</form>
 -->

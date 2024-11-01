<?php 

add_filter( 'ajax_query_attachments_args', 'show_current_user_attachments', 10, 1 );

function show_current_user_attachments( $query = array() ) {

	//to do
	
	//check on the cap registered to be restriced from viewing all the media

	// get all role types

	// show a checkbo list

	// select which roles can see all media

	// default admin can see all media

	// else the others 
		// default if option does not exits 
		// or
		// if the option exists but is set at 0

		// restrict if 0 or not exitsing

		// check for multiple roles of each user
			//if they are one of them, the check the seeting for both


    $user_id = get_current_user_id();
    if( $user_id ) {
        $query['author'] = $user_id;
    }
    return $query;
}

?>
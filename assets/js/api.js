	jQuery(document).ready(function($) {
		window.test = function GetPosts() {

		     $.ajax({
		        url: 'https://wpscomplete.com/wp-json/wp/v2/settings',
		        data: {
		        	// authentication: {user:'keymaster', password:'Johnson12341234'},
		            // filter: {
		            // 'posts_per_page': 1
		            // }
		        },
		        consumerKey: 0,
		        consumerSecret: 0,

		        username:'keymaster', 
		        password:'Johnson12341234',

		        verifySsl: true,
		        dataType: 'json',
		        type: 'GET',
		        success: function(data) {
		            console.log(data);
		        },
		        error: function() {
		            console.log('error');
		        }
		    });
		}
	})
var person;

window.fbAsyncInit = function() {
	FB.init({
		appId      : '407908079353620',
		status     : true,
		cookie     : true,
		xfbml      : true
	});

	FB.Event.subscribe('auth.authResponseChange', function(response) {
		// Here we specify what we do with the response anytime this event occurs. 
		if (response.status === 'connected') {
			// The response object is returned with a status field that lets the app know the current
			// login status of the person. In this case, we're handling the situation where they 
			// have logged in to the app.
			FB.api('/me', function(res) {
				person = res;
			});
			$('#footerNav').append("<span style=\"text-align:center;\">•</span>\n<a href=\"#\" class=\"blog-nav-item logout\"><h3 style=\"display:inline-block;\">Logout</h3></a>");
		} else {
			// The user isn't auth'd
			console.log("Not auth'd");
		}
	});
}

$(document).ready(function() {
	$('.logout').click(function() {
		FB.logout(function (response) {console.log("Logged out");})
		window.location = 'index.php';
	});
});

var likes = [];
var page = 0;

$('#getLikes').on('click', function() {
	// Print out each "like"
	console.log("Fetching likes");
	if(likes.length == 0) {
		FB.api('me/likes', function(res) {
			iteratePages(res);
		}); 
	} else {
		storeLikes();
	}
});

function iteratePages(res) {
	page++;
	var _date = "",
		_dYMD = "",
		_dTime = "",
		_dHolder;

	for(var i = 0; i < res.data.length; i++ ) {
		res.data[i].created_time = res.data[i].created_time.split("T")[0];
		likes.push(res.data[i]);
	}

	next = res.paging.next;

	if(next == undefined)
		storeLikes();

	$.get(next, iteratePages, 'json');
}

function storeLikes() {
	console.log(likes.length);
	console.log("Storing likes");

	var stringy = JSON.stringify(likes);
	$.post(
		'store_likes.php',
		{ arr: stringy, fb_id: person.id, count: likes.length },
		function(resp) {
			console.log("Store Likes response:");
			console.log(resp);
		}

	);
}

// Here we run a very simple test of the Graph API after login is successful. 
// This testAPI() function is only called in those cases. 
function testAPI() {
  console.log('Welcome!  Fetching your information.... ');
  FB.api('/me', function(response) {
    console.log('Good to see you, ' + response.name + '.');
    console.log('User ID: ' + response.id);
  });

  FB.api('/me/permissions', function (response) {
    console.log("Permissions");
    console.log(response);
  });
};

(function(d, s, id){
	var js, fjs = d.getElementsByTagName(s)[0];
	if (d.getElementById(id)) {return;}
	js = d.createElement(s); js.id = id;
	js.src = "//connect.facebook.net/en_US/all.js";
	fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
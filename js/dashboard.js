var person, lat = 0, lng = 0;

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
				$('#welcome').html('Hello '+person.first_name+', what would you like to do today?');
				$.post('check_exists.php',
						{ fb_id: person.id },
						function(resp) {
							// POST callback
							console.log("POST for connected status:");
							console.log(resp);
							if(resp != "1") {
								// $('.greeting').html("<h2>You do not exist in the database</h2>" + "<p>" + resp + "</p><p>We will try to add you to the database</p>");
								addUser();
							}

						});
			});
		} else {
			// The user isn't auth'd
			console.log("Not auth'd");
			window.location = 'index.php';
		}
	});
}

var likes = [];

$('#getLikes').on('click', function() {
	// Print out each "like"
	$('#getLikes').css('display', 'none');
	$('#fetching').html("Grabbing your likes, do not close this page<span id=\"s1\" class=\"anim pulse\">.</span><span id=\"s2\" class=\"anim pulse\">.</span><span id=\"s3\" class=\"anim pulse\">.</span>");
	if(likes.length == 0) {
		FB.api('me/likes', function(res) {
			iteratePages(res);
		}); 
	} else {
		storeLikes();
	}
});

function iteratePages(res) {
	var _date = "",
		_dYMD = "",
		_dTime = "",
		_dHolder;

	for(var i = 0; i < res.data.length; i++ ) {
		res.data[i].created_time = res.data[i].created_time.split("T")[0];
		likes.push(res.data[i]);
	}

	console.log(res.paging.next);

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
			if(resp == "1") {
				$('#fetching').css('display', 'none');
				$('#complete').html("All done! Check out the map");
			}
		}

	);
}

function addUser() {
	FB.api('/me', function(person) {
		console.log("Calling FB.api/me");
		var _city = null, _state = null, _country = null;
		FB.api({
				method: 'fql.query',
				query: 'SELECT current_location FROM user WHERE uid='+person.id,
				return_ssl_resources: 1
			}, function (loc) {
				_city = loc[0].current_location.city;
				_state = loc[0].current_location.state;
				_country = loc[0].current_location.country;
				console.log("In FB.api callback, ajaxing info");
				$.post('register.php',
					{ fb_id: person.id, first_name: person.first_name, last_name: person.last_name, email: person.email, city: _city, state: _state, country: _country, latitude: lat, longitude: lng },
					function(resp) {
						if(resp != "1") {
							$('#welcome').text('Looks like you are not in the database! Rerouting to home page');
							FB.logout(function(response) {
								// Person is now logged out
								window.location = "index.php";
							});
						}
					});
			}
		);
	});
}

function getUserLoc() {
	if (navigator.geolocation)
		navigator.geolocation.getCurrentPosition(getPos, denyWarn);
	else
		$('.greeting').append("<h2>It looks like you're using an outdated browser, we recommend downloading the latest <a href=\"https://chrome.google.com\">Chrome</a> or <a href=\"http://www.mozilla.org/en-US/firefox/new/\"Firefox</a> browser</h2>");
}

function getPos(position) {
	lat = position.coords.latitude;
	lng = position.coords.longitude;
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
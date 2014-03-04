var lat = 0, lng = 0;

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
			console.log("User is connected");
			// The response object is returned with a status field that lets the app know the current
			// login status of the person. In this case, we're handling the situation where they 
			// have logged in to the app.
			// window.location = "main.php";
		} else {
			// The user isn't auth'd
			console.log(response.status);
		}
	});
}

$(document).ready(function() {
	getUserLoc();
	$('#fbRegister').on('click', 
		function () {
			if(lat != 0 && lng != 0)
				login();
			else  {
				$('.greeting').append("<h2>This website requires geolocation to work, please enable location data for your browser.</h2>");
				getUserLoc();
			}
	});
});


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

function denyWarn() {
	$('.greeting').append("<h2>Sorry, you must allow location info for this site to work!</h2>");
}

function login() {
	FB.login( function (response) {
		if (response.status=="connected") {
			// using jQuery to perform AJAX POST.
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
							// POST callback
							console.log("POST callback arrived:");
							console.log(resp);
							// window.location = "main.php";
						});
					}
				);
			});
		} else {
			console.log(response.status);
		}
	}, {scope: 'email,user_likes'});
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
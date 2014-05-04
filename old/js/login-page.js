var firstName = "", lastName =  "", _email = "", _id = 0, lat = 0.00, lng = 0.00;

window.fbAsyncInit = function() {
	FB.init({
		appId      : '407908079353620',
		status     : true,
		xfbml      : true
	});

	FB.Event.subscribe('auth.authResponseChange', function(response) {
		// Here we specify what we do with the response anytime this event occurs. 
		if (response.status === 'connected') {
			console.log("Connected");
			// The response object is returned with a status field that lets the app know the current
			// login status of the person. In this case, we're handling the situation where they 
			// have logged in to the app.
			FB.api('/me', function(res) {
				_id = res.id;
				$('#logout').html('Welcome ' + res.first_name);
				console.log(res.first_name);
			});
			$('#login').css('display', 'none');
			$('#register').css('display', 'none');
		} else {
			// The user isn't auth'd
			console.log("Not auth'd");
			$('#login').css('display', 'inline-block');
			$('#register').css('display', 'inline-block');
			$('#fbPic').css('display', 'none');
		}
	});
}

$('#fbRegister').on('click', 
	function () { 
	FB.login( 
		function (response) {
			if (response.status=="connected") {
				// using jQuery to perform AJAX POST.
				console.log("Registered");
				FB.api('/me', function(person) {
					var _city = null, _state = null, _country = null;
					getUserLoc();
					FB.api({
							method: 'fql.query',
							query: 'SELECT current_location FROM user WHERE uid='+person.id,
							return_ssl_resources: 1
						}, function (loc) {
							_city = loc[0].current_location.city;
							_state = loc[0].current_location.state;
							_country = loc[0].current_location.country;
							console.log(_city + " " + _state + " " + _country);
							$.post('register.php',
									{ fb_id: person.id, first_name: person.first_name, last_name: person.last_name, email: person.email, city: _city, state: _state, country: _country, latitude: lat, longitude: lng },
									function(resp) {
								// POST callback
								console.log("POST callback arrived:");
								console.log(resp);
							});
						}
					);
				});
				$('#getLikes').css("visibility", "visible");
			} else {
				console.log(response.status);
				$('#getLikes').css("visibility", "hidden");
			}
		},
		{scope: 'email,user_likes'}
	)
});

$('#logout').on('click', function () { 
	FB.logout(function (response) {console.log("Logged out");})
	$('#login').css('display', 'inline-block');
	$('#register').css('display', 'inline-block');
	$('#logout').css('display', 'none');
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
		{ arr: stringy, fb_id: _id, count: likes.length },
		function(resp) {
			console.log("Store Likes response:");
			console.log(resp);
		}

	);
}

function getUserLoc() {
	if (navigator.geolocation)
		navigator.geolocation.getCurrentPosition(showPosition);
	else
		console.log("Geolocation is not supported by this browser.");
}

function showPosition(position) {
	console.log("Lat, lng " + position.coords.latitude + ", " + position.coords.longitude);
	lat = position.coords.latitude;
	lng = position.coords.longitude;
	// _center = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);
	// _heatmapData.push(_center);
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
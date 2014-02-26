<?php session_start();

require_once 'dbconfig.php';
require_once 'settings.php';
require_once 'src/facebook.php';

try {
	$conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
} catch (PDOException $pe){
	die("Could not connect to the database $dbname: " . $pe->getMessage());
}

$facebook = new Facebook(array(
  'appId'  => '407908079353620',
  'secret' => $app_secret,
  'fileUpload' => false, // optional
  'allowSignedRequest' => false, // optional, but should be set to false for non-canvas apps
));

// See if there is a user from a cookie
// $user = $facebook->getUser();

// if ($user) {
//   try {
//     // Proceed knowing you have a logged in user who's authenticated.
//     $user_profile = $facebook->api('/me');
//     $logoutUrl = $facebook->getLogoutUrl();
//   } catch (FacebookApiException $e) {
//     $user = null;
//   }
// } else {
//     $loginUrl = $facebook->getLoginUrl();
// }

getHeader();

?>

<div class="hero">
	<img src="http://placehold.it/2800x2600/467148/000000&text=STATISTICALLY.ME" class="hero-img">
</div>

<div class="row main-row">
	<h2 class="text-center">Use us to discover you</h2>
	<div class="col-md-offset-1 col-md-10">
		<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis vestibulum aliquet massa, sed elementum odio adipiscing vel. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Nulla nec accumsan urna, in volutpat risus. Nam vestibulum, nunc ut malesuada aliquam, tellus velit lobortis lorem, id tempus lectus libero ut risus. Vivamus vitae ligula tortor. Vivamus non lacus est. Donec sit amet magna ut metus aliquam vestibulum vitae ut diam. Sed vitae pharetra est. In et mi nec arcu lacinia commodo. Nunc viverra eros sed risus consequat lacinia. Vivamus sed enim et neque molestie vehicula a sollicitudin neque.</p>
		<img src="http://placehold.it/400x150" class="img-responsive" style="margin:auto; padding-bottom:20px;">
	</div>
</div>

<div class="row row-dark main-row">
	<h2 class="text-center">Enjoy. Participate. Learn.</h2>
	<div class="col-md-offset-1 col-md-10" style="padding-bottom:20px;">
		<img src="http://placehold.it/500x400&text=Enjoy" class="img-responsive" style="display:inline-block;">
		<img src="http://placehold.it/500x400&text=Participate" class="img-responsive" style="display:inline-block;">
		<img src="http://placehold.it/500x400&text=Learn" class="img-responsive" style="display:inline-block;">
	</div>
</div>

<div class="row main-row">
	<h2 class="text-center">How and Why</h2>
	<div class="col-md-offset-1 col-md-10" style="padding-bottom:20px;">
		<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis vestibulum aliquet massa, sed elementum odio adipiscing vel. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Nulla nec accumsan urna, in volutpat risus. Nam vestibulum, nunc ut malesuada aliquam, tellus velit lobortis lorem, id tempus lectus libero ut risus. Vivamus vitae ligula tortor. Vivamus non lacus est. Donec sit amet magna ut metus aliquam vestibulum vitae ut diam. Sed vitae pharetra est. In et mi nec arcu lacinia commodo. Nunc viverra eros sed risus consequat lacinia. Vivamus sed enim et neque molestie vehicula a sollicitudin neque.</p>
	</div>
</div>

<!-- <div class="row">
	<h1>Register</h1>
	<form action="register.php" role="form" method="post">
		<div class="form-group">
			<div class="row">
				<div class="col-md-4">
					<label for="f_name">First Name:</label>
					<input type="text" class="form-control" name="first_name" placeholder="Please enter your first name">
				</div>
				<div class="col-md-4">
					<label for="l_name">Last Name:</label>
					<input type="text" class="form-control" name="last_name" placeholder="Please enter your last name">
				</div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<label for="password">Password:</label>
					<input type="password" class="form-control" name="password" placeholder="Please enter a password">
				</div>
				<div class="col-md-4">
					<label for="email">Email:</label>
					<input type="text" class="form-control" name="email" placeholder="Please enter an email">
				</div>
			</div>
		</div>
		<button type="submit" class="btn btn-default">Submit</button>
	</form>
</div>

<div class="row">
	<h1>Login</h1>
	<form action="main.php" role="form" method="post" class="form-inline">
		<div class="form-group">
			<input type="text" class="form-control" name="username" placeholder="Username">
		</div>
		<div class="form-group">
			<input type="password" class="form-control" name="password" placeholder="Password">
		</div>
		<div class="form-group">
			<button type="submit" class="btn btn-default">Login</button>
		</div>
	</form>
</div> -->

<!-- <div class="row">
	<div id="loginArea">
		<h1>Or Use Facebook</h1>
		<button id="fbLogin" class="btn">Facebook Login</button>
	</div>
	<div id="likesArea">
		<h1>Get Likes</h1>
		<button id="getLikes" class="btn">Get likes</button>
	</div>
</div>  -->


<?php

getFooterJS();

?>

<script>
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
			//$('#getLikes').css("display", "block");
			FB.api('/me', function(res) {
				_id = res.id;
				// $('#fbPic').attr('src', 'https://graph.facebook.com/'+ res.id+'/picture?type=small');
				// $('#fbPic').css('display', 'block');
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

$('#register').on('click', 
	function () { FB.login( 
		function (response) {
			if (response.status=="connected") {
				// using jQuery to perform AJAX POST.
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
</script>

<?php

getFooter();

?>

</body>
</html>
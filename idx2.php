<?php session_start();

require_once 'dbconfig.php';
require_once 'settings.php';

try {
	$conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
} catch (PDOException $pe){
	die("Could not connect to the database $dbname: " . $pe->getMessage());
}

	echo("<!DOCTYPE html>\n");
	echo("<html lang=\"en\" style=\"height:100%;\">\n");
	echo("<head>\n");
	echo("<meta charset=\"utf-8\">\n");
    echo("<meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">\n");
    echo("<meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">\n");
	echo("<title>Statistically.Me</title>\n");
	echo("<link rel=\"stylesheet\" type=\"text/css\" href=\"css/bootstrap.css\">\n");
	echo("<link rel=\"stylesheet\" type=\"text/css\" href=\"css/custom.css\">\n");
	echo("<link href='http://fonts.googleapis.com/css?family=Istok+Web:400,400italic' rel='stylesheet' type='text/css'>\n");
	echo("<script src=\"http://code.jquery.com/jquery-latest.min.js\"></script>\n");
	echo("</head>\n");
	echo("<body style=\"height:100%;\">\n");
	echo("\t<div class=\"wrap\">");
	echo("\t\t<div id=\"fb-root\"></div>\n");
	echo("\t\t<div class=\"blog-masthead\">\n");
	echo("\t\t\t<div class=\"container\">\n");
	echo("\t\t\t\t<nav class=\"blog-nav text-center\">\n");
	echo("\t\t\t\t<a class=\"blog-nav-item active\" href=\"#\">STATISTICALLY.ME</a>\n");
	// echo("\t\t\t\t<a class=\"blog-nav-item active\" href=\"#\">Home</a>\n");
	// echo("\t\t\t\t<a class=\"blog-nav-item\" href=\"#\">About</a>\n");
	// echo("\t\t\t\t<a class=\"blog-nav-item\" href=\"#\">Press</a>\n");
	// echo("\t\t\t\t<a class=\"blog-nav-item\" href=\"#\">New hires</a>\n");
	// echo("\t\t\t\t<a class=\"blog-nav-item\" href=\"#\">About</a>\n");
	// echo("\t\t\t\t\t<span class=\"blog-nav-item\">STATISTICALLY.ME</span>\n");
	// echo("\t\t\t\t\t<a id=\"login\" class=\"blog-nav-item pull-right\" href=\"#\">Log In</a>\n");
	// echo("\t\t\t\t\t<a id=\"register\" class=\"blog-nav-item pull-right\" href=\"#\">Register</a>\n");
	// echo("\t\t\t\t\t<a id=\"logout\" href=\"#\" class=\"blog-nav-item pull-right\"></a>\n");
	echo("\t\t\t\t</nav>\n");
	echo("\t\t\t</div>\n");
	echo("\t\t</div>\n");

?>

<div class="hero">
	<h1 class="greeting">Statistically.Me</h1>
	<!-- <img src="http://placehold.it/2800x2600/467148/000000&text=." class="hero-img"> -->
</div>


<?php
	echo("\t\t</div> <!-- end wrap -->\n");
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
	echo("\t<!-- Social footer -->\n");
	echo("\t<footer style=\"position:relative; margin-top:-90px; height:90px; clear:both;\">");
	echo("\t\t<div class=\"row row-dark\">");
	echo("\t\t\t<div class=\"col-md-offset-1 col-md-10 text-center\" style=\"min-height: 90px;\">");
	//echo("\t\t\t<h5 class=\"text-center\">Stay in touch</h5>");
	//echo("\t\t\t<div class=\"social-container\">");
	echo("\t\t\t<div class=\"pull-left\" style=\"padding-top: 25px; padding-bottom:25px;\">");
	echo("\t\t\t\t<a href=\"https://www.facebook.com/pages/StatisticallyMe/1470796433142543\" ><img src=\"img/fb_small_shadow.png\" class=\"img-responsive social-icon\"></a>");
	echo("\t\t\t\t<a href=\"https://twitter.com/ThatCodeDude\"><img src=\"img/tw_small_shadow.png\" class=\"img-responsive social-icon\"></a>");
	echo("\t\t\t</div>");
	//echo("\t\t\t\t<img src=\"img/li_square.svg\" class=\"img-responsive social-icon\">");
	//echo("\t\t\t</div>");
	echo("\t\t\t<div class=\"text-center\" style=\"padding-top: 10px; margin:auto; width: 50%; display: inline-block;\">");
	echo("\t\t\t\t<a href=\"#\"><h3 style=\"display:inline-block;\">Home</h3></a>•");
	echo("\t\t\t\t<a href=\"#\"><h3 style=\"display:inline-block;\">About</h3></a>");
	echo("\t\t\t</div>");
	echo("\t\t</div>");
	echo("\t</footer>");

	echo("\t<script>");
  	echo("\t\t(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){");
  	echo("\t\t(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),");
  	echo("\t\tm=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)");
  	echo("\t\t})(window,document,'script','//www.google-analytics.com/analytics.js','ga');");
  	echo("\t\tga('create', 'UA-42403118-7', 'statistically.me');");
  	echo("\t\tga('send', 'pageview');");
	echo("\t</script>");

	echo("\t</body>");
	echo("</html>");

?>
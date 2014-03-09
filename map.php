<?php session_start();

ini_set('max_execution_time', 300); //300 seconds = 5 minutes

require_once 'dbconfig.php';
require_once 'settings.php';
require_once 'get_interest_categories.php';
// require_once 'php-console/src/PhpConsole/__autoload.php';

// Call debug from global PC class-helper (most short & easy way)
// PhpConsole\Helper::register(); // required to register PC class in global namespace, must be called only once

try {
	$conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
} catch (PDOException $pe){
	die("Could not connect to the database $dbname: " . $pe->getMessage());
}

getHeader();
getFixedIndexPage();

?>

	<div class="row text-center">
		<h2>Where do you fit in?</h2>
	</div>

	<div class="row">
		<div id="map" class="col-md-offset-1 col-md-10"></div>
		<div id="not-supported" style="display: none;">Oops! It looks like your browser doesn't support geolocation, we recommend you upgrade to the latest version of <a href="http://downloads.yahoo.com/firefox">Firefox</a> or <a href="https://chrome.google.com">Chrome</a>.</div>
	</div>

	<div class="row">
		<div class="col-md-offset-1 col-md-10">
			<h2 class="text-center">This is a heatmap</h2>
			<p>See the dot on the map? That's you. Well, kind of, it's a close approximation to the location you're visiting this site from. Use the options below to see where the highest concentrations of other people are who share your interests!</p>
		</div>
	</div>

	<div id="query-row" class="row">
		<div id="query-start" class="col-md-offset-1 col-md-10">
			<div class="col-md-5 col-md-offset-1">
				<h2>Facebook Interests</h2>
				<p>Start here to use your Facebook interests as a way to discover more about yourself and others who share your same "Likes"</p>
				<button class="btn text-center" onclick="selectFacebook()">Click here</button>
			</div>
			<div class="col-md-5 col-md-offset-1">
				<h2>Quiz Results</h2>
				<p>Start here to use your quiz results to see who else has similar results!</p>
				<p>Not implemented yet.</p>
				<button class="btn text-center">Click here</button>
			</div>
		</div>
		<div id="facebook-start" class="text-center" style="display: none;">
			<h2>Select an interest category</h2>
			<?php getFacebookCategories($conn); ?>
		</div>
	</div>
</div>

<?php

getFooterJS();

?>

<script>
var geocoder = new google.maps.Geocoder(), map, _center, heatmap, _heatmapData = [], query_data = [], person;

function getUserLoc() {
	if (navigator.geolocation)
		navigator.geolocation.getCurrentPosition(showPosition);
	else {
		// console.log("Geolocation is not supported by this browser.");
		$('#not-supported').css('display', 'block');
		$('#map').css('display', 'none');
	}
}

function showPosition(position) {
	console.log("Lat, lng " + position.coords.latitude + ", " + position.coords.longitude);
	_center = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);
	_heatmapData.push(_center);
	initialize();
}

function initialize() {
	var mapOptions = {
		center: _center,
		zoom: 9,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	};

	map = new google.maps.Map(document.getElementById("map"), mapOptions);

	var pointArray = new google.maps.MVCArray(_heatmapData);

	heatmap = new google.maps.visualization.HeatmapLayer({
		data: pointArray
		});

	heatmap.setMap(map);

}

$(document).ready(function() {
	getUserLoc();
});

$('.category-button').click(function() {
	var context = $(this);
	context.toggleClass('selected');
	// var stringy = JSON.stringify(likes);
	var context_name = context.text();
	console.log("Fetching data for " + context_name);
	$.post(
		'map_queries.php',
		{ fb_id: person.id, category: context_name },
		function(resp) {
			console.log("Map query response:");
			console.log(resp);
			var _tt = $.parseJSON(resp);
			var _points = [];
			for(i = 0; i < _tt.length; i++) {
				_points.push(new google.maps.LatLng(_tt[i][0], _tt[i][1]));
				console.log(_tt[i]);
			}
			updateHeatmap(_points);
		});
});

function updateHeatmap(data) {
	var pointArray = new google.maps.MVCArray(data);

	// heatmap = new google.maps.visualization.HeatmapLayer({
	// 	data: pointArray
	// 	});

	heatmap.setData(pointArray);
}

function selectFacebook() {
	$('#query-start').css('display', 'none');
	$('#facebook-start').css('display', 'block');
}

function interestClick(interest) {
	var context = $('#'+interest);
	context.toggleClass('selected');
}

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
				// $('#welcome').text('Hello '+person.first_name+', what would you like to do today?');
			});
		} else {
			// The user isn't auth'd
			console.log("Not auth'd");
			window.location = 'index.php';
		}
	});
}

</script>

<?php

getFooter();

?>
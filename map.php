<?php session_start();

require_once 'dbconfig.php';
require_once 'settings.php';
require_once 'fb-sdk/facebook.php';
require_once 'php-console/src/PhpConsole/__autoload.php';

// Call debug from global PC class-helper (most short & easy way)
PhpConsole\Helper::register(); // required to register PC class in global namespace, must be called only once

try {
	$conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
} catch (PDOException $pe){
	die("Could not connect to the database $dbname: " . $pe->getMessage());
}

getMapHeader();

getFixedIndexPage();

?>

<div class="row text-center">
	<h2>Where do you fit in?</h2>
</div>

<div class="row">
	<div id="map" class="col-md-offset-1 col-md-10"></div>
</div>

<?php

getFooterJS();

?>

<script>
var geocoder = new google.maps.Geocoder(), map, _center, heatmap, _heatmapData = [];

function getUserLoc() {
	if (navigator.geolocation)
		navigator.geolocation.getCurrentPosition(showPosition);
	else
		console.log("Geolocation is not supported by this browser.");
}

function showPosition(position) {
	console.log("Lat, lng " + position.coords.latitude + ", " + position.coords.longitude);
	var thestring = position.coords.latitude + ", " + position.coords.longitude;
	var bits = thestring.split(/,\s*/);
	_center = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);
	_heatmapData.push(_center);
	initialize();
}

function initialize() {
	var mapOptions = {
		center: _center,
		zoom: 11,
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
</script>

<?php

getDashFooter();

getFooter();

?>
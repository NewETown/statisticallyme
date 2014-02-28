<?php session_start();

require_once 'dbconfig.php';
require_once 'settings.php';
require_once 'fb-sdk/facebook.php';
require_once '../php-console/src/PhpConsole/__autoload.php';

// Call debug from global PC class-helper (most short & easy way)
PhpConsole\Helper::register(); // required to register PC class in global namespace, must be called only once

try {
	$conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
} catch (PDOException $pe){
	die("Could not connect to the database $dbname: " . $pe->getMessage());
}


$config = array(
			'appId' => '407908079353620',
			'secret' => $app_secret,
			'allowSignedRequest' => false // optional but should be set to false for non-canvas apps
			);

$facebook = new Facebook($config);
$user_id = $facebook->getUser();
$user_profile = null;

getHeader();

if($user_id) {

	// We have a user ID, so probably a logged in user.
	// If not, we'll get an exception, which we handle below.
	try {

		$user_profile = $facebook->api('/me','GET');
		// echo "Name: " . $user_profile['name'];

	} catch(FacebookApiException $e) {
		PC::db($e->getType());
		PC::db($e->getMessage());

		PC::db('Unable to get user info');
		header('location: http://localhost/statisticallyme/index.php');
	}

} else {

	PC::db('No user logged in');
	header('location: http://localhost/statisticallyme/index.php');
}

getDashboardPage();

?>

	<div class="row">
		<h3 id="welcome"></h3>
	</div>

	<div class="row">
		<!-- Need to make a row with a line that stirkes the left and right sides of a heading  -->
		<h2 class="text-center">Explore</h2>
		<div class="row">
			<div class="col-md-4 text-center" style="height:300px;">
				<h3 >my likes</h3>
				<a href="map.php"><h5>Go to Map</h5></a>
			</div>
			<div class="col-md-4" style="height:300px;">
				<h3 class="text-center">Thing 2</h3>
			</div>
			<div class="col-md-4" style="height:300px;">
				<h3 class="text-center">Thing 3</h3>
			</div>
		</div>
	</div>

	<div class="row">
		<!-- Need to make a row with a line that stirkes the left and right sides of a heading  -->
		<h2 class="text-center">Participate</h2>
		<div class="row">
			<div class="col-md-4" style="height:300px;">
				<h3 class="text-center">Take a quiz</h3>
			</div>
			<div class="col-md-4" style="height:300px;">
				<h3 class="text-center">Thing 2</h3>
			</div>
			<div class="col-md-4 text-center" style="height:300px;">
				<h3 class="text-center">Update my info</h3>
				<button id="getLikes" class="btn">Update Likes</button>
			</div>
		</div>
	</div>

	<div class="row">
		<!-- Need to make a row with a line that stirkes the left and right sides of a heading  -->
		<h2 class="text-center">Create</h2>
		<div class="row">
			<div class="col-md-4" style="height:300px;">
				<h3 class="text-center">Thing 1</h3>
			</div>
			<div class="col-md-4" style="height:300px;">
				<h3 class="text-center">Thing 2</h3>
			</div>
			<div class="col-md-4" style="height:300px;">
				<h3 class="text-center">Thing 3</h3>
			</div>
		</div>
	</div>

<?php

getFooterJS();

?>

<script>
$(document).ready(function() {
	$('#welcome').text('Hello <?php echo $user_profile["first_name"]; ?>, what would you like to do today?');
});
</script>

<?php

getDashFooter();

getFooter();

?>
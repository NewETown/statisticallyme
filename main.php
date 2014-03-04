<?php session_start();

ini_set('max_execution_time', 300); //300 seconds = 5 minutes

require_once 'dbconfig.php';
require_once 'settings.php';
require_once 'check_refresh.php';
require_once 'fb-sdk/facebook.php';
// require_once 'php-console/src/PhpConsole/__autoload.php';

// Call debug from global PC class-helper (most short & easy way)
// PhpConsole\Helper::register(); // required to register PC class in global namespace, must be called only once

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
		// PC::db($e->getType());
		// PC::db($e->getMessage());

		// PC::db('Unable to get user info');
		header('location: index.php');
	}

} else {

	// // PC::db('No user logged in');
	header('location: index.php');
}

getFixedIndexPage();

?>

	<div class="row">
		<h3 id="welcome" class="text-center" style="padding-top:40px;"></h3>
	</div>

	<div class="row" style="padding-top:40px;">
		<!-- Need to make a row with a line that stirkes the left and right sides of a heading  -->
		<div class="col-md-4" style="height:300px;">
			<h2 class="text-center">Explore</h2>
			<p>In today's data-filled world everyone is a statistic. At Statistically.Me we want to empower you to learn from your own data. As our system grows we will be able to tell you more about yourself!</p>
			<p>First thing first, check out our heatmap to see where other people are who share your interests.</p>
			<button class="btn"><a href="map.php">Go to Map</a></button>
		</div>
		<div class="col-md-4" style="height:300px;">
			<h2 class="text-center">Participate</h2>
			<h3 class="text-center">Take a quiz <h6>(coming soon)</h6></h3>
			<h3 class="text-center">Update my info</h3>
			<?php 
				try {
					checkLikeRefreshDate($conn, $user_id);
				} catch(PDOException $pe) {
					// PC::db($pe);
					echo($pe);
				}
			?>
		</div>
		<div class="col-md-4" style="height:300px;">
			<h2 class="text-center">Share and Create</h2>
			<p>Soon enough you will be able to create your own quizzes and broadcast the interesting things you discover about yourself. Our social integration provides you with an easy platform to connect with others and share the things you discover.</p>
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

getIndexFooter();

getFooter();

?>
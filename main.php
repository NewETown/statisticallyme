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
		// If the user is logged out, you can have a 
		// user ID even though the access token is invalid.
		// In this case, we'll get an exception, so we'll
		// just ask the user to login again here.
		// $login_url = $facebook->getLoginUrl(); 
		// echo 'Please <a href="' . $login_url . '">login.</a>';
		error_log($e->getType());
		error_log($e->getMessage());

		PC::db('Unable to get user info');
		header('location: http://localhost/statisticallyme/index.php');
	}

} else {

	// No user, print a link for the user to login
	// $login_url = $facebook->getLoginUrl();
	// echo 'Please <a href="' . $login_url . '">login.</a>';

	PC::db('No user logged in');
	header('location: http://localhost/statisticallyme/index.php');
}

getFooterJS();

?>

<script>
$(document).ready(function() {
	$('#navHeader').text('Statistically you, <?php echo $user_profile["first_name"]; ?>');
});
</script>

<?php

getFooter();

?>
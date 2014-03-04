<?php session_start();

require_once 'dbconfig.php';
require_once 'settings.php';
require_once 'fb-sdk/facebook.php';
// require_once 'php-console/src/PhpConsole/__autoload.php';

// PhpConsole\Helper::register(); 

try {
	$conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
	// PC::db("Connected");
} catch (PDOException $pe){
	// PC::db($pe->getMessage());
	die("Could not connect to the database $dbname: " . $pe->getMessage());
}

$config = array(
			'appId' => '407908079353620',
			'secret' => $app_secret,
			'allowSignedRequest' => false // optional but should be set to false for non-canvas apps
			);

$facebook = new Facebook($config);
$user_id = $facebook->getUser();

getHeader();

getFixedIndexPage();

// phpinfo();

if($user_id) {

	// // We have a user ID, so probably a logged in user.
	// // If not, we'll get an exception, which we handle below.
	// try {
	// 	//$user_profile = $facebook->api('/me','GET');
	// 	//PC::db($user_profile['name']);
	// 	header('location: main.php');

	// } catch(FacebookApiException $e) {
	// 	// If the user is logged out, you can have a 
	// 	// user ID even though the access token is invalid.
	// 	// In this case, we'll get an exception, so we'll
	// 	// just ask the user to login again here.
	// 	echoLoginOptions();
	// 	//PC::db($e->getType());
	// 	//PC::db($e->getMessage());
	// }

} else { 

	echoLoginOptions();

} ?>

</div> <!-- end container or wrap-->

<?php

getIndexJS();

getIndexFooter();

getFooter();

?>
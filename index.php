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

if($user_id) {
	header('Location: main.php');
}

getHeader();

getFixedIndexPage();

// phpinfo();

echoLoginOptions();

?>

</div> <!-- end container or wrap-->

<?php

getIndexJS();

getIndexFooter();

?>
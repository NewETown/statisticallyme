<?php

require_once 'dbconfig.php';
require_once 'settings.php';

try {
	$conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $pe){
	die("Could not connect to the database $dbname: " . $pe->getMessage());
}

$fb_id = null;

if(isset($_REQUEST['fb_id'])) {
	$fb_id = $_REQUEST['fb_id'];
	$fb_id = trim($fb_id);
	$fb_id = $fb_id + 0;
}

try {

	$sql = 'SELECT FROM users WHERE fb_id=:fb';

	$task = array(
				':fb' => $fb_id
				);

	$q = $conn->prepare($sql);

	$q->execute($task);

	if($q->rowCount() > 0)
		header('location: main.php');
	// echo("FB_ID: " . $fb_id . "\n");
	// echo("Lat: " . $lat . "\n");
	// echo("Lng: " . $lng . "\n");

} catch (PDOException $pe) {
	die("Error registering user: " . $pe->getMessage());
}

$conn = null;

?>
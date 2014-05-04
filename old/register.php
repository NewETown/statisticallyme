<?php

require_once 'dbconfig.php';
require_once 'settings.php';

try {
	$conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $pe){
	die("Could not connect to the database $dbname: " . $pe->getMessage());
}

$f_name = "";
$l_name = "";
$password = null;
$_salt = null;
$email = "";
$fb_id = null;
$date = date_format(new DateTime('now'), ('Y-m-d'));
$city = null;
$state = null;
$country = null;
$lat = 0.00;
$lng = 0.00;

if(isset($_REQUEST["first_name"])) {
	$f_name = $_REQUEST['first_name'];
	$f_name = trim($f_name);
}

if(isset($_REQUEST['last_name'])) {
	$l_name = $_REQUEST['last_name'];
	$l_name = trim($l_name);
}

if(isset($_REQUEST['email'])) {
	$email = $_REQUEST['email'];
	$email = trim($email);
}

if(isset($_REQUEST['fb_id'])) {
	$fb_id = $_REQUEST['fb_id'];
	$fb_id = trim($fb_id);
}

if(isset($_REQUEST['password'])) {
	$password = $_REQUEST['password'];
	$password = md5(trim($password));
}

if(isset($_REQUEST['city'])) {
	$city = $_REQUEST['city'];
	$city = trim($city);
}

if(isset($_REQUEST['state'])) {
	$state = $_REQUEST['state'];
	$state = trim($state);
}

if(isset($_REQUEST['country'])) {
	$country = $_REQUEST['country'];
	$country = trim($country);
}

if(isset($_REQUEST['latitude'])) {
	$lat = $_REQUEST['latitude'];
}

if(isset($_REQUEST['longitude'])) {
	$lng = $_REQUEST['longitude'];
}

try {

	$sql = 'INSERT INTO users(fb_id, f_name, l_name, email, reg_date, city, state, country, lat, lng)
					VALUES(:fb_id, :f_name, :l_name, :email, :reg_date, :city, :state, :country, :lat, :lng)';

	if($password != null) {
		// Then the user isn't registering through Facebook
		$_h = create_hash($password);
		$_t = explode(":", $_h);
		$_salt = $_t[2];
		$password = $_t[3];
	}

	$task = array(
				':fb_id' => $fb_id,
				':f_name' => $f_name,
				':l_name' => $l_name,
				':email' => $email,
				':reg_date' => $date,
				':city' => $city,
				':state' => $state,
				':country' => $country,
				':lat' => $lat,
				':lng' => $lng
				);

	$q = $conn->prepare($sql);

	$q->execute($task);

	echo("Welcome " . $f_name . " " . $l_name . "!\n");
	echo("FB_ID: " . $fb_id . "\n");
	echo("Lat: " . $lat . "\n");
	echo("Lng: " . $lng . "\n");

} catch (PDOException $pe) {
	// die("Error registering user: " . $pe->getCode());
	if($pe->getCode() == 23000) {
		echo($pe);
		echo("You already exist in the database!");
	} else {
		echo($pe);
	}
}

$conn = null;

?>
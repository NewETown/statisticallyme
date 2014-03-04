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

	echo("1");

} catch (PDOException $pe) {
	die("Error registering user: " . $pe->getMessage());
}

$conn = null;

?>
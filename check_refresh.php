<?php
/*
 * Check refresh date for:
 * - Likes
 *
 */

// require_once 'dbconfig.php';
// require_once 'settings.php';
// require_once 'fb-sdk/facebook.php';
// require_once '../php-console/src/PhpConsole/__autoload.php';

// Call debug from global PC class-helper (most short & easy way)
// PhpConsole\Helper::register(); // required to register PC class in global namespace, must be called only once

// try {
// 	$conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
// 	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// } catch (PDOException $pe){
// 	die("Could not connect to the database $dbname: " . $pe->getMessage());
// }

// $facebook = new Facebook($config);
// $user_id = $facebook->getUser();

function checkLikeRefreshDate($conn, $user_id) {

	PC::db("Checking like refresh date for ". $user_id);

	try {
		$sql = 'SELECT * FROM likes_refresh_data WHERE fb_id=:_id';

		$task = array(
					':_id' => $user_id
					);

		$q = $conn->prepare($sql);

		$q->execute($task);
		$q->setFetchMode(PDO::FETCH_ASSOC);
		$r = $q->fetch();

		$today = date("Y-m-d");
		$refresh = $r['refresh_date'];

		// Echo out the HTML here when the time comes, for now just fake it
		$today_dt = new DateTime("now", new DateTimeZone('America/Los_Angeles'));
		$refresh_dt = new DateTime($refresh, new DateTimeZone('America/Los_Angeles'));

		PC::db($today_dt);
		PC::db($refresh_dt);

		if($today_dt > $refresh_dt)
			PC::db("Refresh ok");
		else
			PC::db("Refresh not ready yet");

	} catch (PDOException $pe) {
		//PC::db($pe);
		echo($pe."\n");
	}

	$conn = null;
}

?>
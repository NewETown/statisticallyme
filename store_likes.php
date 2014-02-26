<?php

require_once 'dbconfig.php';
require_once 'settings.php';
require_once 'src/facebook.php';

try {
	$conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $pe){
	die("Could not connect to the database $dbname: " . $pe->getMessage());
}

$_arr = null;
$fb_id = 0;
$count = 0;
$date = strtotime("+7 day");
$str_date =  date_format($date, ('Y-m-d'));

if(isset($_REQUEST['arr'])) {
	$_arr = $_REQUEST['arr'];
	$_arr = json_decode($_arr);
}

if(isset($_REQUEST['fb_id'])) {
	$fb_id = $_REQUEST['fb_id'];
}

if(isset($_REQUEST['count'])) {
	$count = $_REQUEST['count'];
}

// {"category":"Musician/band","name":"Jay Z","created_time":"2014-02-19T17:14:34+0000","id":"48382669205"}

$_id; $_category; $_name;
$_arrSize = count($_arr);

for($i = 0; $i < $_arrSize; $i++) {

	$_id = $_arr[$i]->id;
	$_id = $_id + 0;
	$_name = $_arr[$i]->name;
	$_category = $_arr[$i]->category;
	$_date = $_arr[$i]->created_time;
	echo($_date . "\n"); // . $_name . " " . $_category . "\n");

	try {
		$sql = 'INSERT INTO interests(id, name, category)
						VALUES(:_id, :_name, :_category)';

		$task = array(
					':_id' => $_id, 
					':_name' =>  $_name,
					':_category' => $_category
					);

		$q = $conn->prepare($sql);

		$q->execute($task);

		echo("Likes added");

	} catch (PDOException $pe) {
		echo($pe);
	}

	try {
		$sql = 'INSERT INTO interest_map(fb_id, interest_id, like_date)
						VALUES(:fb_id, :interest_id, :like_date)';

		$task = array(
					':fb_id' => $fb_id, 
					':interest_id' =>  $_id,
					':like_date' => $_date
					);

		$q = $conn->prepare($sql);

		$q->execute($task);

	} catch (PDOException $pe) {
		echo($pe);
	}
}

echo("Like mapping finished");

try {

	if ($count == 0)
		die("count is 0");

	$sql = 'INSERT INTO likes_refresh_data(fb_id, likes_count, refresh_date)
					VALUES(:fb_id, :count, :ref_date)';

	$task = array(
				':fb_id' => $fb_id, 
				':count' => $count,
				':ref_date' => $str_date
				);

	$q = $conn->prepare($sql);

	$q->execute($task);

	// echo("Added " . $str_date . " as refresh date for " . $count . " likes.");

} catch (PDOException $pe) {
	// echo($pe);
}

$conn = null;

?>
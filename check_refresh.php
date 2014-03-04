<?php
/*
 * Check refresh date for:
 * - Likes
 *
 */

function checkLikeRefreshDate($conn, $user_id) {

	//PC::db("Checking like refresh date for ". $user_id);

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
		try {
			$today_dt = new DateTime("now", new DateTimeZone('America/Los_Angeles'));
			$refresh_dt = new DateTime($refresh, new DateTimeZone('America/Los_Angeles'));
		} catch(Exception $ex) {
			PC::db("Failed calculating refresh info, refresh date probably null");
		}

		//PC::db($today_dt);
		//PC::db($refresh_dt);

		if($today_dt > $refresh_dt || $refresh == null)
			echo("<button id=\"getLikes\" class=\"btn\">Update Likes</button>");
		else
			echo("<p>You can update your \"like\" data after " . $refresh_dt->format('m-d') . "</p>");

	} catch (PDOException $pe) {
		//PC::db($pe);
		PC::db($pe."\n");
	}

	$conn = null;
}

?>
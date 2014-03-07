<?php
/*
 *
 * Map queries
 *
 */

/* So we'll get the array of selected interests from the previous page
   Then we're going to loop through that array and do something like this:
   		for(items in $arr) {
			$sql += " OR interest.category =". $arr[i];
   		}

SELECT 
 	 DISTINCT (m.fb_id),
     u.lat,
     u.lng
FROM interests AS i
     INNER JOIN  interest_map AS m
         ON ( i.id = m.interest_id )
	 INNER JOIN users AS u ON m.fb_id = u.fb_id
WHERE i.category = :category
     AND EXISTS (
             SELECT *
             FROM interest_map AS m2
             WHERE m2.fb_id = :fb_id
                 AND m2.interest_id = m.interest_id
         )
ORDER BY m.fb_id, i.name;

*/

ini_set('max_execution_time', 300); //300 seconds = 5 minutes

require_once 'dbconfig.php';

try {
	$conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
} catch (PDOException $pe){
	die("Could not connect to the database $dbname: " . $pe->getMessage());
}

	// PC::db("Checking like refresh date for ". $user_id);

$fb_id = null;
$category = null;

if(isset($_REQUEST['fb_id'])) {
	$fb_id = $_REQUEST['fb_id'];
}

if(isset($_REQUEST['category'])) {
	$category = $_REQUEST['category'];
}

try {
	$sql = 'SELECT DISTINCT (m.fb_id), u.lat, u.lng FROM interests AS i INNER JOIN  interest_map AS m ON ( i.id = m.interest_id ) INNER JOIN users AS u ON m.fb_id = u.fb_id WHERE i.category = :category AND EXISTS (SELECT * FROM interest_map AS m2 WHERE m2.fb_id = :fb_id AND m2.interest_id = m.interest_id)';


	$task = array(
		':fb_id' => $fb_id,
		':category' => $category
		);

	$q = $conn->prepare($sql);
	$q->execute($task);
	$q->setFetchMode(PDO::FETCH_ASSOC);

	echo("<script>\n");
	echo("\tvar heatmap2 = [];\n");
	
	while($r = $q->fetch()) {
		echo("heatmap2.push(".$r['lat'].", ".$r['lng'].");\n");
	}

	echo("</script>\n");

} catch (PDOException $pe) {
	// PC::db($pe);
}

$conn = null;

?>
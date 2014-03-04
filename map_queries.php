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

   	SELECT DISTINCT u.fb_id
	FROM users AS u
	INNER JOIN interest_map AS im ON im.fb_id = u.fb_id
	INNER JOIN interests AS i ON i.id = im.interest_id
	WHERE i.category = 'Computers/technology' OR i.category = 'Artist'
*/



?>
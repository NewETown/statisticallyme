<?php

function getFacebookCategories($conn) {

	// PC::db("Checking like refresh date for ". $user_id);

	try {
		$sql = 'SELECT DISTINCT category FROM interests';

		$q = $conn->prepare($sql);

		$q->execute();
		$q->setFetchMode(PDO::FETCH_ASSOC);

		$count = 0;
		
		while($r = $q->fetch()) {
			$count++;

			if($count == 1)
				echo("<div class=\"row\" style=\"padding-top:10px;\">\n\t<div class=\"col-md-offset-1 col-md-2 text-center\">");
			else
				echo("\n\t<div class=\"col-md-2 text-center\">");

			echo("\n\t\t\t<button class=\"btn\">".$r['category']."</button>");

			if($count == 5) {
				$count = 0;
				echo("\n\t\t</div>\n\t</div>");
			}
			else
				echo("\n\t\t</div>");
		}

	} catch (PDOException $pe) {
		// PC::db($pe);
	}

	$conn = null;
}


?>
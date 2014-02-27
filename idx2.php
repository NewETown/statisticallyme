<?php session_start();

require_once 'dbconfig.php';
require_once 'settings.php';

try {
	$conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
} catch (PDOException $pe){
	die("Could not connect to the database $dbname: " . $pe->getMessage());
}

getHeader();

?>

<div class="hero">
	<div class="greeting">
		<h4>Learn something about yourself</h4>
		<h1>Statistically.Me</h1>
		<a id="fbRegister" href="#"><img src="img/flat_fb_login.png"></a>
	</div>
</div>


<?php
	getFooterJS();
?>



<?php
	getFooter();
?>
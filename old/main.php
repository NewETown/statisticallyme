<?php

require_once 'dbconfig.php';
require_once 'settings.php';

try {
	$conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $pe){
	die("Could not connect to the database $dbname: " . $pe->getMessage());
}

$username = "";
$password = "";

if(isset($_POST['username'])) {
	$username = $_POST['username'];
	$username = trim($username);
}

if(isset($_POST['password'])) {
	$password = $_POST['password'];
	$password = md5(trim($password));
}

getHeader();

?>

<?php

try {

$sql = 'SELECT user_name, long_pw FROM users WHERE user_name=:usr';

$q = $conn->prepare($sql);

$q->execute(array(':usr' => $username));

$r = $q->fetch();

$q->closeCursor();

// $password = hash('sha256', $r['salt'] + $password);

$valid = validate_password($password, $r['long_pw']);

if($valid) {
	echo("<p>Username: " . $r['user_name'] . "</p>");
	// echo("<p>Hash: " . $r['password'] . "</p>");
	// echo("<p>Salt: " . $r['salt'] . "</p>");
	echo("<p>Valid: " . $valid . "</p>");
} else if(empty($r)) {
	echo("<p>Sorry that username doesn't exist.</p>");
	echo("<p><a href=\"index.php\">Go back</a></p>");
} else {
	echo("<p>Sorry your password didn't work</p>");
	echo("<p>Valid: " . $valid . "</p>");
	echo("<p><a href=\"index.php\">Go back</a></p>");
}

// echo("<h1>Welcome " . $username . "!</h1>\n");

} catch (PDOException $pe) {
	die("Error logging in: " . $pe->getMessage());
}

$conn = null;

?>

<?php

getFooter();

?>
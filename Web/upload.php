<?php

require_once('includes/dbconnect.php');

if (ini_get('magic_quotes_gpc')) {
	foreach ($_GET as $k => $v) {
		$_GET[$k] = stripslashes($v);
	}
	foreach ($_POST as $k => $v) {
		$_POST[$k] = stripslashes($v);
	}
}
//
function sanitise_filename($filename) {
	return basename(preg_replace("/[^0-9a-z._-]/i", "", $filename));
}

if (isset($_POST['submit'])) {
		// Require Secret Key
		require_once('includes/secret.php');

		// Get Values
		$location = $_POST['location'];
		$count = $_POST['count'];
		$rawtimestamp = $_POST['rawtimestamp'];
		$zone = $_POST['zone'];

		// Prepare INSERT QUERY
		$sqlq = "INSERT INTO `data` (`timestamp`,`location`,`event`,`zone`) VALUES (:rawtimestamp,:location,:count,:zone)";
		$q = $DBH->prepare($sqlq);
		$q->execute(array(':rawtimestamp' => $rawtimestamp, ':count' => $count, ':location' => $location, ':zone' => $zone));

		// Error Handling
		if (!$q) {
			echo "Error: can't insert into database. ".$q->errorCode();
			exit;
		}
		else {
			echo "Count: " .$count;
			echo "</br>";
            echo "Location: " . $location;
            echo "</br>";
            echo "Zone: " . $zone;
            echo "</br>";
			echo "Raw Timestamp: " . $rawtimestamp;
			exit;
		}
} else {
    http_response_code(404);
}
?>

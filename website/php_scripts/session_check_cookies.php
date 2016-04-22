<?php
	setcookie("prevURL", $_COOKIE['currURL'], time() + 120, "/"); // store prevURL from currURL in cookie
	$setURL = $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
	setcookie("currURL", $setURL, time() + (86400 * 30), "/"); // store new currURL in cookie
?>
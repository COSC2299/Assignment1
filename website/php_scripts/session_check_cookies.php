<?php
	setcookie("prevURL", $_COOKIE['currURL'], time() + 120, "/"); // store array in cookie
	$setURL = $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
	setcookie("currURL", $setURL, time() + (86400 * 30), "/"); // store array in cookie
?>
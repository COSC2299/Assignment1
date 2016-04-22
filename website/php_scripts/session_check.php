<?php
	session_start();
	if ($_SESSION['newSession'] == false && isset($_COOKIE['currURL'])){
		$url = "Location:".$_COOKIE['currURL'];
		$_SESSION['newSession'] = true;
		header($url);
	}
?>
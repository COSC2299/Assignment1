<?php
	session_start();
	if ($_SESSION['newSession'] == false){
		$url = "Location:".$_COOKIE['currURL'];
		$_SESSION['newSession'] = true;
		header($url);
	}
?>
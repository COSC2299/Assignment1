<?php
	session_start();
	if ($_SESSION['newSession'] == false && isset($_COOKIE['currURL'])){ // if new session & currURL is set, nav to previousURL
		$url = "Location:".$_COOKIE['currURL'];
		$_SESSION['newSession'] = true;
		header($url);
	}
?>
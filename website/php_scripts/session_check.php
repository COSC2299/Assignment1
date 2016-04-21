<?php
	//echo $_SERVER['PHP_SELF'];
	setcookie("currURL", $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'], time() + (86400 * 40), "/"); // store array in cookie
	if ($_SESSION['newSession'] == false){
		$url = "Refresh:0; url=".$_COOKIE['currURL'];
		$_SESSION['newSession'] = true;
		header($url);
	}
?>
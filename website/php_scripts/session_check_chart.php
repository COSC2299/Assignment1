<?php
	if ($_SESSION['newSession'] != false && $_SESSION['ready'] == true){ 
		if ($_SESSION['openChart'] == false && isset($_COOKIE['chartURL'])){ // if chart isnt open, and charturl set, reopen window
			echo '<script>';
			echo "window.open('".$_COOKIE['chartURL']."', 'chartWindow', 'width=1300, height=1000')"; 
			echo '</script>';
			$_SESSION['openChart'] = true;
		}
	}
	else{
		$_SESSION['ready'] = true;
	}
?>
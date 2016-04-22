<?php
	if ($_SESSION['newSession'] != false && $_SESSION['ready'] == true){
		echo $_SESSION['openChart'];
		if ($_SESSION['openChart'] == false && isset($_COOKIE['chartURL'])){
			echo '<script></script>';
			echo '<script>';
			echo "window.open('".$_COOKIE['chartURL']."', 'chartWindow', 'width=1300, height=1000')"; 
			echo '</script>';
			$_SESSION['openChart'] = true;
		}
		echo $_SESSION['openChart'];
	}
	else{
		$_SESSION['ready'] = true;
	}
?>
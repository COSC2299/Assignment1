<?php
   session_start();
?>

<?php
	$favID = $_GET['favID'];
	if ($favID == '-1'){ // if favID == -1, remove all favourites
		setcookie("favourites", json_encode($favList), time() - (86400 * 40), "/"); // set cookie to expire 30 days ago
		$_SESSION['showAttentionBar'] = true;
		$_SESSION['attentionBarText'] = 'All favourites have been removed.';
	}
	else if (isset($_GET['favID'])){
		//unset($_SESSION['favourites'][$favID]);
      //$_SESSION['favourites'] = array_values($_SESSION['favourites']);
      $favList = array();
		$favList = json_decode($_COOKIE['favourites'], true); // get current array from cookie

		$_SESSION['showAttentionBar'] = true;
		$_SESSION['attentionBarText'] = $favList[$favID]['city'].', '.$favList[$favID]['state'].' has been removed from your favourites.';

		unset($favList[$favID]); // remove favourite from array
		$favList = array_values($favList); // fix array indexes
		
		setcookie("favourites", json_encode($favList), time() + (86400 * 40), "/"); // set new cookie to array
	}
?>
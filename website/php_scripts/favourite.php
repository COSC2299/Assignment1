<?php
	session_start();
	
	$fav = $_POST['city']; // get city
	$state = $_POST['state'];	//get state
	$id = $_POST['id'];	// get city id

	$favList = array();
	$favList = json_decode($_COOKIE['favourites'], true); // get current list of favourites

	$j = count($favList); // count how many favourites exist
	//echo $j;

	$exists = false;
	for ($i=0; $i < $j ; $i++) {  // check if favourite already exists
		if($id == $favList[$i]['id']){
			$exists = true;
		}
	}
	if(!$exists) // if it doesn't exist, add to array
	{
		$favList[$j]['city'] = $fav;
		$favList[$j]['state'] = $state;
		$favList[$j]['id'] = $id;
		setcookie("favourites", json_encode($favList), time() + (86400 * 40), "/"); // store array in cookie
		$_SESSION['showAttentionBar'] = true;
		$_SESSION['attentionBarText'] = $fav.', '.$state.' has been successfully added to your favourites.';
	}
	else{
		$_SESSION['showAttentionBar'] = true;
		$_SESSION['attentionBarText'] = $fav.', '.$state.' has already been added to your favourites.';
	}
		
	print_r($favList);
	//$_COOKIE['favourites'] = $favList;
	print_r(json_decode(json_encode($favList)), true);
?>
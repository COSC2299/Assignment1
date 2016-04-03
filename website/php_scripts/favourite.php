<?php
	session_start();

	$fav = $_POST['city'];
	$state = $_POST['state'];

	$favList = $_SESSION['favourites'];

	$j = count($favList);
	$favList[$j]['city'] = $fav;
	$favList[$j]['state'] = $state;

	$_SESSION['favourites'] = $favList;

	echo 'Fva:'.$fav;
	print_r($_SESSION);

//	unset($_SESSION['favourites']);
?>
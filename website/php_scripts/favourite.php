<?php
	session_start();

	$fav = $_POST['city'];
	$state = $_POST['state'];
	$id = $_POST['id'];

	$favList = $_SESSION['favourites'];

	$j = count($favList);
	$favList[$j]['city'] = $fav;
	$favList[$j]['state'] = $state;
	$favList[$j]['id'] = $id;

	$_SESSION['favourites'] = $favList;

	echo 'Fva:'.$fav;
	print_r($_SESSION);

	//unset($_SESSION['favourites']);
	//setcookie('favourites','', 1); //10 years
    //setcookie('test', 'Im a test', 1); //10 years

?>
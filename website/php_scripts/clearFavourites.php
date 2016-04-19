<?php
   session_start();
?>

<?php
	$favID = $_GET['favID'];
	if ($favID == '-1'){
		$favList = array();
		setcookie("favourites", json_encode($favList), time() - (86400 * 40), "/");
	}
	else if (isset($_GET['favID'])){
		//unset($_SESSION['favourites'][$favID]);
      //$_SESSION['favourites'] = array_values($_SESSION['favourites']);
      $favList = array();
		$favList = json_decode($_COOKIE['favourites'], true);

		unset($favList[$favID]);
		$favList = array_values($favList);
		
		setcookie("favourites", json_encode($favList), time() + (86400 * 40), "/");
	}
?>

<?php
	/*
	print_r($_SESSION);
                  unset($_SESSION['favourites'][0]);
                  $_SESSION['favourites'] = array_values($_SESSION['favourites']);
	*/
?>

<?php
	/*
	require dirname(__DIR__).'/php_scripts/sqlSecurity.php';
	try{
	        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
	                                   // set the PDO error mode to excepti
	        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	        $sql = 'DELETE FROM weatherdata';

	        $sth = $conn->prepare($sql);

	        $sth->execute();

	    }
	     catch(PDOException $e)
	     {
	         echo $sql . "<br/>" . $e->getMessage();
	     }
	*/
?>
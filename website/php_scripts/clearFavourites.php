<?php
   session_start();
?>

<?php
	$favID = $_GET['favID'];
	if ($favID == '-1'){ // if favID == -1, remove all favourites
		setcookie("favourites", json_encode($favList), time() - (86400 * 40), "/"); // set cookie to expire 30 days ago
		$_SESSION['showAttentionBar'] = true;
		$_SESSION['attentionBarText'] = 'All favourites have been removed.';

		//Delete from Database
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
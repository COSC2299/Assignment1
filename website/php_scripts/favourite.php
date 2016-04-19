<?php
	session_start();
	
	$fav = $_POST['city'];
	$state = $_POST['state'];
	$id = $_POST['id'];

	$favList = array();
	$favList = json_decode($_COOKIE['favourites'], true);

	$j = count($favList);
	//echo $j;

	$exists = false;
	for ($i=0; $i < $j ; $i++) { 
		if($id == $favList[$i]['id']){
			$exists = true;
		}
	}
	if(!$exists)
	{
		$favList[$j]['city'] = $fav;
		$favList[$j]['state'] = $state;
		$favList[$j]['id'] = $id;
	}
		
	print_r($favList);
	//$_COOKIE['favourites'] = $favList;
	setcookie("favourites", json_encode($favList), time() + (86400 * 40), "/");
	print_r(json_decode(json_encode($favList)), true);

	/*
	require dirname(__DIR__).'/php_scripts/sqlSecurity.php';
	try{
	        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
	                                   // set the PDO error mode to excepti
	        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	        $sql = 'SELECT url FROM city WHERE id = '.$id;

	           
	        foreach ($conn->query($sql) as $row) {
	            $url = $row['url'];
	        }
	           
			$string = file_get_contents($url);
			$weather = json_decode($string, true);

			echo '<br/><br/>OBS: ';
	    	print_r($weather);
			foreach ($weather['observations']['data'] as $reading) {
		
				$sql = "INSERT IGNORE INTO weatherdata (city_id, temp, t_datetime) VALUES (:city_id, :temp, :t_datetime)";

			    $sth = $conn->prepare($sql);

			    $sth->bindParam(':city_id', $id, PDO::PARAM_INT);
			    $sth->bindParam(':temp', $reading['air_temp'], PDO::PARAM_STR, 12);
			    $sth->bindParam(':t_datetime', $reading['local_date_time_full'], PDO::PARAM_STR, 12);
			    

			    $sth->execute();

			    $lastId = $conn->lastInsertId();

			}

   	}
	catch(PDOException $e)
	{
	    echo $sql . "<br/>" . $e->getMessage();
	}
	*/

	//unset($_SESSION['favourites']);
	//setcookie('favourites','', 1); //10 years
    //setcookie('test', 'Im a test', 1); //10 years

?>
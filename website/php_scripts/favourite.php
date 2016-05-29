<?php
	//session_start();
	
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
		
	//print_r($favList);
	//$_COOKIE['favourites'] = $favList;
	//print_r(json_decode(json_encode($favList)), true);

	addfavourite($id);

	function addfavourite($id)
	{
		require dirname(__DIR__).'/php_scripts/sqlSecurity.php';
		try{
		        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		                                   // set the PDO error mode to excepti
		        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		       $url = getCityURL($id);
		        
		        if(isset($url) && $url != '')
			    {
					$string = file_get_contents($url);
					$weather = json_decode($string, true);

					foreach ($weather['observations']['data'] as $reading) {
				
						$sql = "INSERT IGNORE INTO weatherdata (city_id, temp, t_datetime, cloud, rain, w_dir, w_speed, w_gust, pressure, humiditiy) 
														VALUES (:city_id, :temp, :t_datetime, :cloud, :rain, :w_dir, :w_speed, :w_gust, :pressure, :humidity)";

						    $sth = $conn->prepare($sql);

						    $sth->bindParam(':city_id', (intval($id)), PDO::PARAM_INT);
						    $sth->bindParam(':temp', $reading['air_temp'], PDO::PARAM_STR, 12);
						    $sth->bindParam(':t_datetime', $reading['local_date_time_full'], PDO::PARAM_STR, 12);
						    $sth->bindParam(':cloud', $reading['cloud'], PDO::PARAM_STR, 12);
						    $sth->bindParam(':rain', $reading['rain_trace'], PDO::PARAM_STR, 12);
						    $sth->bindParam(':w_dir', $reading['wind_dir'], PDO::PARAM_STR, 12);
						    $sth->bindParam(':w_speed', (intval($reading['wind_spd_kmh'])), PDO::PARAM_INT);
						    $sth->bindParam(':w_gust', (intval($reading['gust_kmh'])), PDO::PARAM_INT);
						    $sth->bindParam(':pressure', $reading['press'], PDO::PARAM_STR, 12);
						    $sth->bindParam(':humidity', (intval($reading['rel_hum'])), PDO::PARAM_INT);
					    

					    $sth->execute();

					    $lastId = $conn->lastInsertId();

					}
				}

	   	}
		catch(PDOException $e)
		{
		    echo $sql . "<br/>" . $e->getMessage();
		}

	}

	function getCityURL($id) 
	{
		require dirname(__DIR__).'/php_scripts/sqlSecurity.php';
		try{
			$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
			$sql = 'SELECT url FROM city WHERE id = '.$id;

			$url = '';
			foreach ($conn->query($sql) as $row) {
			    $url = $row['url'];

			}
			return $url;
		}
		catch(PDOException $e)
		{
		    echo $sql . "<br/>" . $e->getMessage();
		}
	}
?>
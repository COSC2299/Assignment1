<?php //include 'search.php'; ?>
<br>
<br>
<p><a href="all_states.php">Return to States</a></p>
<?php

	require dirname(__DIR__).'/php_scripts/sqlSecurity.php';


	//Fix format for selected city from GET
	$selectedCity = str_replace("%20", " ", $selectedCity);
	$selectedCity = str_replace("+", " ", $selectedCity);


	//If state passed through in same var as City, separate out based on delimeter of "-"
	$delim = strpos($selectedCity, "-");
	if($delim > 0 && !isset($selectedState)) {
		$selectedState = substr($selectedCity, $delim + 2);
		$selectedCity = substr($selectedCity, 0, $delim - 1);
	}

	//If there is no id for the city, search the db using the city name
	if(!isset($id))
	{
		try{
	        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
	                                   // set the PDO error mode to excepti
	        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	        $sql = 'SELECT id FROM city WHERE name = "'.$selectedCity.'"';

	           
	           foreach ($conn->query($sql) as $row) {
	               $id = $row['id'];
	           }
	           

	      }
	      catch(PDOException $e)
	     {
	         echo $sql . "<br/>" . $e->getMessage();
	     }

	}
	//replace space for url
	$stateURL = str_replace(" ", "%20", $selectedState);
	$cityURL = str_replace(" ", "%20", $selectedCity);
	echo '<p><a href="state.php?s='.$stateURL.'&id='.$sID.'">Return to stations in '.$selectedState.'</a></p>';
	
	echo '<br>';
	echo '<br>';
?>
	<p><a href="#" onclick="window.open('<?php echo 'city_chart.php?c='.$cityURL.'&s='.$stateURL.'&id='.$id.'&sID='.$sID.'&type=Temperature&time=12';?>', 'chartWindow', 'width=1300, height=1000'); return false;">Display Charts</a></p>
<?php
	/*
	$states = json_decode(file_get_contents(dirname(__DIR__).'/php_scripts/stations.json'), true);

	$url = "";

	foreach ($states as $state) {
		if($state['state'] == $selectedState)
		{
			foreach ($state['stations'] as $city) {
					if($city['city'] == $selectedCity) {
						$url = $city['url'];
					}

				}	
		}

	}
	*/


	  

	  try{
	        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
	                                   // set the PDO error mode to excepti
	        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	        $sql = 'SELECT url FROM city WHERE id = '.$id;

	           
	           foreach ($conn->query($sql) as $row) {
	               $url = $row['url'];
	           }
	           

	      }
	      catch(PDOException $e)
	     {
	         echo $sql . "<br/>" . $e->getMessage();
	     }
	              

	$inFav = false;

	foreach($_SESSION['favourites'] as $fav){
		if ($fav['id'] == $id) {
			
			$inFav = true;

		}
	}

	if($inFav)
	{
		 $sql = 'SELECT * FROM weatherdata WHERE city_id = '.$id.' ORDER BY t_datetime DESC';

	           $i = 0;
	           foreach ($conn->query($sql) as $row) {
	               $stationsSQL['observations']['data'][$i]['air_temp'] = $row['temp'];

	               $date = strtotime($row['t_datetime']);
	               $date = date('YmdHi', $date);
	               $stationsSQL['observations']['data'][$i]['local_date_time_full'] = $date;//20160421100000
	         
	         		//echo $date;

	               $i++;

	           }

	}

		
		$string = file_get_contents($url);
		$stations = json_decode($string, true);
	


	//echo '<strong>'.$stations['observations']['data'][0]['name'].'</strong>';
	//echo '<br />';

?>

<br>

<?php
	foreach ($stations['observations']['header'] as $header) {
		echo '<p>'.$header['product_name'].'</p>';
		echo '<p>'.$header['refresh_message'].'</p>';
	}
?>

<br>

<table border='1' style='width:100%; margin:auto;'>
	<tr>
		<th rowspan='2'>Date</th>
		<th rowspan='2'>Time</th>
		<th rowspan='2'>Temperature</th>
		<th rowspan='2'>Cloud</th>
		<th rowspan='2'>Rain (mm)<br>Since 9am</th>
		<th colspan='3'>Wind</th>
		<th rowspan='2'>Pressure<br>hPa</th>
		<th rowspan='2'>Relative<br>Humidity</th>
	</tr>
	<tr>
		<th>Direction</th>
		<th>Speed<br>km/m</th>
		<th>Gust<br>km/m</th>
	</tr>

<?php
	//Loop through all the data, creating one table row for each observation
	foreach ($stations['observations']['data'] as $station) {
		echo '<tr>';

			//Split date in to readable format
			$date = $station['local_date_time_full'];
			$year = substr($date, 0, 4);
			$month = substr($date, 4, 2);
			$day = substr($date, 6, 2);
			$hour = substr($date, 8, 2);
			$minute = substr($date, 10, 2);
			echo '<td>'.$day.'/'.$month.'/'.$year.'</td>';
			echo '<td>'.$hour.':'.$minute.'</td>';
			echo '<td>'.$station['air_temp'].'</td>';
			echo '<td>'.$station['cloud'].'</td>';
			echo '<td>'.$station['rain_trace'].'</td>';
			echo '<td>'.$station['wind_dir'].'</td>';
			echo '<td>'.$station['wind_spd_kmh'].'</td>';
			echo '<td>'.$station['gust_kmh'].'</td>';
			echo '<td>'.$station['press'].'</td>';
			echo '<td>'.$station['rel_hum'].'</td>';
		echo '</tr>';

	}
	//Loop through All Database data
	if ($inFav)
	{
		foreach ($stationsSQL['observations']['data'] as $station) {
			echo '<tr>';

				//Split date in to readable format
				$date = $station['local_date_time_full'];
				$year = substr($date, 0, 4);
				$month = substr($date, 4, 2);
				$day = substr($date, 6, 2);
				$hour = substr($date, 8, 2);
				$minute = substr($date, 10, 2);
				echo '<td>'.$day.'/'.$month.'/'.$year.'</td>';
				echo '<td>'.$hour.':'.$minute.'</td>';
				echo '<td>'.$station['air_temp'].'</td>';
				echo '<td>'.$station['cloud'].'</td>';
				echo '<td>'.$station['rain_trace'].'</td>';
				echo '<td>'.$station['wind_dir'].'</td>';
				echo '<td>'.$station['wind_spd_kmh'].'</td>';
				echo '<td>'.$station['gust_kmh'].'</td>';
				echo '<td>'.$station['press'].'</td>';
				echo '<td>'.$station['rel_hum'].'</td>';
			echo '</tr>';
		}

		try{
		  
				foreach ($stationsSQL['observations']['data'] as $reading) {
			
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

	}


?>
</table>
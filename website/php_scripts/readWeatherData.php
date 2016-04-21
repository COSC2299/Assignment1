<?php //include 'search.php'; ?>
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
	echo '<br>';
	echo '<p class="title_large">' . $selectedCity . '</p>';
	echo '<p class="title_medium">' . $selectedState . '</p>';
?>

	<p><a href="#" onclick="location.reload()">Refresh</a></p>

<?php
	$favList = array();
	$favList = json_decode($_COOKIE['favourites'], true); // get current list of favourites

	$j = count($favList); // count how many favourites exist
	//echo $j;

	$exists = false;
	for ($i=0; $i < $j ; $i++) {  // check if favourite already exists
		if($id == $favList[$i]['id']){
			$exists = true;
			$favID = $i;
		}
	}
	if(!$exists) // if it doesn't exist, add to array
	{
?>
		<p><a href="#" onclick="fav('<?php echo str_replace("'", "&#146;", $selectedCity); ?>', '<?php echo $selectedState ?>', '<?php echo $id ?>')">Favourite This Station</a></p>
<?php
	}
	else{
		echo '<p><a href="#" onclick="clearFav('.$favID.')">Unfavourite This Station</a></p>'; // create unfavourite button
	}
	echo '<br>';
?>



<?php
   echo '<p><a href="all_states.php">Return to States</a></p>';
	echo '<p><a href="state.php?s='.$stateURL.'&id='.$sID.'">Return to stations in '.$selectedState.'</a></p>';
	
	echo '<br>';
?>
	<p><a href="#" onclick="window.open('<?php echo 'city_chart.php?c='.$cityURL.'&s='.$stateURL.'&id='.$id.'&sID='.$sID.'&type=Temperature&time=12';?>', 'chartWindow', 'width=1300, height=1000'); return false;">Display Charts</a></p>
<?php

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
	                     

	$string = file_get_contents($url);
	$stations = json_decode($string, true);

	//echo '<strong>'.$stations['observations']['data'][0]['name'].'</strong>';
	//echo '<br />';

?>

<br>

<?php
	foreach ($stations['observations']['header'] as $header) {
		echo '<p class="title_small">'.$header['product_name'].'</p>';
		echo '<p class="center">'.$header['refresh_message'].'</p>';
	}
?>

<br>

<?php

	$minTemp = 100; // initialise $minTemp
	$maxTemp = -100; // initialise $maxTemp
	$currDate = 0;
	$nineAmTemp = 1000;
	$threePmTemp = 1000;
	
	foreach ($stations['observations']['data'] as $station) {
		$date = $station['local_date_time_full'];
		$year = substr($date, 0, 4);
		$month = substr($date, 4, 2);
		$day = substr($date, 6, 2);
		$hour = substr($date, 8, 2);
		$minute = substr($date, 10, 2);
		
		if ($currDate == 0){
			$currDate = $day . $month . $year;
		}
		
		if ($currDate == $day.$month.$year){
			if ($station['air_temp'] < $minTemp){
				$minTemp = $station['air_temp'];
				$minHour = $hour;
				$minMinute = $minute;
			}
			if ($station['air_temp'] > $maxTemp){
				$maxTemp = $station['air_temp'];
				$maxHour = $hour;
				$maxMinute = $minute;
			}
			if ($hour == '09'){
				$nineAmTemp = $station['air_temp'];
			}
			if ($hour == '15'){
				$threePmTemp = $station['air_temp'];
			}
		}
		//echo $hour;
	}
	
	echo '<p class="center">Maximum temperature '.$maxTemp.'&deg;C, today at '.$maxHour.':'.$maxMinute.'</p>';
	echo '<p class="center">Minimum temperature '.$minTemp.'&deg;C, today at '.$minHour.':'.$minMinute.'</p>';
	echo '<br>';
	if ($nineAmTemp == 1000){
		echo '<p class="center">9am temperature not available</p>';
	}
	else{
		echo '<p class="center">9am temperature: '.$nineAmTemp.'&deg;C</p>';
	}
	if ($threePmTemp == 1000){
		echo '<p class="center">3pm temperature not available</p>';
	}
	else{
		echo '<p class="center">3pm temperature: '.$threePmTemp.'&deg;C</p>';
	}
?>

<br>

<?php
	$currDate = 0;
	$firstTable = true;
	//Loop through all the data, creating one table row for each observation
	foreach ($stations['observations']['data'] as $station) {

			//Split date in to readable format
			$date = $station['local_date_time_full'];
			$year = substr($date, 0, 4);
			$month = substr($date, 4, 2);
			$day = substr($date, 6, 2);
			$hour = substr($date, 8, 2);
			$minute = substr($date, 10, 2);
			
			
			if($currDate != $day.$month.$year && $firstTable == false){
				echo '</table>';
				echo '<br>';
				echo '<br>';
			}
			
			$firstTable = false;
			
			if($currDate != $day.$month.$year){
				$currDate = $day.$month.$year;
?>
				<h3 class="center"><?php echo $day.'/'.$month.'/'.$year;?></h3>
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
			}
			echo '<tr>';
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

?>
</table>
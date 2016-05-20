<?php //include 'search.php'; ?>
<?php

	require dirname(__DIR__).'/php_scripts/sqlSecurity.php';
	
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
	<p><a href="#" onclick="displayChart()">Display Charts</a></p>
<?php
	if(isset($id))
	{
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
		

		//$string = file_get_contents($url);
		//$stations = json_decode($string, true);

		//echo '<strong>'.$stations['observations']['data'][0]['name'].'</strong>';
		//echo '<br />';

	?>

	<br>

	<?php
		// ********************************************************************************************************
		foreach ($stations['observations']['data'] as $station) {
			$latitude = $station['lat'];
			$longitude = $station['lon'];
		}
		$forecast_url = 'https://api.forecast.io/forecast/1f05fbee8b8ba738d4f50f6cc418cdcf/'.$latitude.','.$longitude;
	
		// forecast.io
		$forecast_string = file_get_contents($forecast_url);
		$forecast = json_decode($forecast_string, true);
		
		// forecast.io temperature
		$forecast_temp_raw = ($forecast['currently']['temperature'] - 32) * 5/9;
		$forecast_temp = number_format($forecast_temp_raw, 2, '.', '');
		//echo $forecast_temp;
		
		// forecast.io time
		$forecast_timezone = $forecast['timezone'];
		date_default_timezone_set($forecast_timezone);
		$forecast_time_epoch = $forecast['currently']['time'];
		$forecast_time = date('l jS F Y g:ia T', $forecast_time_epoch);
		
		// forecast.io icon
		/* FROM FORECAST.IO -> https://developer.forecast.io/docs/v2
		 * icon: A machine-readable text summary of this data point, suitable for selecting 
		 * an icon for display. If defined, this property will have one of the following 
		 * values: clear-day, clear-night, rain, snow, sleet, wind, fog, cloudy, 
		 * partly-cloudy-day, or partly-cloudy-night. (Developers should ensure that a 
		 * sensible default is defined, as additional values, such as hail, thunderstorm, 
		 * or tornado, may be defined in the future.)
		 */
		
		$forecast_icon_raw = $forecast['currently']['icon'];
		
		switch ($forecast_icon_raw){
			case "clear-day":
				$forecast_icon = "01d.png";
				break;
			case "clear-night":
				$forecast_icon = "01n.png";
				break;
			case "rain":
				$forecast_icon = "05d.png";
				break;
			case "snow":
				$forecast_icon = "13d.png";
				break;
			case "sleet":
				$forecast_icon = "13d.png";
				break;
			case "wind":
				$forecast_icon = "50d.png";
				break;
			case "fog":
				$forecast_icon = "50d.png";
				break;
			case "cloudy":
				$forecast_icon = "03d.png";
				break;
			case "partly-cloudy-day":
				$forecast_icon = "02d.png";
				break;
			case "partly-cloudy-night":
				$forecast_icon = "02n.png";
				break;
			case "thunderstorm":
				$forecast_icon = "11d.png";
				break;
			default:
				$forecast_icon = "01d.png";
				break;
		}
		//echo '<img src="media/images/weatherIcon/'.$forecast_icon.'" alt="'.$forecast_icon_raw.'">';
		
		// forecast.io precipitaion probability
		$forecast_precipProb = $forecast['currently']['precipProbability'] * 100;
		//echo $forecast_precipProb;
		
		// forecast.io humidity
		$forecast_humidity = $forecast['currently']['humidity'] * 100;
		//echo $forecast_humidity;
		
		$forecast_summary = $forecast['currently']['summary'];
		$forecast_windSpeed = $forecast['currently']['windSpeed'];
		$forecast_windBearing = $forecast['currently']['windBearing'];
		$forecast_cloudCover = $forecast['currently']['cloudCover'] * 100;
		$forecast_pressure = $forecast['currently']['pressure'];
		
		echo '<p class="title_small">Current Condition</p>';
		/*
		echo $forecast['currently']['time'];
		echo $forecast['currently']['summary'];
		echo $forecast['currently']['icon'];
		echo $forecast['currently']['precipProbability'];
		echo $forecast['currently']['temperature'];
		echo $forecast['currently']['humidity'];
		echo $forecast['currently']['windSpeed'];
		echo $forecast['currently']['windBearing'];
		echo $forecast['currently']['cloudCover'];
		echo $forecast['currently']['pressure'];
		*/
		echo '<div>';
		echo '<img src="media/images/weatherIcon/'.$forecast_icon.'" alt="'.$forecast_icon_raw.'">';
		echo '<p>'.$forecast_summary.'</p>';
		echo '</div>';
		echo '<div>';
		echo '<p> Temperature: '.$forecast_temp.'&deg;C</p>';
		echo '<p>Precipitation Probability: '.$forecast_precipProb.'%</p>';
		echo '<p>Humidity: '.$forecast_humidity.'%</p>';
		echo '<p>Wind Speed: '.$forecast_windSpeed.'mph</p>';
		echo '<p>Wind Bearing: '.$forecast_windBearing.'&deg;</p>';
		echo '<p>Cloud Cover: '.$forecast_cloudCover.'%</p>';
		echo '<p>Pressure: '.$forecast_pressure.'mBar</p>';
		echo '<p>Time: '.$forecast_time.'</p>';
		echo '</div>';
		//print_r($forecast['hourly']);
		//print_r($stations['observations']['data']);
	?>
	
	<br>
	<br>
	
	<?php
		echo '<p class="title_small">Hourly Forecasts</h3>';
		echo '<p class="center">'.$forecast['hourly']['summary'].'</p>';
		
		$currDate = 0;
		$firstTable = true;
		foreach ($forecast['hourly']['data'] as $hourlyForecast){
		
			// forecast.io temperature
			$forecast_temp_raw = ($hourlyForecast['temperature'] - 32) * 5/9;
			$forecast_temp = number_format($forecast_temp_raw, 2, '.', '');
			//echo $forecast_temp;
		
			// forecast.io time
			$forecast_time_epoch = $hourlyForecast['time'];
			$dt = new DateTime("@$forecast_time_epoch");
			$forecast_time = date('H:i', $forecast_time_epoch);
			$forecast_date = date('d/m/y', $forecast_time_epoch);
			$forecast_date_long = date('l jS F Y', $forecast_time_epoch);
			// forecast.io icon
			/* FROM FORECAST.IO -> https://developer.forecast.io/docs/v2
			 * icon: A machine-readable text summary of this data point, suitable for selecting 
			 * an icon for display. If defined, this property will have one of the following 
			 * values: clear-day, clear-night, rain, snow, sleet, wind, fog, cloudy, 
			 * partly-cloudy-day, or partly-cloudy-night. (Developers should ensure that a 
			 * sensible default is defined, as additional values, such as hail, thunderstorm, 
			 * or tornado, may be defined in the future.)
			 */
		
			$forecast_icon_raw = $hourlyForecast['icon'];
		
			switch ($forecast_icon_raw){
				case "clear-day":
					$forecast_icon = "01d.png";
					break;
				case "clear-night":
					$forecast_icon = "01n.png";
					break;
				case "rain":
					$forecast_icon = "05d.png";
					break;
				case "snow":
					$forecast_icon = "13d.png";
					break;
				case "sleet":
					$forecast_icon = "13d.png";
					break;
				case "wind":
					$forecast_icon = "50d.png";
					break;
				case "fog":
					$forecast_icon = "50d.png";
					break;
				case "cloudy":
					$forecast_icon = "03d.png";
					break;
				case "partly-cloudy-day":
					$forecast_icon = "02d.png";
					break;
				case "partly-cloudy-night":
					$forecast_icon = "02n.png";
					break;
				case "thunderstorm":
					$forecast_icon = "11d.png";
					break;
				default:
					$forecast_icon = "01d.png";
					break;
			}
			//echo '<img src="media/images/weatherIcon/'.$forecast_icon.'" alt="'.$forecast_icon_raw.'">';
		
			// forecast.io precipitaion probability
			$forecast_precipProb = $hourlyForecast['precipProbability'];
			//echo $forecast_precipProb;
		
			// forecast.io humidity
			$forecast_humidity = $hourlyForecast['humidity'] * 100;
			//echo $forecast_humidity;
		
			$forecast_summary = $hourlyForecast['summary'];
			$forecast_windSpeed = $hourlyForecast['windSpeed'];
			$forecast_windBearing = $hourlyForecast['windBearing'];
			$forecast_cloudCover = $hourlyForecast['cloudCover'];
			$forecast_pressure = $hourlyForecast['pressure'];
			
			
			if($currDate != $forecast_date && $firstTable == false){
				echo '</table>';
				echo '<br>';
				echo '<br>';
			}
			
			$firstTable = false;
			
			if($currDate != $forecast_date){
				$currDate = $forecast_date;
				
				?>
				<h3 class="center"><?php echo $forecast_date_long;?></h3>
				<table border='3' bordercolor='#BBB' style='width:100%; margin:auto; border-collapse: collapse;'>
					<tr>
						<th></th>
						<th>Date</th>
						<th>Time</th>
						<th>Summary</th>
						<th>Temperature</th>
						<th>Cloud Cover</th>
						<th>Precipitation<br>Probability</th>
						<th>Wind<br>Speed</th>
						<th>Humidity</th>
					</tr>	
				<?php
			}
			
			echo '<tr>';
			echo '<td><img src="media/images/weatherIcon/'.$forecast_icon.'" alt="'.$forecast_icon_raw.'" style="width:50px"></td>';
			echo '<td>'.$forecast_date.'</td>';
			echo '<td>'.$forecast_time.'</td>';
			echo '<td>'.$forecast_summary.'</td>';
			echo '<td>'.$forecast_temp.'</td>';
			echo '<td>'.$forecast_cloudCover.'</td>';
			echo '<td>'.$forecast_precipProb.'</td>';
			echo '<td>'.$forecast_windSpeed.'</td>';
			echo '<td>'.$forecast_humidity.'</td>';
			echo '</tr>';
		}
	?>
	
	</table>
	<br>

	<?php
		echo '<p class="title_small">Historical Data</p>';
		
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
		
		foreach ($stations['observations']['data'] as $station) { // format data from bom website
			$date = $station['local_date_time_full'];
			$year = substr($date, 0, 4);
			$month = substr($date, 4, 2);
			$day = substr($date, 6, 2);
			$hour = substr($date, 8, 2);
			$minute = substr($date, 10, 2);
			
			if ($currDate == 0){
				$currDate = $day . $month . $year;
			}
			
			if ($currDate == $day.$month.$year){ // calculate min temp
				if ($station['air_temp'] < $minTemp){
					$minTemp = $station['air_temp'];
					$minHour = $hour;
					$minMinute = $minute;
				}
				if ($station['air_temp'] > $maxTemp){ // calculate max temp
					$maxTemp = $station['air_temp'];
					$maxHour = $hour;
					$maxMinute = $minute;
				}
				if ($hour == '09'){ // get nine am temp
					$nineAmTemp = $station['air_temp']; 
				}
				if ($hour == '15'){ // get three pm temp
					$threePmTemp = $station['air_temp'];
				}
			}
			//echo $hour;
		}
		// display min max 9am 3pm data
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
					// split table into days
	?>
					<h3 class="center"><?php echo $day.'/'.$month.'/'.$year;?></h3>
					<table border='3' bordercolor='#BBB' style='width:100%; margin:auto; border-collapse: collapse;'>
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
				
						$sql = "INSERT IGNORE INTO weatherdata (city_id, temp, t_datetime, cloud, rain, w_dir, w_speed, w_gust, pressure, humiditiy) VALUES (:city_id, :temp, :t_datetime, :cloud, :rain, :w_dir, :w_speed, :w_gust, :pressure, :humidity)";

					    $sth = $conn->prepare($sql);

					    $sth->bindParam(':city_id', $id, PDO::PARAM_INT);
					    $sth->bindParam(':temp', $reading['air_temp'], PDO::PARAM_STR, 12);
					    $sth->bindParam(':t_datetime', $reading['local_date_time_full'], PDO::PARAM_STR, 12);
					    $sth->bindParam(':cloud', $reading['cloud'], PDO::PARAM_STR, 12);
					    $sth->bindParam(':rain', $reading['rain_trace'], PDO::PARAM_STR, 12);
					    $sth->bindParam(':w_dir', $reading['wind_dir'], PDO::PARAM_STR, 12);
					    $sth->bindParam(':w_speed', $reading['wind_spd_kmh'], PDO::PARAM_INT);
					    $sth->bindParam(':w_gust', $reading['gust_kmh'], PDO::PARAM_INT);
					    $sth->bindParam(':pressure', $reading['press'], PDO::PARAM_STR, 12);
					    $sth->bindParam(':humidity', $reading['rel_hum'], PDO::PARAM_INT);
					    

					    $sth->execute();

					}

		   	}
			catch(PDOException $e)
			{
			    echo $sql . "<br/>" . $e->getMessage();
			}

		}

	?>
	</table>
<?php 
	}//end if for ID Set
?>
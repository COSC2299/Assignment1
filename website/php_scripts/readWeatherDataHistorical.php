
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

?>
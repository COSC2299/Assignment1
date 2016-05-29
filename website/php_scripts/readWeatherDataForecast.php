	<?php
		// ********************************************************************************************************
		// get latitude and longitude from bom
		foreach ($stations['observations']['data'] as $station) {
			$latitude = $station['lat'];
			$longitude = $station['lon'];
		}
		// create url for forecast.io using lat and long
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
		$forecast_time = date('jS F Y g:ia T', $forecast_time_epoch);
		
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
		echo '<br>';
		echo '<p class="center">'.$forecast_summary.'</p>';
		echo '<div id="currentConditions">';
		echo '<div id="currentConditionImg">';
		echo '<img src="media/images/weatherIcon/'.$forecast_icon.'" alt="'.$forecast_icon_raw.'">';
		echo '</div>';
		echo '<div id="currentConditionText">';
		echo '<p> Temperature: '.$forecast_temp.'&deg;C</p>';
		echo '<p>Precipitation Probability: '.$forecast_precipProb.'%</p>';
		echo '<p>Humidity: '.$forecast_humidity.'%</p>';
		echo '<p>Wind Speed: '.$forecast_windSpeed.'mph</p>';
		echo '<p>Wind Bearing: '.$forecast_windBearing.'&deg;</p>';
		echo '<p>Cloud Cover: '.$forecast_cloudCover.'%</p>';
		echo '<p>Pressure: '.$forecast_pressure.'mBar</p>';
		echo '<p>Last Updated: '.$forecast_time.'</p>';
		echo '</div>';
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


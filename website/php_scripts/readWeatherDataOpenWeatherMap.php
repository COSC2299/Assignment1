	<?php
		// ********************************************************************************************************
		// get lat and long from bom
		foreach ($stations['observations']['data'] as $station) {
			$latitude = $station['lat'];
			$longitude = $station['lon'];
		}
		
		// create forecast (current conditions), daily forecasts url
		$forecast_url = 'http://api.openweathermap.org/data/2.5/weather?lat='.$latitude.'&lon='.$longitude.'&units=metric&appid=2d597f8d44eb76f4cecc1e09759fb148';
		$daily_url = 'http://api.openweathermap.org/data/2.5/forecast/daily?lat='.$latitude.'&lon='.$longitude.'&units=metric&appid=2d597f8d44eb76f4cecc1e09759fb148&cnt=16';
		$forecastio_url = 'https://api.forecast.io/forecast/1f05fbee8b8ba738d4f50f6cc418cdcf/'.$latitude.','.$longitude;
		
		// forecast.io used for timezone
		$forecastio_string = file_get_contents($forecastio_url);
		$forecastio = json_decode($forecastio_string, true);
		
		// openweathermap.org current conditions
		$forecast_string = file_get_contents($forecast_url);
		$forecast = json_decode($forecast_string, true);
		
		//openweathermap.org daily
		$daily_string = file_get_contents($daily_url);
		$daily = json_decode($daily_string, true);
		
		//print_r($forecast);
		//print_r($daily['list']['0']);
		
		// forecast.io temperature
		$forecast_temp = $forecast['main']['temp'];
		
		// forecast.io & openweathermap.org time 
		$forecast_timezone = $forecastio['timezone'];
		date_default_timezone_set($forecast_timezone);
		$forecast_time_epoch = $forecast['dt'];
		$forecast_time = date('jS F Y g:ia T', $forecast_time_epoch);
		$forecast_sunrise = date('g:ia T', $forecast['sys']['sunrise']);
		$forecast_sunset = date('g:ia T', $forecast['sys']['sunset']);

		
		$forecast_icon = $forecast['weather']['0']['icon'].'.png';
		
		
		//echo '<img src="media/images/weatherIcon/'.$forecast_icon.'" alt="'.$forecast_icon_raw.'">';
		
		// rainfall in past hour
		$forecast_rainfall = $forecast['rain']['1h'];
		//echo $forecast_precipProb;
		
		// humidity
		$forecast_humidity = $forecast['main']['humidity'];
		//echo $forecast_humidity;
		
		$forecast_summary = $forecast['weather']['0']['main'];
		$forecast_windSpeed = $forecast['wind']['speed'];
		$forecast_windBearing = $forecast['wind']['deg'];
		$forecast_cloudCover = $forecast['clouds']['all'];
		$forecast_pressure = $forecast['main']['pressure'];
		
		echo '<p class="title_small">Current Condition</p>';
		echo '<br>';
		echo '<p class="center">'.$forecast_summary.'</p>';
		echo '<div id="currentConditions">';
		echo '<div id="currentConditionImg">';
		echo '<img src="media/images/weatherIcon/'.$forecast_icon.'" alt="'.$forecast_icon.'">';
		echo '</div>';
		echo '<div id="currentConditionText">';
		echo '<p>Temperature: '.$forecast_temp.'&deg;C</p>';
		echo '<p>Humidity: '.$forecast_humidity.'%</p>';
		echo '<p>Wind Speed: '.$forecast_windSpeed.' km/h</p>';
		echo '<p>Wind Bearing: '.$forecast_windBearing.'&deg;</p>';
		echo '<p>Cloud Cover: '.$forecast_cloudCover.'%</p>';
		echo '<p>Sunrise: '.$forecast_sunrise.'</p>';
		echo '<p>Sunset: '.$forecast_sunset.'</p>';
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
		//echo '<p class="center">'.$forecast['hourly']['summary'].'</p>';
		
		$currDate = 0;
		$firstTable = true;
		foreach ($daily['list'] as $hourlyForecast){
		
			// forecast.io temperature
			$forecast_temp_max = $hourlyForecast['temp']['max'];
			$forecast_temp_min = $hourlyForecast['temp']['min'];
			//echo $forecast_temp;
		
			// forecast.io & openweathermap.org time
			$forecast_time_epoch = $hourlyForecast['dt'];
			$dt = new DateTime("@$forecast_time_epoch");
			$forecast_time = date('H:i', $forecast_time_epoch);
			$forecast_date = date('d/m/y', $forecast_time_epoch);
			$forecast_date_long = date('l jS F Y', $forecast_time_epoch);
			
		
			$forecast_icon = $hourlyForecast['weather']['0']['icon'].'.png';
		
			
			//echo '<img src="media/images/weatherIcon/'.$forecast_icon.'" alt="'.$forecast_icon_raw.'">';
		
			// precipitaion probability
			$forecast_precipProb = $hourlyForecast['precipProbability'];
			//echo $forecast_precipProb;
		
			// humidity
			$forecast_humidity = $hourlyForecast['humidity'];
			//echo $forecast_humidity;
		
			$forecast_summary = $hourlyForecast['weather']['0']['main'];
			$forecast_windSpeed = $hourlyForecast['speed'];
			$forecast_windBearing = $hourlyForecast['deg'];
			$forecast_cloudCover = $hourlyForecast['clouds'];
			
			
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
						<th>Summary</th>
						<th>Max Temp</th>
						<th>Min Temp</th>
						<th>Cloud Cover</th>
						<th>Wind<br>Speed</th>
						<th>Humidity</th>
					</tr>	
				<?php
			}
			
			echo '<tr>';
			echo '<td><img src="media/images/weatherIcon/'.$forecast_icon.'" alt="'.$forecast_icon_raw.'" style="width:50px"></td>';
			echo '<td>'.$forecast_date.'</td>';
			echo '<td>'.$forecast_summary.'</td>';
			echo '<td>'.$forecast_temp_max.'</td>';
			echo '<td>'.$forecast_temp_min.'</td>';
			echo '<td>'.$forecast_cloudCover.'</td>';
			echo '<td>'.$forecast_windSpeed.'</td>';
			echo '<td>'.$forecast_humidity.'</td>';
			echo '</tr>';
		}
	?>
	
	</table>
	<br>


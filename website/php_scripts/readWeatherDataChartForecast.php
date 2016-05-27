<?php

	
	$selectedCity = str_replace("%20", " ", $selectedCity);
	$selectedCity = str_replace("+", " ", $selectedCity);

	$delim = strpos($selectedCity, "-");
	
	if($delim > 0 && !isset($selectedState)) {
		$selectedState = substr($selectedCity, $delim + 2);
		$selectedCity = substr($selectedCity, 0, $delim - 1);
	}

	//echo '<p><a href="state.php?s='.$selectedState.'&id='.$sID.'">Return to towns in '.$selectedState.'</a></p>';

	  require dirname(__DIR__).'/php_scripts/sqlSecurity.php';

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
		
		foreach ($stations['observations']['data'] as $station) {
			$latitude = $station['lat'];
			$longitude = $station['lon'];
		}
		$forecast_url = 'https://api.forecast.io/forecast/1f05fbee8b8ba738d4f50f6cc418cdcf/'.$latitude.','.$longitude;
	
		// forecast.io
		$forecast_string = file_get_contents($forecast_url);
		$forecast = json_decode($forecast_string, true);
	
	$numEntries = count($forecast['hourly']['data']) - 1; // calulate num entries
	$halfNumEntries = ($numEntries - $numEntries%2)/2; // calculate half num entries
	
	echo '<br>';
	echo '<br>';
	echo '<p class="title_small">Hourly Forecasts</h3>';
	echo '<p class="center">'.$forecast['hourly']['summary'].'</p>';
	echo '<br>';
	
	// echo links for chart length
	echo '<br>';
	echo "<table style='width:100%; margin:auto;'>";
	echo '<tr>';
	if ($halfNumEntries < 12){
		echo '<td><a href="city_chart.php?c='.$selectedCity.'&s='.$selectedState.'&id='.$id.'&sID='.$sID.'&data='.$data.'&time='.$halfNumEntries.'&type='.$type.'">Show Next '.$halfNumEntries.' Hours</a></td>';
	}
	
	if ($numEntries >= 12){
		echo '<td><a href="city_chart.php?c='.$selectedCity.'&s='.$selectedState.'&id='.$id.'&sID='.$sID.'&data='.$data.'&time=12'.'&type='.$type.'">Show Next 12 Hours</a></td>';
	}
	
	if ($halfNumEntries < 24 && $halfNumEntries > 12){
		echo '<td><a href="city_chart.php?c='.$selectedCity.'&s='.$selectedState.'&id='.$id.'&sID='.$sID.'&data='.$data.'&time='.$halfNumEntries.'&type='.$type.'">Show Next '.$halfNumEntries.' Hours</a></td>';
	}
	
	if ($numEntries >= 24){
		echo '<td><a href="city_chart.php?c='.$selectedCity.'&s='.$selectedState.'&id='.$id.'&sID='.$sID.'&data='.$data.'&time=24'.'&type='.$type.'">Show Next 24 Hours</a></td>';
	}
	
	if ($halfNumEntries > 24){
		echo '<td><a href="city_chart.php?c='.$selectedCity.'&s='.$selectedState.'&id='.$id.'&sID='.$sID.'&data='.$data.'&time='.$halfNumEntries.'&type='.$type.'">Show Next '.$halfNumEntries.' Hours</a></td>';
	}
	echo '<td><a href="city_chart.php?c='.$selectedCity.'&s='.$selectedState.'&id='.$id.'&sID='.$sID.'&data='.$data.'&time='.$numEntries.'&type='.$type.'">Show Next '.$numEntries.' Hours</a></td>';

	echo '</tr>';
	echo '</table>';
	
	if ($time == 0 && $numEntries >= 12){
		$time = 12;
	}
	else if ($time == 0){
		$time = $numEntries;
	}
	
?>
	<br>
<?php
	echo '<br>';
   echo '<p class="title_small">'.$data.' - Next '.$time.' Hours</p>'; // echo info about rain
?>
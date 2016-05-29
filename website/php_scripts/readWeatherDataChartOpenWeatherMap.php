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
	// get bom links from database
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
	// get data from bom website
	$string = file_get_contents($url);
	$stations = json_decode($string, true);
	
	// get latitude and longitude from bom website
	foreach ($stations['observations']['data'] as $station) {
		$latitude = $station['lat'];
		$longitude = $station['lon'];
	}
	
	// using lat and long get link for forecast data
	$forecast_url = 'http://api.openweathermap.org/data/2.5/forecast/daily?lat='.$latitude.'&lon='.$longitude.'&units=metric&appid=2d597f8d44eb76f4cecc1e09759fb148&cnt=16';

	// forecast.io used for timezone
	$forecast_string = file_get_contents($forecast_url);
	$forecast = json_decode($forecast_string, true);
	
	$numEntries = count($forecast['list']) - 1; // calulate num entries
	$halfNumEntries = ($numEntries - $numEntries%2)/2; // calculate half num entries
	
	echo '<br>';
	echo '<br>';
	echo '<p class="title_small">Hourly Forecasts</h3>';
	echo '<br>';
	
	// echo links for chart length
	echo '<br>';
	echo "<table style='width:100%; margin:auto;'>";
	echo '<tr>';
	if ($halfNumEntries < 12){
		echo '<td><a href="city_chart.php?c='.$selectedCity.'&s='.$selectedState.'&id='.$id.'&sID='.$sID.'&data='.$data.'&time='.$halfNumEntries.'&type='.$type.'">Show Next '.$halfNumEntries.' Days</a></td>';
	}
	
	if ($numEntries >= 12){
		echo '<td><a href="city_chart.php?c='.$selectedCity.'&s='.$selectedState.'&id='.$id.'&sID='.$sID.'&data='.$data.'&time=12'.'&type='.$type.'">Show Next 12 Days</a></td>';
	}
	
	if ($halfNumEntries < 24 && $halfNumEntries > 12){
		echo '<td><a href="city_chart.php?c='.$selectedCity.'&s='.$selectedState.'&id='.$id.'&sID='.$sID.'&data='.$data.'&time='.$halfNumEntries.'&type='.$type.'">Show Next '.$halfNumEntries.' Days</a></td>';
	}
	
	if ($numEntries >= 24){
		echo '<td><a href="city_chart.php?c='.$selectedCity.'&s='.$selectedState.'&id='.$id.'&sID='.$sID.'&data='.$data.'&time=24'.'&type='.$type.'">Show Next 24 Days</a></td>';
	}
	
	if ($halfNumEntries > 24){
		echo '<td><a href="city_chart.php?c='.$selectedCity.'&s='.$selectedState.'&id='.$id.'&sID='.$sID.'&data='.$data.'&time='.$halfNumEntries.'&type='.$type.'">Show Next '.$halfNumEntries.' Days</a></td>';
	}
	echo '<td><a href="city_chart.php?c='.$selectedCity.'&s='.$selectedState.'&id='.$id.'&sID='.$sID.'&data='.$data.'&time='.$numEntries.'&type='.$type.'">Show Next '.$numEntries.' Days</a></td>';

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
   echo '<p class="title_small">'.$data.' - Next '.$time.' Days</p>'; 
?>
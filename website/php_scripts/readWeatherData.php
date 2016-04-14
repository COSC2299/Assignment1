<?php //include 'search.php'; ?>
<br>
<br>
<p><a href="all_states.php">Return to States</a></p>
<?php

	require dirname(__DIR__).'/php_scripts/sqlSecurity.php';


	$selectedCity = str_replace("%20", " ", $selectedCity);
	$selectedCity = str_replace("+", " ", $selectedCity);

	$delim = strpos($selectedCity, "-");
	
	if($delim > 0 && !isset($selectedState)) {
		$selectedState = substr($selectedCity, $delim + 2);
		$selectedCity = substr($selectedCity, 0, $delim - 1);
	}
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

	echo '<p><a href="state.php?s='.$selectedState.'&id='.$sID.'">Return to stations in '.$selectedState.'</a></p>';
	
	echo '<br>';
	echo '<br>';
?>
	<p><a href="#" onclick="window.open('<?php echo 'city_chart.php?c='.$selectedCity.'&s='.$selectedState.'&id='.$id.'&sID='.$sID.'&type=Temperature&time=12';?>', 'chartWindow', 'width=1300, height=1000'); return false;">Display Charts</a></p>
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
	foreach ($stations['observations']['data'] as $station) {
		echo '<tr>';
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

?>
</table>
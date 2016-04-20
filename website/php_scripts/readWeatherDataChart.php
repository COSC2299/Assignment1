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
	
	$numEntries = count($stations['observations']['data']) - 1;
	$halfNumEntries = ($numEntries - $numEntries%2)/2;
	
	echo '<br>';
	
	if ($halfNumEntries < 12){
		echo '<p><a href="city_chart.php?c='.$selectedCity.'&s='.$selectedState.'&id='.$id.'&sID='.$sID.'&type='.$type.'&time='.$halfNumEntries.'">Show Past '.$halfNumEntries.' Entries</a></p>';
	}
	
	if ($numEntries >= 12){
		echo '<p><a href="city_chart.php?c='.$selectedCity.'&s='.$selectedState.'&id='.$id.'&sID='.$sID.'&type='.$type.'&time=12">Show Past 12 Entries</a></p>';
	}
	
	if ($halfNumEntries < 24 && $halfNumEntries > 12){
		echo '<p><a href="city_chart.php?c='.$selectedCity.'&s='.$selectedState.'&id='.$id.'&sID='.$sID.'&type='.$type.'&time='.$halfNumEntries.'">Show Past '.$halfNumEntries.' Entries</a></p>';
	}
	
	if ($numEntries >= 24){
		echo '<p><a href="city_chart.php?c='.$selectedCity.'&s='.$selectedState.'&id='.$id.'&sID='.$sID.'&type='.$type.'&time=24">Show Past 24 Entries</a></p>';
	}
	
	if ($halfNumEntries > 24){
		echo '<p><a href="city_chart.php?c='.$selectedCity.'&s='.$selectedState.'&id='.$id.'&sID='.$sID.'&type='.$type.'&time='.$halfNumEntries.'">Show Past '.$halfNumEntries.' Entries</a></p>';
	}
	echo '<p><a href="city_chart.php?c='.$selectedCity.'&s='.$selectedState.'&id='.$id.'&sID='.$sID.'&type='.$type.'&time='.$numEntries.'">Show All '.$numEntries.' Entries</a></p>';
?>
	<br>
	<br>

<?php
	/*
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
		echo '</tr>';

	}
	*/
?>


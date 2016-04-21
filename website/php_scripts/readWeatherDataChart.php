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
	echo "<table border='0' style='width:100%; margin:auto;'>";
	echo '<tr>';
	if ($halfNumEntries < 12){
		echo '<td><a href="city_chart.php?c='.$selectedCity.'&s='.$selectedState.'&id='.$id.'&sID='.$sID.'&type='.$type.'&time='.$halfNumEntries.'">Show Past '.$halfNumEntries.' Entries</a></td>';
	}
	
	if ($numEntries >= 12){
		echo '<td><a href="city_chart.php?c='.$selectedCity.'&s='.$selectedState.'&id='.$id.'&sID='.$sID.'&type='.$type.'&time=12">Show Past 12 Entries</a></td>';
	}
	
	if ($halfNumEntries < 24 && $halfNumEntries > 12){
		echo '<td><a href="city_chart.php?c='.$selectedCity.'&s='.$selectedState.'&id='.$id.'&sID='.$sID.'&type='.$type.'&time='.$halfNumEntries.'">Show Past '.$halfNumEntries.' Entries</a></td>';
	}
	
	if ($numEntries >= 24){
		echo '<td><a href="city_chart.php?c='.$selectedCity.'&s='.$selectedState.'&id='.$id.'&sID='.$sID.'&type='.$type.'&time=24">Show Past 24 Entries</a></td>';
	}
	
	if ($halfNumEntries > 24){
		echo '<td><a href="city_chart.php?c='.$selectedCity.'&s='.$selectedState.'&id='.$id.'&sID='.$sID.'&type='.$type.'&time='.$halfNumEntries.'">Show Past '.$halfNumEntries.' Entries</a></td>';
	}
	echo '<td><a href="city_chart.php?c='.$selectedCity.'&s='.$selectedState.'&id='.$id.'&sID='.$sID.'&type='.$type.'&time='.$numEntries.'">Show Past '.$numEntries.' Entries</a></td>';

	echo '</tr>';
	echo '</table>';
?>

	<br>
	<br>
<?php
	echo '<br>';
   echo '<p class="title_small">'.$type.' - Past '.$time.' Entries</p>';
	if ($type == 'Rain Fall Since 9am'){
   	echo '<p class="center">Please note rain data resets at 9:00am</p>';
      echo '<br>';
   }
   if ($type == 'Wind Speed' || $type == 'Gust Speed'){
      echo '<p><a href="city_chart.php?c='.$selectedCity.'&s='.$selectedState.'&id='.$id.'&sID='.$sID.'&type=Wind%20Speed&time='.$time.'">Wind Speed</a></p>';
    	echo '<p><a href="city_chart.php?c='.$selectedCity.'&s='.$selectedState.'&id='.$id.'&sID='.$sID.'&type=Gust%20Speed&time='.$time.'">Gust Speed</a></p>';
   }


<?php //include 'search.php'; ?>
<a href="index.php">States</a><br/>
<?php

	
	$selectedCity = str_replace("%20", " ", $selectedCity);
	$selectedCity = str_replace("+", " ", $selectedCity);

	$delim = strpos($selectedCity, "-");
	
	if($delim > 0 && !isset($selectedState)) {
		$selectedState = substr($selectedCity, $delim + 2);
		$selectedCity = substr($selectedCity, 0, $delim - 1);
	}

	echo '<a href="state.php?s='.$selectedState.'">'.$selectedState.'</a><br/>';
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


	  require 'php_scripts/sqlSecurity.php';

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

	echo '<strong>'.$stations['observations']['data'][0]['name'].'</strong>';
	echo '<br />';

?>

<table>
	<tr>
		<th>Date</th>
		<th>Time</th>
		<th>Temperature</th>
		<th>Cloud</th>
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
		echo '</tr>';

	}

?>
</table>
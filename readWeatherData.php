<a href="listStates.php">States</a><br/>
<?php

	$selectedState = $_GET['s'];
	$selectedCity = $_GET['c'];
	$selectedCity = str_replace("%20", " ", $selectedCity);

	echo '<a href="listCitiesForState.php?s='.$selectedState.'">'.$selectedState.'</a><br/>';

	$states = json_decode(file_get_contents('stations.json'), true);

	$url = "";

	foreach ($states as $state) {
		if($state['state'] == $selectedState)
		{
			//echo $selectedState.'<br />';
		//	print_r($state);
			foreach ($state['stations'] as $city) {
					//print_r($city);
					if($city['city'] == $selectedCity) {
						
						$url = $city['url'];
					}

				}	
		}

	}

	$string = file_get_contents($url);
	$stations = json_decode($string, true);

	printf($stations['observations']['data'][0]['name']);
	echo '<br />';

	foreach ($stations['observations']['data'] as $station) {
		# code...
		//print_r($station);
		$date = $station['local_date_time_full'];
		$year = substr($date, 0, 4);
		$month = substr($date, 4, 2);
		$day = substr($date, 6, 2);
		$hour = substr($date, 8, 2);
		$minute = substr($date, 10, 2);
		echo 'Date: '.$day.'/'.$month.'/'.$year.', ';
		echo 'Time: '.$hour.':'.$minute.', ';
		echo 'Temp: '.$station['apparent_t'].', ';
		echo 'Cloud: '.$station['cloud'].'<br />';

	}
	//printf($stations['observations']['data'][0]['apparent_t']);
	//printf($stations['observations']['data'][0]['cloud']);
	//printf($stations['observations']['data'][0]['apparent_t']);
	//printf($stations['observations']['data'][0]['apparent_t']);



?>
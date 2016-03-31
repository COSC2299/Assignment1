<a href="listStates.php">States</a><br/>
<?php
	$string = file_get_contents('stations.json');
	$stations = json_decode($string, true);

	//print_r($stations);

	foreach ($stations as $state) {
		# code...
		echo '<strong>'.$state['state'].'</strong><br/>';

		foreach ($state['stations'] as $city) {
			# code...
			echo '<a href="readWeatherData.php?s='.$state['state'].'&c='.$city['city'].'">';
			echo $city['city'].'</a><br/>';
		}
	}

?>
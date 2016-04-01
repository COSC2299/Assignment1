
<?php
	$string = file_get_contents('stations.json');
	$stations = json_decode($string, true);

	//print_r($stations);

	foreach ($stations as $state) {
		# code...
		

		foreach ($state['stations'] as $city) {
			# code...
			
			echo '"'.$city['city'].' - '.$state['state'].'",';
		}
	}

?>
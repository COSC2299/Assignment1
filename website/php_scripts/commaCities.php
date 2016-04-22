
<?php
	$string = file_get_contents(dirname(__DIR__).'/php_scripts/stations.json');
	$stations = json_decode($string, true); // get stations from json files

	foreach ($stations as $state) {
		foreach ($state['stations'] as $city) {
			echo '"'.$city['city'].' - '.$state['state'].'",';
		}
	}

?>
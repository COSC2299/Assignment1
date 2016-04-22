<a href="index.php">States</a><br/>
<?php
	$string = file_get_contents(dirname(__DIR__).'/php_scripts/stations.json'); // get stations from json file
	$stations = json_decode($string, true);

	//print_r($stations);
	//$selectedState = $_GET['s'];

	echo '<strong>'.$selectedState.'</strong><br/>';
	foreach ($stations as $state) {
		# code...
		if($state['state'] == $selectedState)
		{
			foreach ($state['stations'] as $city) {
				# code...
				echo '<a href="city.php?s='.$state['state'].'&c='.$city['city'].'">';
				echo $city['city'].'</a><br/>';
			}
		}
	}

?>
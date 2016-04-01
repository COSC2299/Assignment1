<?php include 'search.php'; ?>
<?php
	$string = file_get_contents(dirname(__DIR__).'/php_scripts/stations.json');
	$stations = json_decode($string, true);

	//print_r($stations);

	foreach ($stations as $state) {
		# code...
		echo '<a href="state.php?s='.$state['state'].'">'.$state['state'].'</a><br/>';

	}

?>
<a href="listCities.php">All Cities</a>
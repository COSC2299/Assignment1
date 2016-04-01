<?php include 'header.php'; ?>
<?php include 'search.php'; ?>
<a href="listStates.php">States</a><br/>
<?php
	$string = file_get_contents('stations.json');
	$stations = json_decode($string, true);

	//print_r($stations);
	$selectedState = $_GET['s'];

	echo '<strong>'.$selectedState.'</strong><br/>';
	foreach ($stations as $state) {
		# code...
		if($state['state'] == $selectedState)
		{
			foreach ($state['stations'] as $city) {
				# code...
				echo '<a href="readWeatherData.php?s='.$state['state'].'&c='.$city['city'].'">';
				echo $city['city'].'</a><br/>';
			}
		}
	}

?>
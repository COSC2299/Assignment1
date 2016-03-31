<?php
	$string = file_get_contents('stations.json');
	$stations = json_decode($string);

	print_r($stations[0]);

?>
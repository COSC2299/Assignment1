<?php //include 'search.php'; ?>
<?php
/* 
	include '/apachelog/Logger.php';

	Logger::configure('/apachelog/config.xml');
	
	$log = Logger::getLogger("myLogger"); 

	// Start logging
	$log->trace("My first message.");   // Not logged because TRACE < WARN
	$log->debug("My second message.");  // Not logged because DEBUG < WARN
	$log->info("My third message.");    // Not logged because INFO < WARN
	$log->warn("My fourth message.");   // Logged because WARN >= WARN
	$log->error("My fifth message.");   // Logged because ERROR >= WARN
	$log->fatal("My sixth message.");   // Logged because FATAL >= WARN 
	*/
?>


<?php


	
	require dirname(__DIR__).'/php_scripts/sqlSecurity.php';
	
	//replace space for url
	$stateURL = str_replace(" ", "%20", $selectedState);
	$cityURL = str_replace(" ", "%20", $selectedCity);
	echo '<br>';
	echo '<p class="title_large">' . $selectedCity . '</p>';
	echo '<p class="title_medium">' . $selectedState . '</p>';
	if ($type == 'forecast'){
		echo '<p class="center"><a href="http://forecast.io">forecast.io</a></p>';
	}
	else if ($type == 'openWeatherMap'){
		echo '<p class="center"><a href="http://openweathermap.org">openweathermap.org</a></p>';
	}
	else{
		echo '<p class="center"><a href="http://bom.gov.au">bom.gov.au</a></p>';
	}
?>

	<p><a href="#" onclick="location.reload()">Refresh</a></p>

<?php
	$favList = array();
	$favList = json_decode($_COOKIE['favourites'], true); // get current list of favourites

	$j = count($favList); // count how many favourites exist
	//echo $j;

	$exists = false;
	for ($i=0; $i < $j ; $i++) {  // check if favourite already exists
		if($id == $favList[$i]['id']){
			$exists = true;
			$favID = $i;
		}
	}
	if(!$exists) // if it doesn't exist, add to array
	{
?>
		<p><a href="#" onclick="fav('<?php echo str_replace("'", "&#146;", $selectedCity); ?>', '<?php echo $selectedState ?>', '<?php echo $id ?>')">Favourite This Station</a></p>
<?php
	}
	else{
		echo '<p><a href="#" onclick="clearFav('.$favID.')">Unfavourite This Station</a></p>'; // create unfavourite button
	}
	echo '<br>';
?>



<?php
   echo '<p><a href="all_states.php">Return to States</a></p>';
	echo '<p><a href="state.php?s='.$stateURL.'&id='.$sID.'">Return to Stations in '.$selectedState.'</a></p>';
	
	echo '<br>';
	
	if ($type == 'forecast'){
		$newURL = basename($_SERVER['PHP_SELF']) . '?c=' . str_replace(" ", "%20", $selectedCity) . '&s=' . $selectedState . '&id=' . $id . '&type=historical';
		$newURL2 = basename($_SERVER['PHP_SELF']) . '?c=' . str_replace(" ", "%20", $selectedCity) . '&s=' . $selectedState . '&id=' . $id . '&type=openWeatherMap';
		echo '<p><a href="' . $newURL . '">View Historical Data</a></p>';
		echo '<p><a href="' . $newURL2 . '">View Forecast Data from OpenWeatherMap.org</a></p>';
		echo '<p><a href="#" onclick="displayChartForecast()">Display Charts for Forecast Data</a></p>';
	}
	else if ($type == 'openWeatherMap'){
		$newURL = basename($_SERVER['PHP_SELF']) . '?c=' . str_replace(" ", "%20", $selectedCity) . '&s=' . $selectedState . '&id=' . $id . '&type=historical';
		$newURL2 = basename($_SERVER['PHP_SELF']) . '?c=' . str_replace(" ", "%20", $selectedCity) . '&s=' . $selectedState . '&id=' . $id . '&type=forecast';
		echo '<p><a href="' . $newURL . '">View Historical Data</a></p>';
		echo '<p><a href="' . $newURL2 . '">View Forecast Data from forecast.io</a></p>';
		echo '<p><a href="#" onclick="displayChartOpenWeatherMap()">Display Charts for Forecast Data</a></p>';
	}
	else{
		$newURL = basename($_SERVER['PHP_SELF']) . '?c=' . str_replace(" ", "%20", $selectedCity) . '&s=' . $selectedState . '&id=' . $id . '&type=forecast';
		echo '<p><a href="' . $newURL . '">View Forecast</a></p>';
		echo '<p><a href="#" onclick="displayChartHistorical()">Display Charts for Historical Data</a></p>';
	}
	
	if(isset($id))
	{
		try{
		        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		                                   // set the PDO error mode to excepti
		        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		        $sql = 'SELECT url FROM city WHERE id = '.$id;
	 			$log->logInfo('SQL QUERY - '.$sql);
	 			$results = 0;
		           foreach ($conn->query($sql) as $row) {
		               $url = $row['url'];
		               $results++;
		           }
		        $log->logInfo('RESULT COUNT - '.$results);
		      }
		   	
		   	catch(PDOException $e)
		     	{
		         echo $sql . "<br/>" . $e->getMessage();
		     }
		              

		$inFav = false;

		foreach($_SESSION['favourites'] as $fav){
			if ($fav['id'] == $id) {
				
				$inFav = true;

			}
		}

		if($inFav)
		{
			 $sql = 'SELECT * FROM weatherdata WHERE city_id = '.$id.' ORDER BY t_datetime DESC';
			 $log->logInfo('SQL QUERY - '.$sql);

		           $i = 0;
		           foreach ($conn->query($sql) as $row) {
		               $stationsSQL['observations']['data'][$i]['air_temp'] = $row['temp'];

		               $date = strtotime($row['t_datetime']);
		               $date = date('YmdHi', $date);
		               $stationsSQL['observations']['data'][$i]['local_date_time_full'] = $date;//20160421100000
		         
		         		//echo $date;

		               $i++;

		           }
		           $log->logInfo('RESULT COUNT - '.$i);

		}

			
			$string = file_get_contents($url);
			$stations = json_decode($string, true);
		

		//$string = file_get_contents($url);
		//$stations = json_decode($string, true);

		//echo '<strong>'.$stations['observations']['data'][0]['name'].'</strong>';
		echo '<br>';
		
		if ($type == 'forecast'){
			include 'readWeatherDataForecast.php';
		}
		else if ($type == 'openWeatherMap'){
			include 'readWeatherDataOpenWeatherMap.php';
		}
		else{
			include 'readWeatherDataHistorical.php';
		}
		
		echo '<br>';
		
	}//end if for ID Set
?>
<?php
	//Fix format for selected city from GET
	$selectedCity = str_replace("%20", " ", $selectedCity);
	$selectedCity = str_replace("+", " ", $selectedCity);


	//If state passed through in same var as City, separate out based on delimeter of "-"
	$delim = strpos($selectedCity, "-");
	if($delim > 0 && !isset($selectedState)) {
		$selectedState = substr($selectedCity, $delim + 2);
		$selectedCity = substr($selectedCity, 0, $delim - 1);
	}

	//If there is no id for the city, search the db using the city name
	if(!isset($id) && isset($selectedState))
	{
		require 'php_scripts/sqlSecurity.php';
		try{
	        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
	                                   // set the PDO error mode to excepti
	        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	        $sql = 'SELECT id FROM city WHERE name = "'.$selectedCity.'"';

	           
	           foreach ($conn->query($sql) as $row) {
	               $id = $row['id'];
	           }
	           

	      }
	      catch(PDOException $e)
	     {
	         echo $sql . "<br/>" . $e->getMessage();
	     }

	}
?>
				
	<?php
		if (!isset($id)){ // if id is not set, it is a search query.
			$string = file_get_contents(dirname(__DIR__).'/php_scripts/stations.json');
			$stations = json_decode($string, true);
			
			require 'php_scripts/sqlSecurity.php';
			echo '<br>';
			echo '<p class="title_large">Search results for "' . $selectedCity . '"</p>';
			echo '<br>';
			echo '<br>';

			try{
				$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
								  // set the PDO error mode to excepti
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

				$sql = 'SELECT * FROM city WHERE name LIKE "%'.$selectedCity.'%"';

				$stateStack = array(); 
				foreach ($conn->query($sql) as $row) {
					foreach ($stations as $state) {
						foreach ($state['stations'] as $city) {
							$stateVal = $city['city'].' - '.$state['state'];
							if ($city['city'] == $row['name'] && !in_array($stateVal, $stateStack)){ // if name = city, and not in array, then echo result
								echo '<div class="search_item">';
								echo '<p><a href="city.php?c='.$city['city'].'&s='.$state['state'].'">'.$city['city'].' - '.$state['state'].'</a></p>';
								echo '</div>';
								array_push($stateStack, $stateVal); // add to array
							}
						}
					}
				}
				if (empty($stateStack)){ // if no results, (array empty), echo msg
					echo '<p class="center">No results for "'.$selectedCity.'"</p>';
				}
			}
			catch(PDOException $e)
			{
				echo $sql . "<br/>" . $e->getMessage();
			}
			//print_r($stateStack);
			echo '<div class="mainList"></div>';
			echo '<br>';
			echo '<br>';
		}
		else{ // else if id is set, cont.
			include 'php_scripts/readWeatherData.php'; 
		}
	?>
 
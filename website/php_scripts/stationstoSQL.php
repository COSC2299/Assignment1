<?php


	$string = file_get_contents(dirname(__DIR__).'/php_scripts/stations.json');
	$stations = json_decode($string, true);
	$servername = "localhost";
	$username = "root";
	$password = "root";
	$dbname = "sept";

	try {
	    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
	    // set the PDO error mode to exception
	    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	    
		foreach ($stations as $state) {
		
			$sql = "INSERT INTO state (name) VALUES (:name)";

			echo $sql.'<br/>';
		    
		    $sth = $conn->prepare($sql);

		    $sth->execute(array(':name' => $state['state']));

		    $lastId = $conn->lastInsertId();

			foreach ($state['stations'] as $city) {
				
				$cSql = "INSERT INTO city (name, state_id, url) VALUES (:name, :id, :url)";

				$stm = $conn->prepare($cSql);

				echo $cSql.'<br/>';

		    	$stm->execute(array(':name' => $city['city'],
		    						':id' => $lastId,
		    						':url' => $city['url']));
				
			}
		}

    }
	catch(PDOException $e)
	{
	    echo $sql . "<br/>" . $e->getMessage();
	}


?>
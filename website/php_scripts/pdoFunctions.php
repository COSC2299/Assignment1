<?php


//echo printStates();
	function connect()
	{
		$servername = "localhost";
		$username = "root";
		$password = "root";
		$dbname = "sept";

		try{
			$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
						                    // set the PDO error mode to excepti
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		 catch(PDOException $e)
		{
		    echo $sql . "<br/>" . $e->getMessage();
		}
	}

    function printStates() 
    {
    	$string = '';
    	
	    	connect();
		    	
	        $sql = 'SELECT name, id FROM state ORDER BY name';

	        $string .= '<ul class="mainList">';
	        foreach ($conn->query($sql) as $row) {
	            $string .= '<li><a href="state.php?s='.$row['name'].'">'.$row['name'].'</a></li>';
	        }
	        $string .= '</ul>';
	    
    
		return $string;
	}


?>
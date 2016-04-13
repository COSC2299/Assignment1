<?php// include 'search.php'; ?>

<p><a href="all_states.php">Return to States</a></p>
<br>
<?php

  require 'php_scripts/sqlSecurity.php';

  try{
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                                   // set the PDO error mode to excepti
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		  
		  if ($sID == 0){
		  
		  		$state_name = array("Antarctica", "Canberra", "New South Wales", "Northern Territory", "Queensland",
		  		"South Australia", "Tasmania", "Victoria", "Western Australia");
		  		
		  		for ($sID=24; $sID <= 32; $sID++){
		  			
		  			$sql = 'SELECT name, id FROM city WHERE state_id = '.$sID.' ORDER BY name';
					
					echo '<div class="center"><h2><strong>' . $state_name[$sID - 24] . '</strong></h2></div>';
						
					echo '<div class="mainList">';				
           		foreach ($conn->query($sql) as $row) {
               	echo '<div class="menu_item"><a href="city.php?c='.$row['name'].'&s='.$state_name[$sID - 24].'&id='.$row['id'].'&sID='.$sID.'">'.$row['name'].'</a></div>';
           		}
           		echo '</div>';
           		echo '<br>';
           		echo '<br>';
		  		} 
		  }
		  
        $sql = 'SELECT name, id FROM city WHERE state_id = '.$sID.' ORDER BY name';

           echo '<div class="mainList">';
           foreach ($conn->query($sql) as $row) {
               echo '<div class="menu_item"><a href="city.php?c='.$row['name'].'&s='.$selectedState.'&id='.$row['id'].'">'.$row['name'].'</a></div>';
           }
           echo '</div>';

      }
      catch(PDOException $e)
     {
         echo $sql . "<br/>" . $e->getMessage();
     }
                     

?>
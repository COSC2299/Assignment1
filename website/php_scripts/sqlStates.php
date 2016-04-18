<?php

  
  require dirname(__DIR__).'/php_scripts/sqlSecurity.php';
  
  try{
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                                   // set the PDO error mode to excepti
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = 'SELECT name, id FROM state ORDER BY name';

           echo '<div class="mainList">';
           foreach ($conn->query($sql) as $row) {
                //replace space for url
               $stateURL = str_replace(" ", "%20", $row['name']);
               echo '<div class="menu_item"><a href="state.php?s='.$stateURL.'&id='.$row['id'].'">'.$row['name'].'</a></div>';
           }
           echo '</div>';

      }
      catch(PDOException $e)
     {
         echo $sql . "<br/>" . $e->getMessage();
     }
                 

?>
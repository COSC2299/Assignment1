<?php

  require 'php_scripts/sqlSecurity.php';

  try{
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                                   // set the PDO error mode to excepti
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = 'SELECT name, id FROM weatherdata ORDER BY name';

           echo '<ul class="mainList">';
           foreach ($conn->query($sql) as $row) {
                $state = $row['name'];
                //replace space for url
                $state = str_replace(" ", "%20", $state);
               echo '<li><a href="state.php?s='.$state.'&id='.$row['id'].'">'.$row['name'].'</a></li>';
           }
           echo '</ul>';

      }
      catch(PDOException $e)
     {
         echo $sql . "<br/>" . $e->getMessage();
     }
                     

?>
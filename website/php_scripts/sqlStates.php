<?php

  $servername = "localhost";
  $username = "root";
  $password = "root";
  $dbname = "sept";

  try{
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                                   // set the PDO error mode to excepti
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = 'SELECT name, id FROM state ORDER BY name';

           echo '<ul class="mainList">';
           foreach ($conn->query($sql) as $row) {
               echo '<li><a href="state.php?s='.$row['name'].'&id='.$row['id'].'">'.$row['name'].'</a></li>';
           }
           echo '</ul>';

      }
      catch(PDOException $e)
     {
         echo $sql . "<br/>" . $e->getMessage();
     }
                     

?>
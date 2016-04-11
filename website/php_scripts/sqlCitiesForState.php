<?php// include 'search.php'; ?>

<a href="index.php">States</a><br/>
<?php
  echo '<strong>'.$selectedState.'</strong><br/>';

  require 'php_scripts/sqlSecurity.php';

  try{
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                                   // set the PDO error mode to excepti
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = 'SELECT name, id FROM city WHERE state_id = '.$sID.' ORDER BY name';

           echo '<ul class="mainList">';
           foreach ($conn->query($sql) as $row) {
               echo '<li><a href="city.php?c='.$row['name'].'&s='.$selectedState.'&id='.$row['id'].'">'.$row['name'].'</a></li>';
           }
           echo '</ul>';

      }
      catch(PDOException $e)
     {
         echo $sql . "<br/>" . $e->getMessage();
     }
                     

?>
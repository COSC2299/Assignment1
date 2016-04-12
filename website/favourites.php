<?php
   session_start();
?>

<!doctype html>

<html>  
<head>
   <title>Weather Station</title>
   <link rel="stylesheet" type="text/css" href="css/pages/index_style.css">
   <?php require 'page_format/main/head.php';?>
</head>
   
   <body>
      <?php include 'page_format/main/attention_bar.php';?>
      <?php require 'page_format/main/header.php';?>
      <?php require 'page_format/main/navigation_bar.php';?>

      <div id="main_body">
         <?php require 'page_format/main/sidebar.php';?>  
         <div id="main_content">
            <div id="main_content_text">
               <h1>Favourites</h1>
               <?php
                  $favs = $_SESSION['favourites'];
                  for ($i=0; $i < count($favs); $i++) { 
                     echo '<p><a href="city.php?c='.$favs[$i]['city'].'&s='.$favs[$i]['state'].'&id='.$favs[$i]['id'].'">'.$favs[$i]['city'].', '.$favs[$i]['state'].'</a></p>';
                  }
               ?>  
               <br>
               <button onclick="clearFav()">Remove All Favourites</button>
            </div>
            <br/>
            <br/>
            <br/>
            <br/>
         </div> 
      </div>
      <?php require 'page_format/main/footer.php';?>
   </body>

</html>

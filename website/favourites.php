<?php
   session_start();
?>

<!doctype html>

<html>  
<head>
   <title>Weather Station</title>
   <?php require 'page_format/main/head.php';?>
   <script type="text/javascript">
   	function clearFav($favID) {
   		$url = "php_scripts/clearFavourites.php?favID=" + $favID;
   		console.log($url);
      	$.post( $url,{}, function( data ) {        
            location.reload();
         });
      }
   </script>
   <script type="text/javascript">
   	function clearFavourites($favID){
   		console.log($favID);
   	}
   </script>
</head>
   
   <body>
      <?php include 'page_format/main/attention_bar.php';?>
      <?php require 'page_format/main/header.php';?>
      <?php require 'page_format/main/navigation_bar.php';?>

      <div id="main_body">
         <?php require 'page_format/main/sidebar.php';?>  
         <div id="main_content">
            <div id="main_content_text">
               <h1>My Favourites</h1>
               <?php
                  $favs = $_SESSION['favourites'];
                  for ($i=0; $i < count($favs); $i++) { 
                     echo '<p><a href="city.php?c='.$favs[$i]['city'].'&s='.$favs[$i]['state'].'&id='.$favs[$i]['id'].'">'.$favs[$i]['city'].', '.$favs[$i]['state'].'</a></p>';
                  }
                  if (count($favs) == 0){
                  	echo '<p>You currently do not have any favourites</p>';
                  }
                  else{
                  	echo '<br>';
                  	echo '<button onclick="clearFav(-1)">Remove All Favourites</button>';
                  }
               ?>  
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

<?php
   session_start();
?>

<?php require 'php_scripts/session_check.php'; ?>

<!doctype html>

<html>  
<head>
   <title>Weather Station - <?php echo $_GET['c'];?></title>
   <?php require 'page_format/main/head.php';?>
   <script type="text/javascript">
   	function fav(city, state, id) {
         $.post( "php_scripts/favourite.php",{city:city, state:state, id:id}, function( data ) {
            console.log(data);
            location.reload();
         });
      }
   	function clearFav($favID) { // function to remove favourites
   		$url = "php_scripts/clearFavourites.php?favID=" + $favID;
   		console.log($url);
      	$.post( $url,{}, function( data ) {  // post to clearFavourites php script
      		console.log(data);      
            location.reload(); // reload page after adding favourite
         });
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
               <?php 
                     $selectedState = $_GET['s'];
                     $selectedCity = $_GET['c'];
                     $id = $_GET['id'];
                     $sID = $_GET['sID'];
             	?>
               <?php
                  include 'php_scripts/readWeatherData.php'; 
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

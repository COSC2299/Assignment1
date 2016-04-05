<?php
   session_start();
?>

<!doctype html>

<html>  
<head>
   <title>Weather Station</title>
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
               <?php 
                     $selectedState = $_GET['s'];
                     $selectedCity = $_GET['c'];
               ?>
               <h1><?php echo $selectedCity;?></h1>
               <button onclick="fav('<?php echo $selectedCity; ?>', '<?php echo $selectedState ?>')">Favourite</button>
               <?php
                     include 'php_scripts/readWeatherData.php'; 

                  ?>
            </div>
            <br>
            <br>
            <br>
            <br>
         </div> 
      </div>
      <?php require 'page_format/main/footer.php';?>

      <script type="text/javascript">
         function fav(city, state) {
            $.post( "php_scripts/favourite.php",{city:city, state:state}, function( data ) {
             
              console.log(data);
              $('#favList').append('<li><a href="city.php?c=' + city +'&s=' + state + '">' + city + ', ' + state + '</a></li>');
            });
         }
      </script>
   </body>

</html>

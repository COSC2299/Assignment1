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
            <br/>
            <br/>
            <br/>
            <div id="home_info">
               <?php 
                     $selectedState = $_GET['s'];
                     $selectedCity = $_GET['c'];
                     $id = $_GET['id'];
               ?>
               <button onclick="fav('<?php echo $selectedCity; ?>', '<?php echo $selectedState ?>', '<?php echo $id ?>')">Favourite</button>
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

      <script type="text/javascript">
         function fav(city, state, id) {
            $.post( "php_scripts/favourite.php",{city:city, state:state, id:id}, function( data ) {
             
              console.log(data);
              $('#favList').append('<li><a href="city.php?c=' + city +'&s=' + state + '&id=' + id + '">' + city + ', ' + state + '</a></li>');
            });
         }
      </script>
   </body>

</html>

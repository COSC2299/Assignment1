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
               <?php 
                     $selectedState = $_GET['s'];
                     $selectedCity = $_GET['c'];
                     $id = $_GET['id'];
                     $sID = $_GET['sID'];
                     echo '<h1>' . $selectedCity . ' - ' . $selectedState . '</h1>';
               ?>
               <button onclick="fav('<?php echo $selectedCity; ?>', '<?php echo $selectedState ?>', '<?php echo $id ?>')">Favourite This Town</button>
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
              location.reload();
            });
         }
      </script>
   </body>

</html>

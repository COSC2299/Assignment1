<?php
   session_start();
?>

<!doctype html>

<html>  
<head>
   <title>Weather Station - <?php echo $_GET['c'];?></title>
   <?php require 'page_format/main/head.php';?>
</head>
   
   <body>
      <?php include 'page_format/main/attention_bar.php';?>
      <?php require 'page_format/main/header.php';?>

      <div id="main_body_chart">  
         <div id="main_content_chart">
            <div id="main_content_text">
               <?php 
                     $selectedState = $_GET['s'];
                     $selectedCity = $_GET['c'];
                     $id = $_GET['id'];
                     $sID = $_GET['sID'];
                     echo '<h1>' . $selectedCity . ' - ' . $selectedState . '</h1>';
                     echo '<h2>Charts</h2>';
               ?>
               <button onclick="fav('<?php echo $selectedCity; ?>', '<?php echo $selectedState ?>', '<?php echo $id ?>'); location.reload();">Favourite This Town</button>
               <?php
                  include 'php_scripts/readWeatherDataChart.php'; 
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

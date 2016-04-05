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
                     //echo $state;
                     //dirname(__DIR__).'/
                     echo '<h1>Search Cities - ' . $selectedState . '</h1>';
                     include 'php_scripts/listCitiesForState.php'; 
                  ?>
            </div>
            <br>
            <br>
            <br>
            <br>
         </div> 
      </div>
      <?php require 'page_format/main/footer.php';?>
   </body>

</html>

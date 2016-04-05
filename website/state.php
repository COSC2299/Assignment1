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
                     $sID = $_GET['id'];
                     //echo $state;
                     //dirname(__DIR__).'/
                     //include 'php_scripts/listCitiesForState.php'; 
                     include 'php_scripts/sqlCitiesForState.php'; 

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

<?php
   session_start();
?>

<!doctype html>

<html>  
<head>
   <!-- Keilor Dental Group -->
   <!-- Janith Muthuhetti -->
   <title>Weather Station</title>
   <link rel="stylesheet" type="text/css" href="css/pages/index_style.css">
   <?php require 'page_format/main/head.php';?>
</head>
   
   <body>
      <?php //include 'page_format/main/attention_bar.php';?>
      <?php require 'page_format/main/header.php';?>
      <?php require 'page_format/main/navigation_bar.php';?>

      <div id="main_body">
         <?php require 'page_format/main/sidebar.php';?>  
         <div id="main_content">
            <br/>
            <br/>
            <br/>
            <div id="home_info">
               <p> INFO HERE </p>
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
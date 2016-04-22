<?php require 'php_scripts/session_check_cookies.php'; ?>
<?php require 'php_scripts/session_check.php'; ?>


<!doctype html>

<html>  
<head>
   <title>Weather Station - All States</title>
   <?php require 'page_format/main/head.php';?>
   <?php require 'php_scripts/session_check_chart.php';?>
</head>
   
   <body>
      <?php //include 'page_format/main/attention_bar.php';?>
      <?php require 'page_format/main/header.php';?>
      <?php require 'page_format/main/navigation_bar.php';?>

      <div id="main_body">
         <?php require 'page_format/main/sidebar.php';?>  
         <div id="main_content">
            <div id="main_content_text">
            <br/>
            <p class="title_large">Browse States</p>
            <br/>
            <br/>
               <?php
                     include 'php_scripts/sqlStates.php'; // echo all states list
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

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
         		<h1>Search States</h1>
            	<div id="home_info">
               	<?php include 'php_scripts/listStates.php'; ?>
            	</div>
            	<br>
            	<br>
            	<br>
            	<br>
            </div>
         </div> 
      </div>
      <?php require 'page_format/main/footer.php';?>
   </body>

</html>

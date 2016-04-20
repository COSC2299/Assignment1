<?php
   session_start();
?>
<?php
	$selectedState = $_GET['s'];
	if ($selectedState == null){
   	$selectedState = 'All Stations';
   	$sID = 0;
   }
?>
<!doctype html>

<html>  
<head>
   <title>Weather Station - <?php echo $selectedState;?></title>
   <?php require 'page_format/main/head.php';?>
</head>
   
   <body>
      <?php //include 'page_format/main/attention_bar.php';?>
      <?php require 'page_format/main/header.php';?>
      <?php require 'page_format/main/navigation_bar.php';?>

      <div id="main_body">
         <?php require 'page_format/main/sidebar.php';?>  
         <div id="main_content">
            <div id="main_content_text">
               <?php 
                     $selectedState = $_GET['s'];
                     $sID = $_GET['id'];
                     if ($selectedState == null){
                     	$selectedState = 'All Stations';
                     	$sID = 0;
                     }
                     //echo $state;
                     //dirname(__DIR__).'/
                     //include 'php_scripts/listCitiesForState.php'; 
                     echo '<h1>Browse Stations - ' . $selectedState . '</h1>';
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

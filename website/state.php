<?php require 'php_scripts/session_check_cookies.php'; ?>
<?php require 'php_scripts/session_check.php'; ?>


<?php
	$selectedState = $_GET['s']; // if state is not defined, default to all states
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
               <?php 
                     echo '<br>';
                     echo '<p class="title_large">Browse Stations - ' . $selectedState . '</p>';
                     echo '<br>';
                     include 'php_scripts/sqlCitiesForState.php'; // echo stations in state

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

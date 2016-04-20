<?php
   session_start();
?>

<?php
	$selectedState = $_GET['s'];
   $selectedCity = $_GET['c'];
   $id = $_GET['id'];
   $sID = $_GET['sID'];
   $type = $_GET['type'];
   $time = $_GET['time'];
?>

<!doctype html>

<html>  
<head>
   <title>Weather Station - <?php echo $_GET['c'];?></title>
   <?php require 'page_format/main/head.php';?>
   <link rel="stylesheet" type="text/css" href="css/main/chart.css"/>
   <script src="page_format/Chart.js/Chart.js"></script>
   <script type="text/javascript">
   	function fav(city, state, id) {
         $.post( "php_scripts/favourite.php",{city:city, state:state, id:id}, function( data ) {
           	location.reload();
         });
      }
   </script>
</head>
   <body>
      <?php //include 'page_format/main/attention_bar.php';?>
      <?php require 'page_format/main/header.php';?>
      <div id="navigation_bar">
      	<ul id="navigation_menu">
         	<li><a href="<?php echo 'city_chart.php?c='.$selectedCity.'&s='.$selectedState.'&id='.$id.'&sID='.$sID.'&type=Temperature&time='.$time;?>">Temperature</a></li>
         	<li><a href="<?php echo 'city_chart.php?c='.$selectedCity.'&s='.$selectedState.'&id='.$id.'&sID='.$sID.'&type=Rain%20Fall%20Since%209am&time='.$time;?>">Rain</a></li>
         	<li><a href="<?php echo 'city_chart.php?c='.$selectedCity.'&s='.$selectedState.'&id='.$id.'&sID='.$sID.'&type=Wind%20Speed&time='.$time;?>">Wind</a></li>
         	<li><a href="<?php echo 'city_chart.php?c='.$selectedCity.'&s='.$selectedState.'&id='.$id.'&sID='.$sID.'&type=Pressure&time='.$time;?>">Pressure</a></li>
         	<li><a href="<?php echo 'city_chart.php?c='.$selectedCity.'&s='.$selectedState.'&id='.$id.'&sID='.$sID.'&type=Relative%20Humidity&time='.$time;?>">Humidity</a></li>
      	</ul>
   	</div>
   	<div id="navigation_bar_spacing"></div>

      <div id="main_body_chart">  
         <div id="main_content_chart">
            <div id="main_content_text">
            	<br>
               <?php 
                     echo '<h1>' . $selectedCity . ' - ' . $selectedState . '</h1>';
                     echo '<h2>'.$type.' - Past '.$time.' Hours</h2>';
                     if ($type == 'Rain Fall Since 9am'){
                     	echo '<p>Please note rain data resets at 9:00am</p>';
                     	echo '<br>';
               			echo '<br>';
                     }
                     if ($type == 'Wind Speed' || $type == 'Gust Speed'){
                     	echo '<p><a href="city_chart.php?c='.$selectedCity.'&s='.$selectedState.'&id='.$id.'&sID='.$sID.'&type=Wind%20Speed&time='.$time.'">Wind Speed</a></p>';
               			echo '<p><a href="city_chart.php?c='.$selectedCity.'&s='.$selectedState.'&id='.$id.'&sID='.$sID.'&type=Gust%20Speed&time='.$time.'">Gust Speed</a></p>';
                     }
               ?>
               
               
               <?php include 'php_scripts/readWeatherDataChart.php';?>
               <?php include 'php_scripts/chartScriptTemp.php';?>
               <?php include 'php_scripts/chart.php';?>
         
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

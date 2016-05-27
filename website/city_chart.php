<?php
	$chartOpen = true;
	$chartURL = $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
	setcookie("chartURL", $chartURL, time() + (86400 * 30), "/"); // store chartURL in cookie
	setcookie("chartOpen", true, time() + (86400 * 30), "/"); // store array in cookie
?>

<?php
   session_start();
?>

<?php
	$selectedState = $_GET['s'];
   $selectedCity = $_GET['c'];
   $id = $_GET['id'];
   $sID = $_GET['sID'];
   $data = $_GET['data'];
   $time = $_GET['time'];
   $type = $_GET['type'];
?>

<!docdata html>

<html>  
<head>
   <title>Weather Station - <?php echo $_GET['c'];?></title>
   <?php require 'page_format/main/head.php';?>
   <link rel="stylesheet" data="text/css" href="css/main/chart.css"/>
   <script src="page_format/Chart.js/Chart.js"></script>
   <script data="text/javascript">
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
      	<?php
      		if ($type == 'forecast') {
      	?>
         	<li><a href="<?php echo 'city_chart.php?c='.$selectedCity.'&s='.$selectedState.'&id='.$id.'&sID='.$sID.'&data=Temperature&time='.$time.'&type='.$type;?>">Temperature</a></li>
         	<li><a href="<?php echo 'city_chart.php?c='.$selectedCity.'&s='.$selectedState.'&id='.$id.'&sID='.$sID.'&data=Precipitation%20Probability&time='.$time.'&type='.$type;?>">Precipitation</a></li>
         	<li><a href="<?php echo 'city_chart.php?c='.$selectedCity.'&s='.$selectedState.'&id='.$id.'&sID='.$sID.'&data=Wind%20Speed&time='.$time.'&type='.$type;?>">Wind</a></li>
         	<li><a href="<?php echo 'city_chart.php?c='.$selectedCity.'&s='.$selectedState.'&id='.$id.'&sID='.$sID.'&data=Humidity&time='.$time.'&type='.$type;?>">Humidity</a></li>
         	<li><a href="<?php echo 'city_chart.php?c='.$selectedCity.'&s='.$selectedState.'&id='.$id.'&sID='.$sID.'&data=Cloud%20Cover&time='.$time.'&type='.$type;?>">Cloud Cover</a></li>
         <?php
         	}
         	else {
         ?>
         	<li><a href="<?php echo 'city_chart.php?c='.$selectedCity.'&s='.$selectedState.'&id='.$id.'&sID='.$sID.'&data=Temperature&time='.$time.'&type='.$type;?>">Temperature</a></li>
         	<li><a href="<?php echo 'city_chart.php?c='.$selectedCity.'&s='.$selectedState.'&id='.$id.'&sID='.$sID.'&data=Rain%20Fall%20Since%209am&time='.$time.'&type='.$type;?>">Rain</a></li>
         	<li><a href="<?php echo 'city_chart.php?c='.$selectedCity.'&s='.$selectedState.'&id='.$id.'&sID='.$sID.'&data=Wind%20Speed&time='.$time.'&type='.$type;?>">Wind</a></li>
         	<li><a href="<?php echo 'city_chart.php?c='.$selectedCity.'&s='.$selectedState.'&id='.$id.'&sID='.$sID.'&data=Pressure&time='.$time.'&type='.$type;?>">Pressure</a></li>
         	<li><a href="<?php echo 'city_chart.php?c='.$selectedCity.'&s='.$selectedState.'&id='.$id.'&sID='.$sID.'&data=Relative%20Humidity&time='.$time.'&type='.$type;?>">Humidity</a></li>
         <?php
         	}
         ?>
      	</ul>
   	</div>
   	<div id="navigation_bar_spacing"></div>

      <div id="main_body_chart">  
         <div id="main_content_chart">
            <div id="main_content_text">
            	<br>
               <?php 
						echo '<p class="title_large">' . $selectedCity . '</p>';
						echo '<p class="title_medium">' . $selectedState . '</p>';

               	if ($type == 'forecast'){
               		include 'php_scripts/readWeatherDataChartForecast.php';
               	}
               	else {
               		include 'php_scripts/readWeatherDataChartHistorical.php';
               	}
               	include 'php_scripts/chartScript.php';
               	include 'php_scripts/chart.php';
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

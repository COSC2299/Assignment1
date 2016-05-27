<?php require 'php_scripts/session_check_cookies.php'; ?>
<?php require 'php_scripts/session_check.php'; ?>


<?php require_once 'php_scripts/KLogger.php'; 
      $log = new KLogger ( "log/log.txt" , KLogger::DEBUG );
?>

<!doctype html>

<html>  
<head>
   <title>Weather Station - <?php echo $_GET['c'];?></title>
   <?php require 'page_format/main/head.php';?>
   <?php require 'php_scripts/session_check_chart.php';?>
   <script type="text/javascript">
   	function fav(city, state, id) {
         $.post( "php_scripts/favourite.php",{city:city, state:state, id:id}, function( data ) {
            console.log(data);
            location.reload();
         });
      }
   	function clearFav(favID) { // function to remove favourites
      	$.post( "php_scripts/clearFavourites.php",{favID:favID}, function( data ) {  // post to clearFavourites php script
      	   console.log(data);      
            location.reload(); // reload page after adding favourite
         });
      }
   </script>
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
                     $selectedCity = $_GET['c'];
                     $id = $_GET['id'];
                     $sID = $_GET['sID'];
                     $type = $_GET['type'];

                     $log->logInfo('Showing results for City: '.$selectedCity.', State: '.$selectedState.' ID: '.$id);
                     /*if($id<=0 || isset($_GET['id']) == false)
                     {
                        $log->logError('No city selected');
                     }*/
             	?>
               <?php
               	require 'php_scripts/search_results.php';
               ?>
            <script>
            	function displayChartHistorical(){
      				chartWindow = window.open('<?php echo 'city_chart.php?c='.$cityURL.'&s='.$stateURL.'&id='.$id.'&sID='.$sID.'&data=Temperature&time=0&type=historical';?>', 'chartWindow', 'width=1300, height=1000'); 
      				localStorage.setItem('chartWindow', chartWindow);
      				return false;
      			}
      			function displayChartForecast(){
      				chartWindow = window.open('<?php echo 'city_chart.php?c='.$cityURL.'&s='.$stateURL.'&id='.$id.'&sID='.$sID.'&data=Temperature&time=0&type=forecast';?>', 'chartWindow', 'width=1300, height=1000'); 
      				localStorage.setItem('chartWindow', chartWindow);
      				return false;
      			}
            </script>
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

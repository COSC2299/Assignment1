<?php
   session_start();
?>

<!doctype html>

<html>  
<head>
   <title>Weather Station - My Favourites</title>
   <?php require 'page_format/main/head.php';?>
   <script type="text/javascript">
   	function clearFav($favID) { // function to remove favourites
   		$url = "php_scripts/clearFavourites.php?favID=" + $favID;
   		console.log($url);
      	$.post( $url,{}, function( data ) {  // post to clearFavourites php script
      		console.log(data);      
            location.reload(); // reload page after adding favourite
         });
      }
   </script>
   <script type="text/javascript">
   	function clearFavourites($favID){
   		console.log($favID);
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
               <h1>My Favourites</h1>
               	<?php
                  	$favs = json_decode($_COOKIE['favourites'], true); // get array from cookie
                  	
                  	if (count($favs) != 0){
                  	   echo '<table border="1" style="width:90%; margin:auto;">';
                  		echo '<tr>';
								echo '<th>Station</th>';
								echo '<th>State</th>';
								echo '<th>Unfavourite Station</th>';
								echo '</tr>';
                  	}
                  	
                  	
                  	for ($i=0; $i < count($favs); $i++) { // print all favourites
                  		echo '<tr>';
                     	echo '<td><a href="city.php?c='.$favs[$i]['city'].'&s='.$favs[$i]['state'].'&id='.$favs[$i]['id'].'">'.$favs[$i]['city'].'</a></td>'; // print station name
                     	echo '<td><a href="state.php?&s='.$favs[$i]['state'].'&id='.$favs[$i]['sID'].'">'.$favs[$i]['state'].'</a></td>';	// print state name
                     	echo '<td><a href="#" onclick="clearFav('.$i.')">Unfavourite '.$favs[$i]['city'].'</a></td>'; // create unfavourite button
                     	echo '<tr>';
                  	}
                  	if (count($favs) == 0){ // if there are no favourite, print message
                  		echo '<p>You currently do not have any favourites</p>';
                  	}
                  	else{
                  		echo '</table>';
                  		echo '<br>';
                  		echo '<br>';
                  		echo '<p class="center"><a href="#" onclick="clearFav(-1)">Remove All Favourites</a></p>'; // create remove all favourites button
                  	}
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

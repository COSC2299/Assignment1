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
            <h1>Home</h1>
            <h2>My Favourites</h2>
               	<?php
                  	$favs = $_SESSION['favourites'];
                  	
                  	if (count($favs) != 0){
                  	   echo '<table border="0" style="width:90%; margin:auto;">';
                  		echo '<tr>';
								echo '<th>Station</th>';
								echo '<th>State</th>';
								echo '<th></th>';
								echo '</tr>';
                  	}
                  	
                  	
                  	for ($i=0; $i < count($favs); $i++) { 
                  		echo '<tr>';
                     	echo '<td><a href="city.php?c='.$favs[$i]['city'].'&s='.$favs[$i]['state'].'&id='.$favs[$i]['id'].'">'.$favs[$i]['city'].'</a></td>';
                     	echo '<td><a href="state.php?&s='.$favs[$i]['state'].'&id='.$favs[$i]['sID'].'">'.$favs[$i]['state'].'</a></td>';
                     	echo '<td><button onclick="clearFav('.$i.')">Unfavourite This Station</button></td>';
                     	echo '<tr>';
                  	}
                  	if (count($favs) == 0){
                  		echo '<p>You currently do not have any favourites</p>';
                  	}
                  	else{
                  		echo '</table>';
                  		echo '<br>';
                  		echo '<button onclick="clearFav(-1)">Remove All Favourites</button>';
                  	}
               	?> 
            <h2>Browse States</h2>
            <?php //include 'php_scripts/search.php'; ?>
               <?php //include 'php_scripts/listStates.php'; 
                     include 'php_scripts/sqlStates.php'; 
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

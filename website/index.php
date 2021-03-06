<?php require 'php_scripts/session_check_cookies.php'; //check if new session. ?>
<?php require 'php_scripts/session_check.php'; // if so reopen last session windows ?>


<!doctype html>

<html>  
<head>
   <title>Weather Station</title>
   <?php require 'page_format/main/head.php';?>
   <?php require 'php_scripts/session_check_chart.php'; //script for reopening charts ?> 
</head>
   
   <body>
      <?php include 'page_format/main/attention_bar.php';?>
      <?php require 'page_format/main/header.php';?>
      <?php require 'page_format/main/navigation_bar.php';?>

      <div id="main_body">
         <?php require 'page_format/main/sidebar.php';?>  
         <div id="main_content">
            <div id="main_content_text">
            <br>
            <br>
            <br>
            <p class="title_medium">Search</p>
            <br>
            <div id="search_index">
            	<?php include 'php_scripts/search.php';?>
            </div>
            <br>
            <br>
            <br>
            <br>
            <p class="title_medium">My Favourites</p>
               	<?php
                  	$favs = json_decode($_COOKIE['favourites'], true);
                  	
                  	if (count($favs) != 0){
                  	   echo '<table border="0" style="width:90%; margin:auto; table-layout: fixed;">';
                  		echo '<tr>';
								echo '<th>Station</th>';
								echo '<th>State</th>';
								echo '</tr>';
                  	}
                  	
                  	for ($i=0; $i < count($favs); $i++) {  // echo favourites from cookie
                  		echo '<tr>';
                     	echo '<td><a href="city.php?c='.$favs[$i]['city'].'&s='.$favs[$i]['state'].'&id='.$favs[$i]['id'].'">'.$favs[$i]['city'].'</a></td>';
                     	echo '<td><a href="state.php?&s='.$favs[$i]['state'].'&id='.$favs[$i]['sID'].'">'.$favs[$i]['state'].'</a></td>';
                     	echo '</tr>';
                  	}
                  	if (count($favs) == 0){ // if no favourites, echo message
                  		echo '<p>You currently do not have any favourites</p>';
                  	}
                  	else{
                  		echo '</table>';
                  		echo '<br>';
                  	}
               	?>
            <br>
            <br>
            <p class="title_medium">Browse States</p>
               <?php  
                     include 'php_scripts/sqlStates.php'; // echo all states
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

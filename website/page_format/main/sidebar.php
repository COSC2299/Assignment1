         <div id="sidebar">
            <br/>
            <br/>
            <div id="search_bar">
            	<?php 
            		if (basename($_SERVER['PHP_SELF']) != 'index.php'){
            			include 'php_scripts/search.php';
            		}
            	?>
            </div>
            <br/>
            <div id="sidebar_info">    
               <h2><a href="favourites.php">Favourites</a></h2>
               <?php
               	$shortState = array("Antarctica"=>"AN", "Canberra"=>"ACT", "New South Wales"=>"NSW",
               	 	"Northern Territory"=>"NT", "Queensland"=>"QLD", "South Australia"=>"SA",
               	 	"Tasmania"=>"TAS", "Victoria"=>"VIC", "Western Australia"=>"WA");
                  $favs = json_decode($_COOKIE['favourites'], true);
                  
                  for ($i=0; $i < count($favs); $i++) {
                  	$stateFav = $shortState[$favs[$i]['state']];
                     echo '<p><a href="city.php?c='.$favs[$i]['city'].'&s='.$favs[$i]['state'].'&id='.$favs[$i]['id'].'">'.$favs[$i]['city'].', '.$stateFav.'</a></p>';
                  }
                  //print_r($favs);
                  //echo count($favs);
                  //echo $favs[0]; 
            	?>    
            </div>
            <br/>
            <br/>
            <br/>
            <br/>
            <br/>
            <br/>
            <br/>
         </div> 
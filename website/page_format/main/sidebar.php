         <div id="sidebar">
            <br/>
            <br/>
            <div id="search_bar">
            	<?php include 'php_scripts/search.php'; ?>
            </div>
            <br/>
            <div id="sidebar_info">    
               <h2>Favourites</h2>
               <?php
                  $favs = $_SESSION['favourites'];
                  for ($i=0; $i < count($favs); $i++) { 
                     echo '<p><a href="city.php?c='.$favs[$i]['city'].'&s='.$favs[$i]['state'].'&id='.$favs[$i]['id'].'">'.$favs[$i]['city'].', '.$favs[$i]['state'].'</a></p>';
                  }
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
         <div id="sidebar">
            <br/>
            <br/>
            <?php include 'php_scripts/search.php'; ?>
            <br/>
            <div id="sidebar_info">      
               <h2>Favourites</h2>
               <?php
                  $favs = $_SESSION['favourites'];
                  for ($i=0; $i < count($favs); $i++) { 
                     echo '<p><a href="city.php?c='.$favs[$i]['city'].'&s='.$favs[$i]['state'].'&id='.$favs[$i]['id'].'">'.$favs[$i]['city'].', '.$favs[$i]['state'].'</a></p>';
                  }
               ?>  
               <br>
               <button onclick="clearFav()">Remove All Favourites</button>    
            </div>
            <br/>
            <br/>
            <br/>
            <br/>
            <br/>
            <br/>
            <br/>
         </div> 
         <script type="text/javascript">
            function clearFav() {
                     $.post( "php_scripts/clearFavourites.php",{}, function( data ) {
                   
                        console.log(data);
                    
                     });
               }
         </script>
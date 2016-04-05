         <div id="sidebar">
            <br/>
            <br/>
            <br/>
            <div id="sidebar_contact_info">      
               <h2>Favourites</h2>
               <ul id="favList">
              
                  <?php
                     $favs = $_SESSION['favourites'];
                     for ($i=0; $i < count($favs); $i++) { 
                        echo '<li><a href="city.php?c='.$favs[$i]['city'].'&id='.$favs[$i]['id'].'">'.$favs[$i]['city'].', '.$favs[$i]['state'].'</a></li>';
                     }
                  ?>
               </ul>
           
            </div>
            <br/>
            <br/>
            <br/>
            <br/>
            <br/>
            <br/>
            <br/>
         </div> 

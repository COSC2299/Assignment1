         <div id="sidebar">
            <br/>
            <br/>
            <br/>
            <div id="sidebar_contact_info">      
               <h2>Favourites</h2>
               <ul>
              
                  <?php
                     $favs = $_SESSION['favourites'];
                     for ($i=0; $i < count($favs); $i++) { 
                        echo '<li><a href="city.php?c='.$favs[$i]['city'].'&s='.$favs[$i]['state'].'">'.$favs[$i]['city'].', '.$favs[$i]['state'].'</a></li>';
                     }
                  ?>
               </ul>
               <br/>
               <br/>
               <br/>
               <br/>
               <br/>
               <br/>
               <br/>
               <br/>
            </div>
            <br/>
            <br/>
            <br/>
            <br/>
            <br/>
            <br/>
            <br/>
         </div> 

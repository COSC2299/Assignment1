   <?php
      if ($_SESSION['showAttentionBar'] == true){
      	echo '<div id="attention_bar">';
      		echo '<img id="attention_bar_close" src="media/images/miscellaneous/x.png" alt="close">';
         	echo '<div id="attention_bar_text">'.$_SESSION['attentionBarText'].'</div>';
      	echo'</div>';
      	$_SESSION['showAttentionBar'] = false;
      }  
   ?>
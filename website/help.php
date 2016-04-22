<?php require 'php_scripts/session_check_cookies.php'; ?>
<?php require 'php_scripts/session_check.php'; ?>


<!doctype html>

<html>  
<head>
   <title>Weather Station</title>
   <?php require 'page_format/main/head.php';?>
</head>
   
   <body>
      <?php //include 'page_format/main/attention_bar.php';?>
      <?php require 'page_format/main/header.php';?>
      <?php require 'page_format/main/navigation_bar.php';?>

      <div id="main_body">
         <?php require 'page_format/main/sidebar.php';?>  
         <div id="main_content">
            <div id="main_content_text">
            	<h1>HOW TO USE THE WEATHER WEBSITE</h1>
            	<br>
            	<h3><strong>MENU PAGES OVERVIEW</strong></h3>
            	<p><strong>Home</strong> - The page the website will default to. It displays a list of all states, and also a list of all your saved favourites. Clicking on a state will allow you to browse a list of the suburbs within that state. Clicking on a town will allow you to view the weather details of that town.</p>
            	<p><strong>States</strong> - This page lists all the states. Clicking on a state allows you to browse a list of suburbs within that state. Clicking on a town will allow you to view the weather details of that town.</p>
            	<p><strong>Stations</strong> - This page lists all the towns under all their states. Clicking on a town will allow you to view the weather details of that town.</p>
            	<p><strong>My Favourites</strong> - This page displays a list of all your "Favourited" towns. Clicking on a towm will allow you to view the weather details of that town. To remove a station from your Favourites list, click on "Unfavourite This Station". Alternatively, you can clear your Favourites list completely by clicking "Remove All Favourites".</p>
            	<br>
            	<h3><strong>HOW TO FIND WEATHER FOR YOUR SUBURB</strong></h3>
            	<p>1. Type the name on your suburb/town in the search bar located in the sidebar on the right hand side of the window.</p>
            	<p>2. Click the option which drops down off the search bar.</p>
            	<p>3. Press Enter.</p>
            	<br>
            	<h3><strong>TOWN/SUBURB WEATHER DETAILS PAGE OVERVIEW</strong></h3>
            	<p>The town/suburb pages display a chart which shows the temperature in the previous 2 to 4 days, at given times. It also shows the cloud reading at that time on that day. From the town/suburb page, you can also display a graph of the temperatures measured in that town in the past 12 hours. It also includes a link to the States page, and also includes a link which allows you to view the towns/suburbs in the same state.</p>
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

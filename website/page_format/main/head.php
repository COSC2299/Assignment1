   <meta charset="UTF-8">
   
   <meta name="application-name" content="Keilor Dental Group">
   <meta name="description" content="Keilor Dental Group - Dentist in Keilor East">
   <meta name="keywords" content="Dentist,Dental,Fillings,Crowns,Bridges,Dentures">
   <meta name="author" content="Janith Muthuhetti">

   <link rel="shortcut icon" href="media/images/logo/bookmark.png"/>
   <link rel="stylesheet" type="text/css" href="css/main/style.css"/>
   <link href="https://fonts.googleapis.com/css?family=Nunito|Merriweather:900|Nothing+You+Could+Do" rel="stylesheet" type="text/css"/>   
   <script>
      console.log("Keilor Dental Group 2014");
      console.log("webdev.muthuhetti.com/keilor");
      console.log(<? echo json_encode($_SESSION); ?>);
      console.log(<? echo json_encode($_POST); ?>);
      console.log(<? echo json_encode($_GET); ?>);
      console.log(<? echo json_encode($_COOKIE); ?>);
   </script>
   <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
   <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
   <script type="text/javascript">
      $(document).ready(function(){
         $("#attention_bar_close").click(function(){
            $("#attention_bar").hide();   
                   
         });
         $attention_bar_hide = "<?php echo $_SESSION["attention_bar_hide"]; ?>";
         if($attention_bar_hide == "true")
            $("#attention_bar").hide();
      });
   </script>
   <script type="text/javascript">
      $(document).ready(function(){
            $navigation_bar_document = $("#header").position().top + 110;
            $document_position = $(window).scrollTop();
            $navigation_bar_position = $navigation_bar_document - $document_position;

	    if($navigation_bar_position <= 0)
	    {
	       $("#navigation_bar").css("position","fixed");
	       $("#navigation_bar").css("top", 0);
	       $("#navigation_bar").css("background-color", "rgb(78,78,78)");
	       $("#navigation_bar_spacing").css("display","block");
	       $("#navigation_button_home").html("<a href='/'>Keilor Dental Group</a>");
	    }
	    else
	    {
	       $("#navigation_bar").css("position","relative");
	       
	       $("#navigation_bar_spacing").css("display","none");
	       $("#navigation_button_home").html("<a href='/'>Home</a>");
	    }
	    
	    if($(document.body).width() >= 1750)
	    {
	       $("#navigation_menu").css("width", "1750px");
	       $("#navigation_menu a").css("width", "350px");
	    }
   	    else if($(document.body).width() >= 1300)
	    {
	       $("#navigation_menu").css("width", "1300px");
	       $("#navigation_menu a").css("width", "260px");
	    }
	    else
	    {
	       $("#navigation_menu").css("width", "1000px");
	       $("#navigation_menu a").css("width", "200px");
	    }
      });
      $(window).scroll(function(){
            $navigation_bar_document = $("#header").position().top + 110;
            $document_position = $(window).scrollTop();
            $navigation_bar_position = $navigation_bar_document - $document_position;   

	    if($navigation_bar_position <= 0)
	    {
	       $("#navigation_bar").css("position","fixed");
	       $("#navigation_bar").css("top", 0);
	       $("#navigation_bar").css("background-color", "rgb(78,78,78)");
	       $("#navigation_bar_spacing").css("display","block");
	       $("#navigation_button_home").html("<a href='/'>Keilor Dental Group</a>");
	    }
	    else
	    {
	       $("#navigation_bar").css("position","relative");
	       $("#navigation_bar").css("background-color", "rgb(22, 88, 192)");
	       $("#navigation_bar_spacing").css("display","none");
	       $("#navigation_button_home").html("<a href='/'>Home</a>");
	    }
	    
	    if($(document.body).width() >= 1750)
	    {
	       $("#navigation_menu").css("width", "1750px");
	       $("#navigation_menu a").css("width", "350px");
	    }
   	    else if($(document.body).width() >= 1300)
	    {
	       $("#navigation_menu").css("width", "1300px");
	       $("#navigation_menu a").css("width", "260px");
	    }
	    else
	    {
	       $("#navigation_menu").css("width", "1000px");
	       $("#navigation_menu a").css("width", "200px");
	    }
         });
      $(window).resize(function(){
   	    if($(document.body).width() >= 1750)
	    {
	       $("#navigation_menu").css("width", "1750px");
	       $("#navigation_menu a").css("width", "350px");
	    }
   	    else if($(document.body).width() >= 1300)
	    {
	       $("#navigation_menu").css("width", "1300px");
	       $("#navigation_menu a").css("width", "260px");
	    }
	    else
	    {
	       $("#navigation_menu").css("width", "1000px");
	       $("#navigation_menu a").css("width", "200px");
	    }
      });
   </script>   
   <script type="text/javascript">
      $(document).ready(function(){
         $window_width = $(document.body).width();
         $original_sidebar_height = $("#sidebar").height() + 50;
         
         $("#main_content").css("width", $window_width - 401);
         
         if($("#main_content").height() > $("#sidebar").height())
         {
            $("#sidebar").css("height", $("#main_content").height());
         }
         if($("#main_content").height() < $("#sidebar").height())
         {
            if($("#main_content").height() > $original_sidebar_height)
            {
               $("#sidebar").css("height", $("#main_content").height());
            }
         }
      });
      
      $(window).resize(function(){
         $window_width = $(document.body).width();
         $("#main_content").css("width", $window_width - 401);
         
         if($("#main_content").height() > $("#sidebar").height())
         {
            $("#sidebar").css("height", $("#main_content").height());
         }
         if($("#main_content").height() < $("#sidebar").height())
         {
            if($("#main_content").height() > $original_sidebar_height)
            {
               $("#sidebar").css("height", $("#main_content").height());
            }
         }
         
      });
   </script>  
   <script type="text/javascript">
      function validate_form(){
         var f_name = document.forms["appointment_form"]["f_name"];
         var l_name = document.forms["appointment_form"]["l_name"];
         var primary = document.forms["appointment_form"]["primary"];
         
         var f_valid = false;
         var l_valid = false;
         var p_valid = false;
         
         if (f_name.value==null || f_name.value==""){
            f_name.style.borderColor = "red";
         }
         else{
            f_name.style.borderColor = "";
            f_valid = true;
         }
         
         if (l_name.value==null || l_name.value==""){
            l_name.style.borderColor = "red";
         }
         else{
            l_name.style.borderColor = "";
            l_valid = true;
         }
         
         if (primary.value==null || primary.value==""){
            primary.style.borderColor = "red";
         }
         else{
            if (isNaN(primary.value)){
               primary.style.borderColor = "red";
               p_valid = true;
            }
            else{
               primary.style.borderColor = "";
               p_valid = true;
            }
         }
         
         if(f_valid == false){
            return false;
         }
         
         if(l_valid == false){
            return false;
         }
         if(p_valid == false){
            return false;
         }
      }
   </script>
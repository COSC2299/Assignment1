<?php unset($_SESSION['favourites']); ?>
<?php
	require dirname(__DIR__).'/php_scripts/sqlSecurity.php';
	try{
	        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
	                                   // set the PDO error mode to excepti
	        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	        $sql = 'DELETE FROM weatherdata';

	        $sth = $conn->prepare($sql);

	        $sth->execute();

	    }
	     catch(PDOException $e)
	     {
	         echo $sql . "<br/>" . $e->getMessage();
	     }

?>
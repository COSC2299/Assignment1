<?php



	class RemoteConnectTest extends PHPUnit_Framework_TestCase
	{
	  public function setUp(){ }
	  public function tearDown(){ }

	  public function testConnectionIsValid()
	  {
	  	require dirname(__DIR__).'/php_scripts/sqlSecurity.php';
	    // test to ensure that the object from an fsockopen is valid
	    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		// set the PDO error mode to excepti
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$status = $conn->getAttribute(PDO::ATTR_CONNECTION_STATUS);

		//echo $status; 
	    $this->assertTrue($status !== '');
	  }
	}
?>
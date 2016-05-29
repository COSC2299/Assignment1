<?php
	class addFavouriteTest extends PHPUnit_Framework_TestCase
	{

	  public function testAddFavourite()
	  {

	  	$_POST['city'] = 'Davis';
	  	$_POST['state'] = 'Antartica';
	  	$_POST['id'] = '1600';
	  	$_COOKIE['favourites'] = '';
	  	require dirname(__DIR__).'/php_scripts/favourite.php';
	   
	   	$result = addfavourite(1);

	    $this->assertTrue($result !== '');
	  }
	}
?>
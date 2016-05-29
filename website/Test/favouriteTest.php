<?php
	class favouriteTest extends PHPUnit_Framework_TestCase
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

	  public function testRemoveOne()
	  {
	  	$_POST['favID'] = '1600';
	  	$_COOKIE['favourites'] = json_encode(array('1600' => array('city' => 'Davis', 'state' => 'Antartica')));

	  	require dirname(__DIR__).'/php_scripts/clearFavourites.php';
	  }
	}
?>
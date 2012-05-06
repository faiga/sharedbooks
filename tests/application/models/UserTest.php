<?php

class Model_UserTest extends PHPUnit_Framework_TestCase
{
	public function setUp() {
		parent::setUp();
	}
	
	public function tearDown()
	{
		parent::tearDown();
	}
	
	public function testInsert()
	{
		$user = new Application_Model_User();
		$test = $user->insertUser();
		$this->assertNull($test);
	}
}
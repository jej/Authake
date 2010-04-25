<?php 

App::import('Model', 'User');

class UserTestCase extends CakeTestCase {
	var $TestObject = null;

	function setUp() {
		$this->TestObject = new User();
	}

	function tearDown() {
		unset($this->TestObject);
	}

	/*
	function testMe() {
		$result = $this->TestObject->findAll();
		$expected = 1;
		$this->assertEqual($result, $expected);
	}
	*/
}
?>
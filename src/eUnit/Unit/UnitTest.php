<?php
namespace eUnit\Unit;

class UnitTest {
	/**
	 * Test name
	 * @var string
	 */
	public $name;
	
	/**
	 * Test status
	 * @var int
	 */
	public $status;
	
	/**
	 * Test summary
	 * @var string
	 */
	public $summary = '';
	
	/**
	 * Test assertions
	 * @var int
	 */
	public $assertions = 0;
	
	/**
	 * Test failures
	 * @var int
	 */
	public $failures = 0;
	
	/**
	 * Test errors
	 * @var string
	 */
	public $errors = 0;
	
	/**
	 * Internal tests
	 * @var array
	 */
	public $tests = array();
	
	/**
	 * Error/Failure messages
	 * @var array
	 */
	public $messages = array();
}
?>
<?php
namespace eUnit\Exception;

class ComparisonFailedException extends \Exception {
	use \eUnit\Unit\VarDiff;

	public $expected;
	public $actual;
	public $expectedAsString;
	public $actualAsString;
	public $message;
	
	public function __construct($message, $expected, $actual, $expectedAsString, $actualAsString) {
		parent::__construct($message);
		
		$this->expected = $expected;
		$this->actual = $actual;
		$this->expectedAsString = $expectedAsString;
		$this->actualAsString = $actualAsString;
	}
	
	public function getDiff() {
		return $this->actualAsString || $this->expectedAsString ? "\n" . $this->diff($this->expectedAsString, $this->actualAsString) : '';
	}
	
	public function toString() {
		return $this->message . $this->getDiff();
	}
}
?>
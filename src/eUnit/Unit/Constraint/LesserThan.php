<?php
namespace eUnit\Unit\Constraint;

class LesserThan extends Constraint {
	/**
	 * Value to which compare
	 * @var mixed
	 */
	public $value;
	
	public function __construct($value) {
		$this->value = $value;
	}
	
	public function matches($actual) {
		return $this->value > $actual;
	}
	
	public function toString() {
		return 'is lesser than ' . $this->export($this->value);
	}
}
?>
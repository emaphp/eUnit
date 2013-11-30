<?php
namespace eUnit\Unit\Constraint;

class LesserThanOrEqual extends Constraint {
	/**
	 * The value to which compare
	 * @var mixed
	 */
	public $value;
	
	public function __construct($value) {
		$this->value = $value;
	}
	
	public function matches($actual) {
		return $this->value >= $actual;
	}
	
	public function toString() {
		return 'is lesser than or equal to ' . $this->export($this->value);
	}
}
?>
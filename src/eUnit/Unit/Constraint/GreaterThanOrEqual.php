<?php
namespace eUnit\Unit\Constraint;

class GreaterThanOrEqual extends Constraint {
	/**
	 * Value to chich compare
	 * @var mixed
	 */
	public $value;
	
	public function __construct($value) {
		$this->value = $value;
	}
	
	public function matches($actual) {
		return $this->value <= $actual;
	}
	
	public function toString() {
		return 'is greater than or equal to ' . $this->export($this->value);
	}
}
?>
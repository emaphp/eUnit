<?php
namespace eUnit\Unit\Constraint;

class IsInstanceOf extends Constraint {
	/**
	 * Class to assert
	 * @var string
	 */
	public $classname;
	
	public function __construct($className) {
		$this->classname = $className;
	}
	
	public function matches($actual) {
		return ($actual instanceof $this->classname);
	}
	
	protected function failureDescription($actual) {
		return sprintf('%s is an instance of class "%s"', $this->shortenedExport($actual), $this->classname);
	}
	
	public function toString() {
		return sprintf('is instance of class "%s"', $this->classname);
	}
}
?>
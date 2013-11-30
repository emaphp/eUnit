<?php
namespace eUnit\Unit\Constraint;

use eUnit\Exception\AssertionFailedException;

abstract class Constraint {
	use \eUnit\Unit\VarExport;
	
	protected function fail($value) {
		throw new AssertionFailedException(sprintf("Failed asserting that %s.", $this->failureDescription($value)));
	}
	
	protected function failureDescription($value) {
		return $this->export($value) . ' ' . $this->toString();
	}
	
	protected function matches($actual) {
		return true;
	}
	
	public function evaluate($actual, $returnResult = false) {
		$success = false;
		
		if ($this->matches($actual)) {
			$success = true;
		}
		
		if ($returnResult) {
			return $success;
		}
		
		if (!$success) {
			$this->fail($actual);
		}
	}
	
	public abstract function toString();
}
?>
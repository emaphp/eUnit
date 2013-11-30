<?php
namespace eUnit\Unit\Constraint;

class IsTrue extends Constraint {
	public function evaluate($actual, $returnResult = false) {
		if ($actual !== true) {
			if ($returnResult) {
				return false;
			}
			
			$this->fail($actual);
		}
		
		if ($returnResult) {
			return true;
		}
	}
	
	public function toString() {
		return 'is true';
	}
}
?>
<?php
namespace eUnit\Unit\Constraint;

class IsFalse extends Constraint {
	public function evaluate($actual, $returnResult = false) {
		if ($actual !== false) {
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
		return 'is false';
	}
}
?>
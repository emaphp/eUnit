<?php
namespace eUnit\Unit\Constraint;

class IsNull extends Constraint {
	public function evaluate($actual, $returnResult = false) {
		if ($actual !== null) {
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
		return 'is null';
	}
}
?>
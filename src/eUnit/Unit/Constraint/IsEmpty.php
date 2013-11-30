<?php
namespace eUnit\Unit\Constraint;

class IsEmpty extends Constraint {
	public function evaluate($actual, $returnResult = false) {
		if (!empty($actual)) {
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
		return 'is empty';
	}
}
?>
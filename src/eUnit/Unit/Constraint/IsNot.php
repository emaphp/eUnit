<?php
namespace eUnit\Unit\Constraint;

class IsNot extends Constraint {
	public $constraint;
	
	public function __construct(Constraint $constraint) {
		$this->constraint = $constraint;
	}
	
	public function evaluate($actual, $returnResult = false) {
		$success = !$this->constraint->evaluate($actual, true);

		if ($returnResult) {
			return $success;
		}
		
		if (!$success) {
			$this->fail($actual);
		}
	}
	
	protected function negate($string) {
		return str_replace(
		array(
            'contains ',
            'exists',
            'has ',
            'is ',
            'are ',
            'matches ',
            'starts with ',
            'ends with ',
            'reference ',
            'not not '
        ),
        array(
            'does not contain ',
            'does not exist',
            'does not have ',
            'is not ',
            'are not ',
            'does not match ',
            'starts not with ',
            'ends not with ',
            'don\'t reference ',
            'not '
        ),
        $string);
	}
	
	public function toString() {
		return $this->negate($this->constraint->toString());
	}
}
?>
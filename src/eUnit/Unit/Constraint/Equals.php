<?php
namespace eUnit\Unit\Constraint;

use eUnit\Unit\Comparator\ComparatorFactory;
use eUnit\Exception\AssertionFailedException;
use eUnit\Exception\ComparisonFailedException;

class Equals extends Constraint {
	/**
	 * Value to which compare
	 * @var mixed
	 */
	public $value;
	
	public function __construct($expected) {
		$this->value = $expected;
	}
	
	public function evaluate($actual, $returnResult = false) {
		try {
			$comparator = ComparatorFactory::getInstance()->getComparatorFor($this->value, $actual);
			$comparator->assertEquals($this->value, $actual);
			
			if ($returnResult) {
				return true;
			}
		}
		catch (ComparisonFailedException $ce) {
			if ($returnResult) {
				return false;
			}
			
			throw new AssertionFailedException($ce->toString());
		}
	}
	
	public function toString() {
		if (is_string($this->value)) {
			if (strpos($this->value, "\n") !== false) {
				return 'is equal to <text>';
			}
			
			return sprintf('is equal to <string:%s>', $this->value);			 
		}
		
		return sprintf('is equal to %s', $this->export($this->value));
	}
}
?>
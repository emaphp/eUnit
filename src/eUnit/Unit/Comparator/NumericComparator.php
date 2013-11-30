<?php
namespace eUnit\Unit\Comparator;

use eUnit\Exception\ComparisonFailedException;

class NumericComparator extends Comparator {
	public function assertEquals($expected, $actual) {
		if (is_infinite($actual) && is_infinite($expected)) {
			return;
		}
		
		if ((is_infinite($actual) XOR is_infinite($expected)) ||
		(is_nan($actual) OR is_nan($expected)) ||
		abs($actual - $expected) != 0) {
			throw new ComparisonFailedException(sprintf('Failed asserting that %s matches expected %s.', $this->export($actual), $this->export($expected)),
												$expected, $actual, '', '');
		}
	}
	
	public function accepts($expected, $actual) {
		return is_numeric($expected) && is_numeric($actual) && !(is_double($expected) || is_double($actual));
	}
}
?>
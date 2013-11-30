<?php
namespace eUnit\Unit\Comparator;

use eUnit\Exception\ComparisonFailedException;

class ScalarComparator extends Comparator {
	public function assertEquals($expected, $actual) {
		$expectedToCompare = $expected;
		$actualToCompare = $actual;
		
		// always compare as strings to avoid strange behaviour
		if (is_string($expected) || is_string($actual)) {
			$expectedToCompare = (string)$expectedToCompare;
			$actualToCompare = (string)$actualToCompare;
		}
		
		if ($expectedToCompare != $actualToCompare) {
			if (is_string($expected) && is_string($actual)) {
				throw new ComparisonFailedException('Failed asserting that two strings are equal.',
													$expected, $actual, $this->export($expected), $this->export($actual));
			}
		
			throw new ComparisonFailedException(sprintf('Failed asserting that %s matches expected %s.', $this->export($actual), $this->export($expected)),
												$expected, $actual, '', '');
		}
	}
	
	public function accepts($expected, $actual) {
		return ((is_scalar($expected) XOR NULL === $expected) &&
				(is_scalar($actual) XOR NULL === $actual))
				|| (is_string($expected) && is_object($actual) && method_exists($actual, '__toString'))
				|| (is_object($expected) && method_exists($expected, '__toString') && is_string($actual));
	}
}
?>
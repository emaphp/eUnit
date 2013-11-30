<?php
namespace eUnit\Unit\Comparator;

use eUnit\Exception\ComparisonFailedException;

class TypeComparator extends Comparator {
	public function assertEquals($expected, $actual) {
		if (gettype($expected) != gettype($actual)) {
			throw new ComparisonFailedException(sprintf('%s does not match expected type "%s".', $this->shortenedExport($actual), gettype($expected)),
												$expected, $actual, '', '');
		}
	}
	
	public function accepts($expected, $actual) {
		return true;
	}
}
?>
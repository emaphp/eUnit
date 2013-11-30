<?php
namespace eUnit\Unit\Comparator;

use eUnit\Exception\ComparisonFailedException;

class ResourceComparator extends Comparator {
	public function assertEquals($expected, $actual) {
		if ($expected != $actual) {
			throw new ComparisonFailedException('Failed asserting that two resources are equal.',
												$expected, $actual, $this->export($expected), $this->export($actual));
		}
	}
	
	public function accepts($expected, $actual) {
		return is_resource($expected) && is_resource($actual);
	}
}
?>
<?php
namespace eUnit\Unit\Comparator;

use eUnit\Exception\ComparisonFailedException;

class ObjectComparator extends ArrayComparator {
	public function accepts($expected, $actual) {
		return is_object($expected) && is_object($actual);
	}
	
	public function assertEquals($expected, $actual, array &$processed = array()) {
		if (get_class($actual) !== get_class($expected)) {
			throw new ComparisonFailedException(sprintf('%s is not instance of expected class "%s".', $this->export($expected), $this->export($actual)),
					$expected, $actual, $this->export($expected), $this->export($actual));
		}
		
		if (in_array(array($actual, $expected), $processed, true) ||
		in_array(array($expected, $actual), $processed, true)) {
			return;
		}
		
		$processed[] = array($actual, $expected);
		
		if ($actual !== $expected) {
			try {
				parent::assertEquals($this->toArray($expected), $this->toArray($actual), $processed);
			}
			catch (ComparisonFailedException $ce) {
				throw new ComparisonFailedException('Failed asserting that two objects are equal.',
						$expected,
						$actual,
						substr_replace($ce->expectedAsString, get_class($expected) . ' Object', 0, 5),
						substr_replace($ce->actualAsString, get_class($actual) . ' Object', 0, 5));
			}
		}
	}
}
?>
<?php
namespace eUnit\Unit\Comparator;

use eUnit\Exception\ComparisonFailedException;

class ArrayComparator extends Comparator {
	public function accepts($expected, $actual) {
		return is_array($expected) && is_array($actual);
	}
	
	public function assertEquals($expected, $actual, array &$processed = array()) {		
		$remaining = $actual;
		$expString = $actString = "Array (\n";
		$equal = true;
		
		foreach ($expected as $key => $value) {
			unset($remaining[$key]);
			
			if (!array_key_exists($key, $actual)) {
				$expString .= sprintf("    %s => %s\n", $this->export($key), $this->shortenedExport($value));
				$equal = false;
				continue;
			}
			
			try {
				$comparator = ComparatorFactory::getInstance()->getComparatorFor($value, $actual[$key]);
				$comparator->assertEquals($value, $actual[$key], $processed);
				
				$expString .= sprintf("    %s => %s\n", $this->export($key), $this->shortenedExport($value));
				$actString .= sprintf("    %s => %s\n", $this->export($key), $this->shortenedExport($actual[$key]));
			}
			catch (ComparisonFailedException $ce) {
				$expString = sprintf("    %s => %s\n", $this->export($key),
									 $ce->expectedAsString ? $this->indent($ce->expectedAsString)
									 : $this->shortenedExport($ce->expected));
				
				$actString .= sprintf("    %s => %s\n", $this->export($key),
									  $ce->actualAsString ? $this->indent($ce->actualAsString)
									  : $this->shortenedExport($ce->actual));
				$equal = false;
			}
		}
		
		foreach ($remaining as $key => $value) {
			$actString .= sprintf("    %s => %s\n", $this->export($key), $this->shortenedExport($value));
			$equal = false;
		}
		
		$expString .= ')';
		$actString .= ')';
		
		if (!$equal) {
			throw new ComparisonFailedException('Failed asserting that two arrays are equal.',
												$expected, $actual, $expString, $actString);
		}
	}
}
?>
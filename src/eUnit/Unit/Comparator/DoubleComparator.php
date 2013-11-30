<?php
namespace eUnit\Unit\Comparator;

class DoubleComparator extends NumericComparator {
	public function assertEquals($expected, $actual) {
		parent::assertEquals($expected, $actual);
	}

	public function accepts($expected, $actual) {
		return (is_double($expected) || is_double($actual)) && is_numeric($expected) && is_numeric($actual);
	}
}
?>
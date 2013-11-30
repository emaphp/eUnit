<?php
namespace eUnit\Unit\Comparator;

abstract class Comparator {
	use \eUnit\Unit\VarExport;
	
	protected function indent($lines) {
		return trim(str_replace("\n", "\n    ", $lines));
	}
	
	public abstract function accepts($expected, $actual);
	public abstract function assertEquals($expected, $actual);
}
?>
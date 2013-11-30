<?php
namespace eUnit\Unit\Constraint;

class StringContains extends Constraint {
	/**
	 * String to find
	 * @var string
	 */
	public $string;
	
	public function __construct($string) {
		$this->string = $string;
	}
	
	public function matches($haystack) {
		return strpos($haystack, $this->string) !== false;
	}
	
	public function toString() {
		return sprintf('contains "%s"', $this->string);
	}
}
?>
<?php
namespace eUnit\Unit\Constraint;

class ArrayHasKey extends Constraint {
	/**
	 * Key to find
	 * @var mixed
	 */
	public $key;
	
	public function __construct($key) {
		$this->key = $key;
	}
	
	protected function matches($array) {
		return array_key_exists($this->key, $array);
	}
	
	public function toString() {
		return 'has the key ' . $this->export($this->key);
	}
	
	protected function failureDescription($array) {
		return 'an array ' . $this->toString();
	}
}
?>
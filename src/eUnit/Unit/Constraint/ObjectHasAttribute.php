<?php
namespace eUnit\Unit\Constraint;

class ObjectHasAttribute extends Constraint {
	/**
	 * Attribute to find
	 * @var string
	 */
	public $attribute;
	
	public function __construct($attribute) {
		$this->attribute = $attribute;
	}
	
	protected function matches($object) {
		$object = new \ReflectionObject($object);
		return $object->hasProperty($this->attribute);
	}
	
	protected function failureDescription($object) {
		return sprintf('object of class "%s" %s', get_class($object), $this->toString());
	}
	
	public function toString() {
		return sprintf('has attribute "%s"', $this->attribute);
	}
}
?>
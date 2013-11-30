<?php
namespace eUnit\Package;

use eUnit\Runtime\RunTest;
use eUnit\Unit\Constraint\IsTrue;
use eUnit\Unit\Constraint\IsFalse;
use eUnit\Unit\Constraint\IsNull;
use eUnit\Unit\Constraint\IsEmpty;
use eUnit\Unit\Constraint\Equals;
use eUnit\Unit\Constraint\IsNot;
use eUnit\Unit\Constraint\GreaterThan;
use eUnit\Unit\Constraint\GreaterThanOrEqual;
use eUnit\Unit\Constraint\LesserThan;
use eUnit\Unit\Constraint\LesserThanOrEqual;
use eUnit\Unit\Constraint\IsInstanceOf;
use eUnit\Unit\Constraint\IsType;
use eUnit\Unit\Constraint\TraversableContains;
use eUnit\Unit\Constraint\StringContains;
use eUnit\Unit\Constraint\ArrayHasKey;
use eUnit\Unit\Constraint\ObjectHasAttribute;
use eMacros\Package\Package;

class AssertPackage extends Package {
	public function __construct() {
		parent::__construct('Assert');
		
		/**
		 * TESTS
		 */
		$this['run-test'] = new RunTest();
		
		/**
		 * BOOLEAN
		 */
		$this['is-true'] = function ($expression, $message = null) {
			$constraint = new IsTrue();
			$constraint->evaluate($expression);
			return $constraint;
		};
		
		$this['is-false'] = function ($expression, $message = null) {
			$constraint = new IsFalse();
			$constraint->evaluate($expression);
			return $constraint;
		};
		
		/**
		 * NULL
		 */
		$this['is-null'] = function ($expression, $message = null) {
			$constraint = new IsNull();
			$constraint->evaluate($expression);
			return $constraint;
		};
		
		$this['is-not-null'] = function ($expression, $message = null) {
			$constraint = new IsNot(new IsNull());
			$constraint->evaluate($expression);
			return $constraint;
		};
		
		/**
		 * EMPTY
		 */
		$this['is-empty'] = function ($expression, $message = null) {
			$constraint = new IsEmpty();
			$constraint->evaluate($expression);
			return $constraint;
		};
		
		$this['is-not-empty'] = function ($expression, $message = null) {
			$constraint = new IsNot(new IsEmpty());
			$constraint->evaluate($expression);
			return $constraint;
		};
		
		/**
		 * EQUALS
		 */
		$this['equals'] = function ($expected, $actual, $message = null) {
			$constraint = new Equals($expected);
			$constraint->evaluate($actual);
			return $constraint;
		};
		
		$this['not-equals'] = function ($expected, $actual, $message = null) {
			$constraint = new IsNot(new Equals($expected));
			$constraint->evaluate($actual);
			return $constraint;
		};
		
		/**
		 * GREATER THAN
		 */
		$this['greater-than'] = function ($expected, $actual, $message = null) {
			$constraint = new GreaterThan($expected);
			$constraint->evaluate($actual);
			return $constraint;
		};
		
		$this['greater-than-or-equal'] = function ($expected, $actual, $message = null) {
			$constraint = new GreaterThanOrEqual($expected);
			$constraint->evaluate($actual);
			return $constraint;
		};
		
		/**
		 * LESSER THAN
		 */
		$this['lesser-than'] = function ($expected, $actual, $message = null) {
			$constraint = new LesserThan($expected);
			$constraint->evaluate($actual);
			return $constraint;
		};
		
		$this['lesser-than-or-equal'] = function ($expected, $actual, $message = null) {
			$constraint = new LesserThanOrEqual($expected);
			$constraint->evaluate($actual);
			return $constraint;
		};
		
		/**
		 * INSTANCEOF
		 */
		$this['instance-of'] = function ($class, $value, $message = null) {
			if (!is_string($class) || (!class_exists($class) && !interface_exists($class))) {
				throw new \InvalidArgumentException("IsInstanceOf: Parameter is not a valid class/interface name.");
			}
			
			$constraint = new IsInstanceOf($class);
			$constraint->evaluate($value);
			return $constraint;
		};
		
		$this['not-instance-of'] = function ($class, $value, $message = null) {
			if (!is_string($class) || (!class_exists($class) && !interface_exists($class))) {
				throw new \InvalidArgumentException("NotInstanceOf: Parameter is not a valid class/interface name.");
			}
			
			$constraint = new IsNot(new IsInstanceOf($class));
			$constraint->evaluate($value);
			return $constraint;
		};
		
		/**
		 * TYPE
		 */
		$this['is-type'] = function ($type, $value, $message = null) {
			if (!is_string($type) || !in_array($type, IsType::$validTypes)) {
				throw new \InvalidArgumentException("IsType: Parameter is not a valid type.");
			}
			
			$constraint = new IsType($type);
			$constraint->evaluate($value);
			return $constraint;
		};
		
		$this['is-not-type'] = function ($type, $value, $message = null) {
			if (!is_string($type) || !in_array($type, IsType::$validTypes)) {
				throw new \InvalidArgumentException("IsType: Parameter is not a valid type.");
			}
			
			$constraint = new IsNot(new IsType($type));
			$constraint->evaluate($value);
			return $constraint;
		};
		
		/**
		 * CONTAINS
		 */
		$this['contains'] = function ($needle, $haystack, $message = null) {
			if (is_array($haystack) ||
            is_object($haystack) && $haystack instanceof \Traversable) {
				$constraint = new TraversableContains($needle);
			}
			elseif (is_string($haystack)) {
				$constraint = new StringContains($needle);
			}
			else {
				throw new \InvalidArgumentException("Contains: Wrong parameter type. Only array, iterator or string are expected.");
			}
			
			$constraint->evaluate($haystack);
			return $constraint;
		};
		
		$this['not-contains'] = function ($needle, $haystack, $message = null) {
			if (is_array($haystack) ||
            is_object($haystack) && $haystack instanceof \Traversable) {
				$constraint = new IsNot(new TraversableContains($needle));
			}
			elseif (is_string($haystack)) {
				$constraint = new IsNot(new StringContains($needle));
			}
			else {
				throw new \InvalidArgumentException("NotContains: Wrong parameter type. Only array, iterator or string are expected.");
			}
			
			$constraint->evaluate($haystack);
			return $constraint;
		};
		
		/**
		 * ARRAYS
		 */
		$this['array-has-key'] = function ($key, $array, $message = null) {
			if (!is_integer($key) && !is_string($key)) {
				throw new \InvalidArgumentException("ArrayHasKey: Index must be integer or string.");
			}
			
			if (!is_array($array) && !($array instanceof \ArrayAccess)) {
				throw new \InvalidArgumentException("ArrayHasKey: Only array or instances of ArrayAccess are allowed.");
			}
			
			$constraint = new ArrayHasKey($key);
			$constraint->evaluate($array);
			return $constraint;
		};
		
		$this['array-not-has-key'] = function ($key, $array, $message = null) {
			if (!is_integer($key) && !is_string($key)) {
				throw new \InvalidArgumentException("ArrayNotHasKey: Index must be integer or string.");
			}
			
			if (!is_array($array) && !($array instanceof \ArrayAccess)) {
				throw new \InvalidArgumentException("ArrayNotHasKey: Only array or instances of ArrayAccess are allowed.");
			}
			
			$constraint = new IsNot(new ArrayHasKey($key));
			$constraint->evaluate($array);
			return $constraint;
		};
		
		/**
		 * OBJECTS
		 */
		$this['object-has-attribute'] = function ($attribute, $object, $message = null) {
			if (!is_string($attribute)) {
				throw new \InvalidArgumentException("ObjectHasAttribute: Attribute is not a string.");
			}
				
			if (!is_object($object)) {
				throw new \InvalidArgumentException("ObjectHasAttribute: Invalid object.");
			}
			
			$constraint = new ObjectHasAttribute($attribute);
			$constraint->evaluate($object);
			return $constraint;
		};
		
		$this['object-not-has-attribute'] = function ($attribute, $object, $message = null) {
			if (!is_string($attribute)) {
				throw new \InvalidArgumentException("ObjectNotHasAttribute: Attribute is not a string.");
			}
				
			if (!is_object($object)) {
				throw new \InvalidArgumentException("ObjectNotHasAttribute: Invalid object.");
			}
			
			$constraint = new IsNot(new ObjectHasAttribute($attribute));
			$constraint->evaluate($object);
			return $constraint;
		};
	}
}
?>
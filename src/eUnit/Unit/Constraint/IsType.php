<?php
namespace eUnit\Unit\Constraint;

class IsType extends Constraint {
	/**
	 * Type to assert
	 * @var string
	 */
	public $type;
	
	/**
	 * Valid types
	 * @var string
	 */
	public static $validTypes = array(
		'array',
		'boolean',
		'bool',
		'float',
		'integer',
		'int',
		'null',
		'numeric',
		'object',
		'resource',
		'string',
		'scalar',
		'callable'
	);
	
	public function __construct($type) {
		$this->type = $type;
	}
	
	protected function matches($value) {
		switch ($this->type) {
			case 'numeric': {
				return is_numeric($value);
			}
		
			case 'integer':
			case 'int': {
				return is_integer($value);
			}
		
			case 'float': {
				return is_float($value);
			}
		
			case 'string': {
				return is_string($value);
			}
		
			case 'boolean':
			case 'bool': {
				return is_bool($value);
			}
		
			case 'null': {
				return is_null($value);
			}
		
			case 'array': {
				return is_array($value);
			}
		
			case 'object': {
				return is_object($value);
			}
		
			case 'resource': {
				return is_resource($value);
			}
		
			case 'scalar': {
				return is_scalar($value);
			}
		
			case 'callable': {
				return is_callable($value);
			}
		}
	}
	
	public function toString() {
		return sprintf('is of type "%s"', $this->type);
	}
}
?>
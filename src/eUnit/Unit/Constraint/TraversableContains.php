<?php
namespace eUnit\Unit\Constraint;

class TraversableContains extends Constraint {
	/**
	 * Value to find
	 * @var mixed
	 */
	public $value;
	
	public function __construct($needle) {
		$this->value = $needle;
	}
	
	protected function matches($haystack) {
		if ($haystack instanceof \SplObjectStorage) {
			return $haystack->contains($this->value);
		}
		
		foreach ($haystack as $element) {
			if ($element == $this->value) {
				return true;
			}
		}
		
		return false;
	}
	
	protected function failureDescription($haystack) {
		return sprintf('an %s %s', is_array($haystack) ? 'array' : 'iterator', $this->toString());
	}
	
	public function toString() {
		if (is_string($this->value) && strpos($this->value, "\n") !== false) {
            return 'contains "' . $this->value . '"';
        }
        else {
            return 'contains ' . $this->export($this->value);
        }
	}
}
?>
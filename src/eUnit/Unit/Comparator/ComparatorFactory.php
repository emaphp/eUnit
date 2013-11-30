<?php
namespace eUnit\Unit\Comparator;

class ComparatorFactory {
	/**
	 * Class instance
	 * @var ComparatorFactory
	 */
	protected static $instance = null;
	
	/**
	 * Comparator list
	 * @var array
	 */
	public $comparators;
	
	protected function __construct() {
		$this->comparators = array(new ObjectComparator(),
		new ResourceComparator(),
		new ArrayComparator(),
		new DoubleComparator(),
		new NumericComparator(),
		new ScalarComparator(),
		new TypeComparator());
	}
	
	public static function getInstance() {
		if (is_null(self::$instance)) {
			self::$instance = new ComparatorFactory();
		}
		
		return self::$instance;
	}
	
	public function getComparatorFor($expected, $actual) {
		foreach ($this->comparators as $comparator) {
			if ($comparator->accepts($expected, $actual)) {
				return $comparator;
			}
		}
		
		throw new \RuntimeException(sprintf('No comparator was found for comparing the types "%s" and "%s"', gettype($expected), gettype($actual)));
	}
}
?>
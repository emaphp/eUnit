<?php
namespace eUnit;

use eMacros\Environment\DefaultEnvironment;
use eMacros\Environment\ExtendedEnvironment;
use eMacros\Environment\Environment;
use eMacros\Package\CorePackage;
use eUnit\Package\AssertPackage;

abstract class eUnitTest extends \PHPUnit_Framework_TestCase {
	public static $tenv;
	
	public static function setUpBeforeClass() {
		self::$tenv = new Environment();
		self::$tenv->import(new AssertPackage);
		self::$tenv->import(new CorePackage());
	} 
}
?>
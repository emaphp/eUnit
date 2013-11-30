<?php
namespace eUnit\Assert;

use eUnit\eUnitTest;
use eUnit\Program\UnitTestProgram;
use eUnit\Unit\UnitTestStatus;

/**
 * 
 * @author emaphp
 * @group assert
 */
class AssertObjectHasAttributeTest extends eUnitTest {
	/**
	 * OBJECT-HAS-ATTRIBUTE
	 */
	public function testAssertObjectHasAttribute1() {
		$program = new UnitTestProgram('(:= _obj (new stdClass))(@name= "emma" _obj)(Assert::object-has-attribute "name" _obj)');
		$result = $program->execute(self::$tenv);
		$this->assertInstanceOf('eUnit\Unit\UnitTest', $result);
		$this->assertEquals(1, $result->assertions);
		$this->assertEquals(0, $result->failures);
		$this->assertEquals(0, $result->errors);
		$this->assertEquals('*', $result->summary);
		$this->assertEquals(UnitTestStatus::SUCCESS, $result->status);
		$this->assertEmpty($result->messages);
	}
	
	public function testAssertObjectHasAttribute2() {
		$program = new UnitTestProgram('(:= _obj (new stdClass))(Assert::object-has-attribute "name" _obj)');
		$result = $program->execute(self::$tenv);
		$this->assertInstanceOf('eUnit\Unit\UnitTest', $result);
		$this->assertEquals(0, $result->assertions);
		$this->assertEquals(1, $result->failures);
		$this->assertEquals(0, $result->errors);
		$this->assertEquals('F', $result->summary);
		$this->assertEquals(UnitTestStatus::FAILED, $result->status);
		$this->assertCount(1, $result->messages);
		$this->assertArrayHasKey(1, $result->messages);
		$this->assertEquals("Failed asserting that object of class \"stdClass\" has attribute \"name\".", $result->messages[1]);
	}
	
	/**
	 * OBJECT-NOT-HAS-ATTRIBUTE
	 */
	public function testAssertObjectNotHasAttribute1() {
		$program = new UnitTestProgram('(:= _obj (new stdClass))(@name= "emma" _obj)(Assert::object-not-has-attribute "surname" _obj)');
		$result = $program->execute(self::$tenv);
		$this->assertInstanceOf('eUnit\Unit\UnitTest', $result);
		$this->assertEquals(1, $result->assertions);
		$this->assertEquals(0, $result->failures);
		$this->assertEquals(0, $result->errors);
		$this->assertEquals('*', $result->summary);
		$this->assertEquals(UnitTestStatus::SUCCESS, $result->status);
		$this->assertEmpty($result->messages);
	}
	
	public function testAssertObjectNotHasAttribute2() {
		$program = new UnitTestProgram('(:= _obj (new stdClass))(@name= "emma" _obj)(Assert::object-not-has-attribute "name" _obj)');
		$result = $program->execute(self::$tenv);
		$this->assertInstanceOf('eUnit\Unit\UnitTest', $result);
		$this->assertEquals(0, $result->assertions);
		$this->assertEquals(1, $result->failures);
		$this->assertEquals(0, $result->errors);
		$this->assertEquals('F', $result->summary);
		$this->assertEquals(UnitTestStatus::FAILED, $result->status);
		$this->assertCount(1, $result->messages);
		$this->assertArrayHasKey(2, $result->messages);
		$this->assertEquals("Failed asserting that stdClass Object (\n    'name' => 'emma'\n) does not have attribute \"name\".", $result->messages[2]);
		
	}
}
?>
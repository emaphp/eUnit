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
class AssertInstanceOfTest extends eUnitTest {
	/**
	 * INSTANCE-OF
	 */
	public function testAssertInstanceOf1() {
		$program = new UnitTestProgram('(Assert::instance-of "stdClass" (new stdClass))');
		$result = $program->execute(self::$tenv);
		$this->assertInstanceOf('eUnit\Unit\UnitTest', $result);
		$this->assertEquals(1, $result->assertions);
		$this->assertEquals(0, $result->failures);
		$this->assertEquals(0, $result->errors);
		$this->assertEquals('*', $result->summary);
		$this->assertEquals(UnitTestStatus::SUCCESS, $result->status);
		$this->assertCount(0, $result->messages);
	}
	
	public function testAssertInstanceOf2() {
		$program = new UnitTestProgram('(Assert::instance-of "ArrayObject" (new stdClass))');
		$result = $program->execute(self::$tenv);
		$this->assertInstanceOf('eUnit\Unit\UnitTest', $result);
		$this->assertEquals(0, $result->assertions);
		$this->assertEquals(1, $result->failures);
		$this->assertEquals(0, $result->errors);
		$this->assertEquals('F', $result->summary);
		$this->assertEquals(UnitTestStatus::FAILED, $result->status);
		$this->assertCount(1, $result->messages);
		$this->assertArrayHasKey(0, $result->messages);
		$this->assertEquals("Failed asserting that stdClass Object () is an instance of class \"ArrayObject\".", $result->messages[0]);
	}
	
	/**
	 * NOT-INSTANCE-OF
	 */
	public function testAssertNotInstanceOf1() {
		$program = new UnitTestProgram('(Assert::not-instance-of "ArrayObject" (new stdClass))');
		$result = $program->execute(self::$tenv);
		$this->assertInstanceOf('eUnit\Unit\UnitTest', $result);
		$this->assertEquals(1, $result->assertions);
		$this->assertEquals(0, $result->failures);
		$this->assertEquals(0, $result->errors);
		$this->assertEquals('*', $result->summary);
		$this->assertEquals(UnitTestStatus::SUCCESS, $result->status);
		$this->assertCount(0, $result->messages);
	}
	
	public function testAssertNotInstanceOf2() {
		$program = new UnitTestProgram('(Assert::not-instance-of "ArrayObject" (new ArrayObject (array 1 2)))');
		$result = $program->execute(self::$tenv);
		$this->assertInstanceOf('eUnit\Unit\UnitTest', $result);
		$this->assertEquals(0, $result->assertions);
		$this->assertEquals(1, $result->failures);
		$this->assertEquals(0, $result->errors);
		$this->assertEquals('F', $result->summary);
		$this->assertEquals(UnitTestStatus::FAILED, $result->status);
		$this->assertCount(1, $result->messages);
		$this->assertArrayHasKey(0, $result->messages);
		$this->assertEquals("Failed asserting that ArrayObject Object (\n    0 => 1\n    1 => 2\n) is not instance of class \"ArrayObject\".", $result->messages[0]);
	}
}
?>
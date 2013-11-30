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
class AssertGreaterThanTest extends eUnitTest {
	/**
	 * GREATER-THAN
	 */
	public function testAssertGreaterThan1() {
		$program = new UnitTestProgram('(Assert::greater-than 1 2)');
		$result = $program->execute(self::$tenv);
		$this->assertInstanceOf('eUnit\Unit\UnitTest', $result);
		$this->assertEquals(1, $result->assertions);
		$this->assertEquals(0, $result->failures);
		$this->assertEquals(0, $result->errors);
		$this->assertEquals('*', $result->summary);
		$this->assertEquals(UnitTestStatus::SUCCESS, $result->status);
		$this->assertCount(0, $result->messages);
	}
	
	public function testAssertGreaterThan2() {
		$program = new UnitTestProgram('(Assert::greater-than 2 2)');
		$result = $program->execute(self::$tenv);
		$this->assertInstanceOf('eUnit\Unit\UnitTest', $result);
		$this->assertEquals(0, $result->assertions);
		$this->assertEquals(1, $result->failures);
		$this->assertEquals(0, $result->errors);
		$this->assertEquals('F', $result->summary);
		$this->assertEquals(UnitTestStatus::FAILED, $result->status);
		$this->assertCount(1, $result->messages);
		$this->assertArrayHasKey(0, $result->messages);
		$this->assertEquals("Failed asserting that 2 is greater than 2.", $result->messages[0]);
	}
	
	/**
	 * GREATER-THAN-OR-EQUAL
	 */
	public function testAssertGreaterThanOrEqual1() {
		$program = new UnitTestProgram('(Assert::greater-than-or-equal 1 2)');
		$result = $program->execute(self::$tenv);
		$this->assertInstanceOf('eUnit\Unit\UnitTest', $result);
		$this->assertEquals(1, $result->assertions);
		$this->assertEquals(0, $result->failures);
		$this->assertEquals(0, $result->errors);
		$this->assertEquals('*', $result->summary);
		$this->assertEquals(UnitTestStatus::SUCCESS, $result->status);
		$this->assertCount(0, $result->messages);
	}
	
	public function testAssertGreaterThanOrEqual2() {
		$program = new UnitTestProgram('(Assert::greater-than-or-equal 2 2)');
		$result = $program->execute(self::$tenv);
		$this->assertInstanceOf('eUnit\Unit\UnitTest', $result);
		$this->assertEquals(1, $result->assertions);
		$this->assertEquals(0, $result->failures);
		$this->assertEquals(0, $result->errors);
		$this->assertEquals('*', $result->summary);
		$this->assertEquals(UnitTestStatus::SUCCESS, $result->status);
		$this->assertCount(0, $result->messages);
	}
	
	public function testAssertGreaterThanOrEqual3() {
		$program = new UnitTestProgram('(Assert::greater-than-or-equal 3 2)');
		$result = $program->execute(self::$tenv);
		$this->assertInstanceOf('eUnit\Unit\UnitTest', $result);
		$this->assertEquals(0, $result->assertions);
		$this->assertEquals(1, $result->failures);
		$this->assertEquals(0, $result->errors);
		$this->assertEquals('F', $result->summary);
		$this->assertEquals(UnitTestStatus::FAILED, $result->status);
		$this->assertCount(1, $result->messages);
		$this->assertArrayHasKey(0, $result->messages);
		$this->assertEquals("Failed asserting that 2 is greater than or equal to 3.", $result->messages[0]);
	}
}
?>
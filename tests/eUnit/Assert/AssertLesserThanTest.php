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
class AssertLesserThanTest extends eUnitTest {
	/**
	 * LESSER-THAN
	 */
	public function testAssertLesserThan1() {
		$program = new UnitTestProgram('(Assert::lesser-than 3 2)');
		$result = $program->execute(self::$tenv);
		$this->assertInstanceOf('eUnit\Unit\UnitTest', $result);
		$this->assertEquals(1, $result->assertions);
		$this->assertEquals(0, $result->failures);
		$this->assertEquals(0, $result->errors);
		$this->assertEquals('*', $result->summary);
		$this->assertEquals(UnitTestStatus::SUCCESS, $result->status);
		$this->assertCount(0, $result->messages);
	}
	
	public function testAssertLesserThan2() {
		$program = new UnitTestProgram('(Assert::lesser-than 2 2)');
		$result = $program->execute(self::$tenv);
		$this->assertInstanceOf('eUnit\Unit\UnitTest', $result);
		$this->assertEquals(0, $result->assertions);
		$this->assertEquals(1, $result->failures);
		$this->assertEquals(0, $result->errors);
		$this->assertEquals('F', $result->summary);
		$this->assertEquals(UnitTestStatus::FAILED, $result->status);
		$this->assertCount(1, $result->messages);
		$this->assertArrayHasKey(0, $result->messages);
		$this->assertEquals("Failed asserting that 2 is lesser than 2.", $result->messages[0]);
	}
	
	/**
	 * LESSER-THAN-OR-EQUAL
	 */
	public function testAssertLesserThanOrEqual1() {
		$program = new UnitTestProgram('(Assert::lesser-than-or-equal 3 2)');
		$result = $program->execute(self::$tenv);
		$this->assertInstanceOf('eUnit\Unit\UnitTest', $result);
		$this->assertEquals(1, $result->assertions);
		$this->assertEquals(0, $result->failures);
		$this->assertEquals(0, $result->errors);
		$this->assertEquals('*', $result->summary);
		$this->assertEquals(UnitTestStatus::SUCCESS, $result->status);
		$this->assertCount(0, $result->messages);
	}
	
	public function testAssertLesserThanOrEqual2() {
		$program = new UnitTestProgram('(Assert::lesser-than-or-equal 2 2)');
		$result = $program->execute(self::$tenv);
		$this->assertInstanceOf('eUnit\Unit\UnitTest', $result);
		$this->assertEquals(1, $result->assertions);
		$this->assertEquals(0, $result->failures);
		$this->assertEquals(0, $result->errors);
		$this->assertEquals('*', $result->summary);
		$this->assertEquals(UnitTestStatus::SUCCESS, $result->status);
		$this->assertCount(0, $result->messages);
	}
	
	public function testAssertLesserThanOrEqual3() {
		$program = new UnitTestProgram('(Assert::lesser-than-or-equal 1 2)');
		$result = $program->execute(self::$tenv);
		$this->assertInstanceOf('eUnit\Unit\UnitTest', $result);
		$this->assertEquals(0, $result->assertions);
		$this->assertEquals(1, $result->failures);
		$this->assertEquals(0, $result->errors);
		$this->assertEquals('F', $result->summary);
		$this->assertEquals(UnitTestStatus::FAILED, $result->status);
		$this->assertCount(1, $result->messages);
		$this->assertArrayHasKey(0, $result->messages);
		$this->assertEquals("Failed asserting that 2 is lesser than or equal to 1.", $result->messages[0]);
	}
}
?>
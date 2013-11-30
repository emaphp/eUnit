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
class AssertEmptyTest extends eUnitTest {
	/**
	 * IS-EMPTY
	 */
	public function testAssertEmpty1() {
		$program = new UnitTestProgram('(Assert::is-empty (array))');
		$result = $program->execute(self::$tenv);
		$this->assertInstanceOf('eUnit\Unit\UnitTest', $result);
		$this->assertEquals(1, $result->assertions);
		$this->assertEquals(0, $result->failures);
		$this->assertEquals(0, $result->errors);
		$this->assertEquals('*', $result->summary);
		$this->assertEquals(UnitTestStatus::SUCCESS, $result->status);
		$this->assertEmpty($result->messages);
	}
	
	public function testAssertEmpty2() {
		$program = new UnitTestProgram('(Assert::is-empty (array 1 2 3))');
		$result = $program->execute(self::$tenv);
		$this->assertInstanceOf('eUnit\Unit\UnitTest', $result);
		$this->assertEquals(0, $result->assertions);
		$this->assertEquals(1, $result->failures);
		$this->assertEquals(0, $result->errors);
		$this->assertEquals('F', $result->summary);
		$this->assertEquals(UnitTestStatus::FAILED, $result->status);
		$this->assertCount(1, $result->messages);
		$this->assertArrayHasKey(0, $result->messages);
		$this->assertEquals("Failed asserting that Array (\n    0 => 1\n    1 => 2\n    2 => 3\n) is empty.", $result->messages[0]);
	}
	
	/**
	 * IS-NOT-EMPTY
	 */
	public function testAssertNotEmpty1() {
		$program = new UnitTestProgram('(Assert::is-not-empty 1)');
		$result = $program->execute(self::$tenv);
		$this->assertInstanceOf('eUnit\Unit\UnitTest', $result);
		$this->assertEquals(1, $result->assertions);
		$this->assertEquals(0, $result->failures);
		$this->assertEquals(0, $result->errors);
		$this->assertEquals('*', $result->summary);
		$this->assertEquals(UnitTestStatus::SUCCESS, $result->status);
		$this->assertEmpty($result->messages);
	}
	
	public function testAssertNotEmpty2() {
		$program = new UnitTestProgram('(Assert::is-not-empty "")');
		$result = $program->execute(self::$tenv);
		$this->assertInstanceOf('eUnit\Unit\UnitTest', $result);
		$this->assertEquals(0, $result->assertions);
		$this->assertEquals(1, $result->failures);
		$this->assertEquals(0, $result->errors);
		$this->assertEquals('F', $result->summary);
		$this->assertEquals(UnitTestStatus::FAILED, $result->status);
		$this->assertCount(1, $result->messages);
		$this->assertArrayHasKey(0, $result->messages);
		$this->assertEquals("Failed asserting that '' is not empty.", $result->messages[0]);
	}
}
?>
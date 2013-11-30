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
class AssertEqualsTest extends eUnitTest {
	/**
	 * EQUALS
	 */
	public function testAssertEquals1() {
		$program = new UnitTestProgram('(Assert::equals 1 1)');
		$result = $program->execute(self::$tenv);
		$this->assertInstanceOf('eUnit\Unit\UnitTest', $result);
		$this->assertEquals(1, $result->assertions);
		$this->assertEquals(0, $result->failures);
		$this->assertEquals(0, $result->errors);
		$this->assertEquals('*', $result->summary);
		$this->assertEquals(UnitTestStatus::SUCCESS, $result->status);
		$this->assertEmpty($result->messages);
	}
	
	public function testAssertEquals2() {
		$program = new UnitTestProgram('(Assert::equals 1 2)');
		$result = $program->execute(self::$tenv);
		$this->assertInstanceOf('eUnit\Unit\UnitTest', $result);
		$this->assertEquals(0, $result->assertions);
		$this->assertEquals(1, $result->failures);
		$this->assertEquals(0, $result->errors);
		$this->assertEquals('F', $result->summary);
		$this->assertEquals(UnitTestStatus::FAILED, $result->status);
		$this->assertCount(1, $result->messages);
		$this->assertArrayHasKey(0, $result->messages);
		$this->assertEquals("Failed asserting that 2 matches expected 1.", $result->messages[0]);
	}
	
	public function testAssertEquals3() {
		$program = new UnitTestProgram('(Assert::equals 5.1 5.10)');
		$result = $program->execute(self::$tenv);
		$this->assertInstanceOf('eUnit\Unit\UnitTest', $result);
		$this->assertEquals(1, $result->assertions);
		$this->assertEquals(0, $result->failures);
		$this->assertEquals(0, $result->errors);
		$this->assertEquals('*', $result->summary);
		$this->assertEquals(UnitTestStatus::SUCCESS, $result->status);
		$this->assertEmpty($result->messages);
	}
	
	public function testAssertEquals4() {
		$program = new UnitTestProgram('(Assert::equals 5.1 5.15)');
		$result = $program->execute(self::$tenv);
		$this->assertInstanceOf('eUnit\Unit\UnitTest', $result);
		$this->assertEquals(0, $result->assertions);
		$this->assertEquals(1, $result->failures);
		$this->assertEquals(0, $result->errors);
		$this->assertEquals('F', $result->summary);
		$this->assertEquals(UnitTestStatus::FAILED, $result->status);
		$this->assertCount(1, $result->messages);
		$this->assertArrayHasKey(0, $result->messages);
		$this->assertEquals("Failed asserting that 5.15 matches expected 5.1.", $result->messages[0]);
	}
	
	public function testAssertEquals5() {
		$program = new UnitTestProgram('(Assert::equals "hello" "hello")');
		$result = $program->execute(self::$tenv);
		$this->assertInstanceOf('eUnit\Unit\UnitTest', $result);
		$this->assertEquals(1, $result->assertions);
		$this->assertEquals(0, $result->failures);
		$this->assertEquals(0, $result->errors);
		$this->assertEquals('*', $result->summary);
		$this->assertEquals(UnitTestStatus::SUCCESS, $result->status);
		$this->assertEmpty($result->messages);
	}
	
	public function testAssertEquals6() {
		$program = new UnitTestProgram('(Assert::equals "Hello" "hello")');
		$result = $program->execute(self::$tenv);
		$this->assertInstanceOf('eUnit\Unit\UnitTest', $result);
		$this->assertEquals(0, $result->assertions);
		$this->assertEquals(1, $result->failures);
		$this->assertEquals(0, $result->errors);
		$this->assertEquals('F', $result->summary);
		$this->assertEquals(UnitTestStatus::FAILED, $result->status);
		$this->assertCount(1, $result->messages);
		$this->assertArrayHasKey(0, $result->messages);
		$this->assertEquals("Failed asserting that two strings are equal.\n--- Expected\n+++ Actual\n@@ @@\n-'Hello'\n+'hello'\n", $result->messages[0]);
	}
	
	public function testAssertEquals7() {
		$program = new UnitTestProgram('(Assert::equals (array 1 2) (array 1 2))');
		$result = $program->execute(self::$tenv);
		$this->assertInstanceOf('eUnit\Unit\UnitTest', $result);
		$this->assertEquals(1, $result->assertions);
		$this->assertEquals(0, $result->failures);
		$this->assertEquals(0, $result->errors);
		$this->assertEquals('*', $result->summary);
		$this->assertEquals(UnitTestStatus::SUCCESS, $result->status);
		$this->assertEmpty($result->messages);
	}
	
	public function testAssertEquals8() {
		$program = new UnitTestProgram('(Assert::equals (array 1 2) (array 1 2 3))');
		$result = $program->execute(self::$tenv);
		$this->assertInstanceOf('eUnit\Unit\UnitTest', $result);
		$this->assertEquals(0, $result->assertions);
		$this->assertEquals(1, $result->failures);
		$this->assertEquals(0, $result->errors);
		$this->assertEquals('F', $result->summary);
		$this->assertEquals(UnitTestStatus::FAILED, $result->status);
		$this->assertCount(1, $result->messages);
		$this->assertArrayHasKey(0, $result->messages);
		$this->assertEquals("Failed asserting that two arrays are equal.\n--- Expected\n+++ Actual\n@@ @@\n Array (\n     0 => 1\n     1 => 2\n+    2 => 3\n )\n", $result->messages[0]);
	}
	
	public function testAssertEquals9() {
		$program = new UnitTestProgram('(Assert::equals (new ArrayObject (array 1 2)) (new ArrayObject (array 1 2)))');
		$result = $program->execute(self::$tenv);
		$this->assertInstanceOf('eUnit\Unit\UnitTest', $result);
		$this->assertEquals(1, $result->assertions);
		$this->assertEquals(0, $result->failures);
		$this->assertEquals(0, $result->errors);
		$this->assertEquals('*', $result->summary);
		$this->assertEquals(UnitTestStatus::SUCCESS, $result->status);
		$this->assertEmpty($result->messages);
	}
	
	public function testAssertEquals10() {
		$program = new UnitTestProgram('(Assert::equals (new ArrayObject (array 1 2)) (new ArrayObject (array 1 2 3)))');
		$result = $program->execute(self::$tenv);
		$this->assertInstanceOf('eUnit\Unit\UnitTest', $result);
		$this->assertEquals(0, $result->assertions);
		$this->assertEquals(1, $result->failures);
		$this->assertEquals(0, $result->errors);
		$this->assertEquals('F', $result->summary);
		$this->assertEquals(UnitTestStatus::FAILED, $result->status);
		$this->assertCount(1, $result->messages);
		$this->assertArrayHasKey(0, $result->messages);
		$this->assertEquals("Failed asserting that two objects are equal.\n--- Expected\n+++ Actual\n@@ @@\n ArrayObject Object (\n     0 => 1\n     1 => 2\n+    2 => 3\n )\n", $result->messages[0]);
	}
	
	public function testAssertEquals11() {
		$program = new UnitTestProgram('(Assert::equals 1 (array 1 2))');
		$result = $program->execute(self::$tenv);
		$this->assertInstanceOf('eUnit\Unit\UnitTest', $result);
		$this->assertEquals(0, $result->assertions);
		$this->assertEquals(1, $result->failures);
		$this->assertEquals(0, $result->errors);
		$this->assertEquals('F', $result->summary);
		$this->assertEquals(UnitTestStatus::FAILED, $result->status);
		$this->assertCount(1, $result->messages);
		$this->assertArrayHasKey(0, $result->messages);
		$this->assertEquals("Array (...) does not match expected type \"integer\".", $result->messages[0]);
	}
	
	/**
	 * NOT-EQUALS
	 */
	public function testAssertNotEquals1() {
		$program = new UnitTestProgram('(Assert::not-equals 1 2)');
		$result = $program->execute(self::$tenv);
		$this->assertInstanceOf('eUnit\Unit\UnitTest', $result);
		$this->assertEquals(1, $result->assertions);
		$this->assertEquals(0, $result->failures);
		$this->assertEquals(0, $result->errors);
		$this->assertEquals('*', $result->summary);
		$this->assertEquals(UnitTestStatus::SUCCESS, $result->status);
		$this->assertEmpty($result->messages);
	}
	
	public function testAssertNotEquals2() {
		$program = new UnitTestProgram('(Assert::not-equals 1 1)');
		$result = $program->execute(self::$tenv);
		$this->assertInstanceOf('eUnit\Unit\UnitTest', $result);
		$this->assertEquals(0, $result->assertions);
		$this->assertEquals(1, $result->failures);
		$this->assertEquals(0, $result->errors);
		$this->assertEquals('F', $result->summary);
		$this->assertEquals(UnitTestStatus::FAILED, $result->status);
		$this->assertCount(1, $result->messages);
		$this->assertArrayHasKey(0, $result->messages);
		$this->assertEquals("Failed asserting that 1 is not equal to 1.", $result->messages[0]);
	}
	
	public function testAssertNotEquals3() {
		$program = new UnitTestProgram('(Assert::not-equals 5.1 5.11)');
		$result = $program->execute(self::$tenv);
		$this->assertInstanceOf('eUnit\Unit\UnitTest', $result);
		$this->assertEquals(1, $result->assertions);
		$this->assertEquals(0, $result->failures);
		$this->assertEquals(0, $result->errors);
		$this->assertEquals('*', $result->summary);
		$this->assertEquals(UnitTestStatus::SUCCESS, $result->status);
		$this->assertEmpty($result->messages);
	}
	
	public function testAssertNotEquals4() {
		$program = new UnitTestProgram('(Assert::not-equals 5.1 5.1)');
		$result = $program->execute(self::$tenv);
		$this->assertInstanceOf('eUnit\Unit\UnitTest', $result);
		$this->assertEquals(0, $result->assertions);
		$this->assertEquals(1, $result->failures);
		$this->assertEquals(0, $result->errors);
		$this->assertEquals('F', $result->summary);
		$this->assertEquals(UnitTestStatus::FAILED, $result->status);
		$this->assertCount(1, $result->messages);
		$this->assertArrayHasKey(0, $result->messages);
		$this->assertEquals("Failed asserting that 5.1 is not equal to 5.1.", $result->messages[0]);
	}
	
	public function testAssertNotEquals5() {
		$program = new UnitTestProgram('(Assert::not-equals "Hello" "hello")');
		$result = $program->execute(self::$tenv);
		$this->assertInstanceOf('eUnit\Unit\UnitTest', $result);
		$this->assertEquals(1, $result->assertions);
		$this->assertEquals(0, $result->failures);
		$this->assertEquals(0, $result->errors);
		$this->assertEquals('*', $result->summary);
		$this->assertEquals(UnitTestStatus::SUCCESS, $result->status);
		$this->assertEmpty($result->messages);
	}
	
	public function testAssertNotEquals6() {
		$program = new UnitTestProgram('(Assert::not-equals "hello" "hello")');
		$result = $program->execute(self::$tenv);
		$this->assertInstanceOf('eUnit\Unit\UnitTest', $result);
		$this->assertEquals(0, $result->assertions);
		$this->assertEquals(1, $result->failures);
		$this->assertEquals(0, $result->errors);
		$this->assertEquals('F', $result->summary);
		$this->assertEquals(UnitTestStatus::FAILED, $result->status);
		$this->assertCount(1, $result->messages);
		$this->assertArrayHasKey(0, $result->messages);
		$this->assertEquals("Failed asserting that 'hello' is not equal to <string:hello>.", $result->messages[0]);
	}
	
	public function testAssertNotEquals7() {
		$program = new UnitTestProgram('(Assert::not-equals (array 1 2) (array 1 2 3))');
		$result = $program->execute(self::$tenv);
		$this->assertInstanceOf('eUnit\Unit\UnitTest', $result);
		$this->assertEquals(1, $result->assertions);
		$this->assertEquals(0, $result->failures);
		$this->assertEquals(0, $result->errors);
		$this->assertEquals('*', $result->summary);
		$this->assertEquals(UnitTestStatus::SUCCESS, $result->status);
		$this->assertEmpty($result->messages);
	}
	
	public function testAssertNotEquals8() {
		$program = new UnitTestProgram('(Assert::not-equals (array 1 2 3) (array 1 2 3))');
		$result = $program->execute(self::$tenv);
		$this->assertInstanceOf('eUnit\Unit\UnitTest', $result);
		$this->assertEquals(0, $result->assertions);
		$this->assertEquals(1, $result->failures);
		$this->assertEquals(0, $result->errors);
		$this->assertEquals('F', $result->summary);
		$this->assertEquals(UnitTestStatus::FAILED, $result->status);
		$this->assertCount(1, $result->messages);
		$this->assertArrayHasKey(0, $result->messages);
		$this->assertEquals("Failed asserting that Array (\n    0 => 1\n    1 => 2\n    2 => 3\n) is not equal to Array (\n    0 => 1\n    1 => 2\n    2 => 3\n).", $result->messages[0]);
	}
	
	public function testAssertNotEquals9() {
		$program = new UnitTestProgram('(Assert::not-equals (new ArrayObject (array 1 2)) (new ArrayObject (array 1 2 3)))');
		$result = $program->execute(self::$tenv);
		$this->assertInstanceOf('eUnit\Unit\UnitTest', $result);
		$this->assertEquals(1, $result->assertions);
		$this->assertEquals(0, $result->failures);
		$this->assertEquals(0, $result->errors);
		$this->assertEquals('*', $result->summary);
		$this->assertEquals(UnitTestStatus::SUCCESS, $result->status);
		$this->assertEmpty($result->messages);
	}
	
	public function testAssertNotEquals10() {
		$program = new UnitTestProgram('(Assert::not-equals (new ArrayObject (array 1 2)) (new ArrayObject (array 1 2 )))');
		$result = $program->execute(self::$tenv);
		$this->assertInstanceOf('eUnit\Unit\UnitTest', $result);
		$this->assertEquals(0, $result->assertions);
		$this->assertEquals(1, $result->failures);
		$this->assertEquals(0, $result->errors);
		$this->assertEquals('F', $result->summary);
		$this->assertEquals(UnitTestStatus::FAILED, $result->status);
		$this->assertCount(1, $result->messages);
		$this->assertArrayHasKey(0, $result->messages);
		$this->assertEquals("Failed asserting that ArrayObject Object (\n    0 => 1\n    1 => 2\n) is not equal to ArrayObject Object (\n    0 => 1\n    1 => 2\n).", $result->messages[0]);
	}
	
	public function testAssertNotEquals11() {
		$program = new UnitTestProgram('(Assert::not-equals 1 (array 1 2))');
		$result = $program->execute(self::$tenv);
		$this->assertInstanceOf('eUnit\Unit\UnitTest', $result);
		$this->assertEquals(1, $result->assertions);
		$this->assertEquals(0, $result->failures);
		$this->assertEquals(0, $result->errors);
		$this->assertEquals('*', $result->summary);
		$this->assertEquals(UnitTestStatus::SUCCESS, $result->status);
		$this->assertCount(0, $result->messages);
	}
}
?>
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
class AssertArrayHasKeyTest extends eUnitTest {
	/**
	 * ARRAY-HAS-KEY
	 */
	public function testAssertArrayHasKey1() {
		$program = new UnitTestProgram('(Assert::array-has-key 2 (array 1 2 3))');
		$result = $program->execute(self::$tenv);
		$this->assertInstanceOf('eUnit\Unit\UnitTest', $result);
		$this->assertEquals(1, $result->assertions);
		$this->assertEquals(0, $result->failures);
		$this->assertEquals(0, $result->errors);
		$this->assertEquals('*', $result->summary);
		$this->assertEquals(UnitTestStatus::SUCCESS, $result->status);
		$this->assertEmpty($result->messages);
	}
	
	public function testAssertArrayHasKey2() {
		$program = new UnitTestProgram('(Assert::array-has-key 3 (array 1 2 3))');
		$result = $program->execute(self::$tenv);
		$this->assertInstanceOf('eUnit\Unit\UnitTest', $result);
		$this->assertEquals(0, $result->assertions);
		$this->assertEquals(1, $result->failures);
		$this->assertEquals(0, $result->errors);
		$this->assertEquals('F', $result->summary);
		$this->assertEquals(UnitTestStatus::FAILED, $result->status);
		$this->assertCount(1, $result->messages);
		$this->assertArrayHasKey(0, $result->messages);
		$this->assertEquals("Failed asserting that an array has the key 3.", $result->messages[0]);
	}
	
	public function testAssertArrayHasKey3() {
		$program = new UnitTestProgram('(Assert::array-has-key "name" (array ("name" "Jhon") ("surname" "Doe")))');
		$result = $program->execute(self::$tenv);
		$this->assertInstanceOf('eUnit\Unit\UnitTest', $result);
		$this->assertEquals(1, $result->assertions);
		$this->assertEquals(0, $result->failures);
		$this->assertEquals(0, $result->errors);
		$this->assertEquals('*', $result->summary);
		$this->assertEquals(UnitTestStatus::SUCCESS, $result->status);
		$this->assertEmpty($result->messages);
	}
	
	public function testAssertArrayHasKey4() {
		$program = new UnitTestProgram('(Assert::array-has-key "age" (array ("name" "Jhon") ("surname" "Doe")))');
		$result = $program->execute(self::$tenv);
		$this->assertInstanceOf('eUnit\Unit\UnitTest', $result);
		$this->assertEquals(0, $result->assertions);
		$this->assertEquals(1, $result->failures);
		$this->assertEquals(0, $result->errors);
		$this->assertEquals('F', $result->summary);
		$this->assertEquals(UnitTestStatus::FAILED, $result->status);
		$this->assertCount(1, $result->messages);
		$this->assertArrayHasKey(0, $result->messages);
		$this->assertEquals("Failed asserting that an array has the key 'age'.", $result->messages[0]);
	}
	
	/**
	 * ARRAY-NOT-HAS-KEY
	 */
	public function testAssertArrayNotHasKey1() {
		$program = new UnitTestProgram('(Assert::array-not-has-key 3 (array 1 2 3))');
		$result = $program->execute(self::$tenv);
		$this->assertInstanceOf('eUnit\Unit\UnitTest', $result);
		$this->assertEquals(1, $result->assertions);
		$this->assertEquals(0, $result->failures);
		$this->assertEquals(0, $result->errors);
		$this->assertEquals('*', $result->summary);
		$this->assertEquals(UnitTestStatus::SUCCESS, $result->status);
		$this->assertEmpty($result->messages);
	}
	
	public function testAssertArrayNotHasKey2() {
		$program = new UnitTestProgram('(Assert::array-not-has-key 2 (array 1 2 3))');
		$result = $program->execute(self::$tenv);
		$this->assertInstanceOf('eUnit\Unit\UnitTest', $result);
		$this->assertEquals(0, $result->assertions);
		$this->assertEquals(1, $result->failures);
		$this->assertEquals(0, $result->errors);
		$this->assertEquals('F', $result->summary);
		$this->assertEquals(UnitTestStatus::FAILED, $result->status);
		$this->assertCount(1, $result->messages);
		$this->assertArrayHasKey(0, $result->messages);
		$this->assertEquals("Failed asserting that Array (\n    0 => 1\n    1 => 2\n    2 => 3\n) does not have the key 2.", $result->messages[0]);
	}
	
	public function testAssertArrayNotHasKey3() {
		$program = new UnitTestProgram('(Assert::array-not-has-key "age" (array ("name" "Jhon") ("surname" "Doe")))');
		$result = $program->execute(self::$tenv);
		$this->assertInstanceOf('eUnit\Unit\UnitTest', $result);
		$this->assertEquals(1, $result->assertions);
		$this->assertEquals(0, $result->failures);
		$this->assertEquals(0, $result->errors);
		$this->assertEquals('*', $result->summary);
		$this->assertEquals(UnitTestStatus::SUCCESS, $result->status);
		$this->assertEmpty($result->messages);
	}
	
	public function testAssertArrayNotHasKey4() {
		$program = new UnitTestProgram('(Assert::array-not-has-key "surname" (array ("name" "Jhon") ("surname" "Doe")))');
		$result = $program->execute(self::$tenv);
		$this->assertInstanceOf('eUnit\Unit\UnitTest', $result);
		$this->assertEquals(0, $result->assertions);
		$this->assertEquals(1, $result->failures);
		$this->assertEquals(0, $result->errors);
		$this->assertEquals('F', $result->summary);
		$this->assertEquals(UnitTestStatus::FAILED, $result->status);
		$this->assertCount(1, $result->messages);
		$this->assertArrayHasKey(0, $result->messages);
		$this->assertEquals("Failed asserting that Array (\n    'name' => 'Jhon'\n    'surname' => 'Doe'\n) does not have the key 'surname'.", $result->messages[0]);
	}
}
?>
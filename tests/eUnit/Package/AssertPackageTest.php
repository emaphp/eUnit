<?php
namespace eUnit;

use eUnit\Program\UnitTestProgram;
use eUnit\Unit\UnitTest;
use eUnit\Unit\UnitTestStatus;

/**
 * 
 * @author emaphp
 * @group assert
 */
class AssertPackageTest extends eUnitTest {
	public function testAssert1() {
		$program = new UnitTestProgram('(Assert::is-true true)(Assert::is-false true)');
		$result = $program->execute(self::$tenv);
		$this->assertInstanceOf('eUnit\Unit\UnitTest', $result);
		$this->assertEquals(1, $result->assertions);
		$this->assertEquals(1, $result->failures);
		$this->assertEquals('*F', $result->summary);
		$this->assertEquals(UnitTestStatus::FAILED, $result->status);
	}
	
	public function testAssertError1() {
		$program = new UnitTestProgram('(Assert::is-null (intval))');
		$result = $program->execute(self::$tenv);
		$this->assertInstanceOf('eUnit\Unit\UnitTest', $result);
		$this->assertEquals(0, $result->assertions);
		$this->assertEquals(0, $result->failures);
		$this->assertEquals(1, $result->errors);
		$this->assertEquals('E', $result->summary);
		$this->assertEquals(UnitTestStatus::ERROR, $result->status);
	}
	
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testRunTest1() {
		$program = new UnitTestProgram('(run-test)');
		$result = $program->execute(self::$tenv);
	}
	
	public function testRunTest2() {
		$program = new UnitTestProgram('(run-test (Assert::is-true true)(Assert::is-true false))');
		$result = $program->execute(self::$tenv);
		$this->assertInstanceOf('eUnit\Unit\UnitTest', $result);
		$this->assertEquals(UnitTestStatus::FAILED, $result->status);
		$this->assertEquals(1, $result->assertions);
		$this->assertEquals(1, $result->failures);
		$this->assertEquals('*F', $result->summary);
		$this->assertEquals(1, count($result->tests));
		$this->assertArrayHasKey(0, $result->tests);
		$this->assertInstanceOf('eUnit\Unit\UnitTest', $result->tests[0]);
		$this->assertEquals(1, $result->tests[0]->assertions);
		$this->assertEquals(1, $result->tests[0]->failures);
		$this->assertEquals('*F', $result->tests[0]->summary);
		$this->assertEquals(UnitTestStatus::FAILED, $result->tests[0]->status);
	}
	
	public function testRunTest3() {
		$program = new UnitTestProgram('(run-test "SimpleTest" (Assert::is-true true)(Assert::is-true false)(Assert::is-null null))');
		$result = $program->execute(self::$tenv);
		$this->assertInstanceOf('eUnit\Unit\UnitTest', $result);
		$this->assertEquals(UnitTestStatus::FAILED, $result->status);
		$this->assertEquals(2, $result->assertions);
		$this->assertEquals(1, $result->failures);
		$this->assertEquals(0, $result->errors);
		$this->assertEquals('*F*', $result->summary);
		$this->assertEquals(1, count($result->tests));
		$this->assertArrayHasKey('SimpleTest', $result->tests);
		$this->assertInstanceOf('eUnit\Unit\UnitTest', $result->tests['SimpleTest']);
		$this->assertEquals(2, $result->tests['SimpleTest']->assertions);
		$this->assertEquals(1, $result->tests['SimpleTest']->failures);
		$this->assertEquals(0, $result->tests['SimpleTest']->errors);
		$this->assertEquals('*F*', $result->tests['SimpleTest']->summary);
		$this->assertEquals(UnitTestStatus::FAILED, $result->tests['SimpleTest']->status);
	}
	
	public function testRunTest4() {
		$program = new UnitTestProgram('(run-test "SimpleTest" (Assert::is-true true)(Assert::is-null null))(run-test "AnotherTest" (Assert::is-false false))');
		$result = $program->execute(self::$tenv);
		$this->assertInstanceOf('eUnit\Unit\UnitTest', $result);
		$this->assertEquals(UnitTestStatus::SUCCESS, $result->status);
		$this->assertEquals(3, $result->assertions);
		$this->assertEquals(0, $result->failures);
		$this->assertEquals(0, $result->errors);
		$this->assertEquals('***', $result->summary);
		$this->assertEquals(2, count($result->tests));
		
		$this->assertArrayHasKey('SimpleTest', $result->tests);
		$this->assertInstanceOf('eUnit\Unit\UnitTest', $result->tests['SimpleTest']);
		$this->assertEquals(2, $result->tests['SimpleTest']->assertions);
		$this->assertEquals(0, $result->tests['SimpleTest']->failures);
		$this->assertEquals(0, $result->tests['SimpleTest']->errors);
		$this->assertEquals('**', $result->tests['SimpleTest']->summary);
		$this->assertEquals(UnitTestStatus::SUCCESS, $result->tests['SimpleTest']->status);
		
		$this->assertArrayHasKey('AnotherTest', $result->tests);
		$this->assertInstanceOf('eUnit\Unit\UnitTest', $result->tests['AnotherTest']);
		$this->assertEquals(1, $result->tests['AnotherTest']->assertions);
		$this->assertEquals(0, $result->tests['AnotherTest']->failures);
		$this->assertEquals(0, $result->tests['AnotherTest']->errors);
		$this->assertEquals('*', $result->tests['AnotherTest']->summary);
		$this->assertEquals(UnitTestStatus::SUCCESS, $result->tests['AnotherTest']->status);
	}
	
	public function testRunTest5() {
		$program = new UnitTestProgram('(run-test "SimpleTest" (Assert::is-true true)(Assert::is-null 1))(run-test "AnotherTest" (Assert::is-false false))');
		$result = $program->execute(self::$tenv);
		$this->assertInstanceOf('eUnit\Unit\UnitTest', $result);
		$this->assertEquals(UnitTestStatus::FAILED, $result->status);
		$this->assertEquals(2, $result->assertions);
		$this->assertEquals(1, $result->failures);
		$this->assertEquals(0, $result->errors);
		$this->assertEquals('*F*', $result->summary);
		$this->assertEquals(2, count($result->tests));
	
		$this->assertArrayHasKey('SimpleTest', $result->tests);
		$this->assertInstanceOf('eUnit\Unit\UnitTest', $result->tests['SimpleTest']);
		$this->assertEquals(1, $result->tests['SimpleTest']->assertions);
		$this->assertEquals(1, $result->tests['SimpleTest']->failures);
		$this->assertEquals(0, $result->tests['SimpleTest']->errors);
		$this->assertEquals('*F', $result->tests['SimpleTest']->summary);
		$this->assertEquals(UnitTestStatus::FAILED, $result->tests['SimpleTest']->status);
	
		$this->assertArrayHasKey('AnotherTest', $result->tests);
		$this->assertInstanceOf('eUnit\Unit\UnitTest', $result->tests['AnotherTest']);
		$this->assertEquals(1, $result->tests['AnotherTest']->assertions);
		$this->assertEquals(0, $result->tests['AnotherTest']->failures);
		$this->assertEquals(0, $result->tests['AnotherTest']->errors);
		$this->assertEquals('*', $result->tests['AnotherTest']->summary);
		$this->assertEquals(UnitTestStatus::SUCCESS, $result->tests['AnotherTest']->status);
	}
	
	public function testRunTest6() {
		$program = new UnitTestProgram('(run-test "SimpleTest" (Assert::is-true true)(Assert::is-null)(Assert::is-false false))(run-test "AnotherTest" (Assert::is-false false))');
		$result = $program->execute(self::$tenv);
		$this->assertInstanceOf('eUnit\Unit\UnitTest', $result);
		$this->assertEquals(UnitTestStatus::ERROR, $result->status);
		$this->assertEquals(2, $result->assertions);
		$this->assertEquals(0, $result->failures);
		$this->assertEquals(1, $result->errors);
		$this->assertEquals('*E*', $result->summary);
		$this->assertEquals(2, count($result->tests));
	
		$this->assertArrayHasKey('SimpleTest', $result->tests);
		$this->assertInstanceOf('eUnit\Unit\UnitTest', $result->tests['SimpleTest']);
		$this->assertEquals(1, $result->tests['SimpleTest']->assertions);
		$this->assertEquals(0, $result->tests['SimpleTest']->failures);
		$this->assertEquals(1, $result->tests['SimpleTest']->errors);
		$this->assertEquals('*E', $result->tests['SimpleTest']->summary);
		$this->assertEquals(UnitTestStatus::ERROR, $result->tests['SimpleTest']->status);
	
		$this->assertArrayHasKey('AnotherTest', $result->tests);
		$this->assertInstanceOf('eUnit\Unit\UnitTest', $result->tests['AnotherTest']);
		$this->assertEquals(1, $result->tests['AnotherTest']->assertions);
		$this->assertEquals(0, $result->tests['AnotherTest']->failures);
		$this->assertEquals(0, $result->tests['AnotherTest']->errors);
		$this->assertEquals('*', $result->tests['AnotherTest']->summary);
		$this->assertEquals(UnitTestStatus::SUCCESS, $result->tests['AnotherTest']->status);
	}
}
?>
<?php
namespace eUnit\Runtime;

use eMacros\Applicable;
use eMacros\Scope;
use eMacros\GenericList;
use eMacros\Literal;
use eMacros\Symbol;
use eUnit\Unit\UnitTest;
use eUnit\Unit\UnitTestStatus;
use eUnit\Unit\Constraint\Constraint;
use eUnit\Exception\AssertionFailedException;

class RunTest implements Applicable {
	public function apply(Scope $scope, GenericList $arguments) {
		$nargs = count($arguments);
		
		if ($nargs == 0) {
			throw new \BadFunctionCallException("RunTest: No parameters found.");
		}
		
		$test = new UnitTest();
		$test->status = UnitTestStatus::SUCCESS;
		
		set_error_handler(function ($errno, $errstr, $errfile, $errline, $errcontext) {
			throw new \ErrorException($errstr, $errno, 0, $errfile, $errline);
		});
		
		//obtain test name, if any
		if ($arguments[0] instanceof Symbol || $arguments[0] instanceof Literal) {
			$test->name = $arguments[0]->evaluate($scope);
		}
		
		$i = is_null($test->name) ? 0 : 1;
		
		for ($j = 0; $i < $nargs; $j++, $i++) {
			try {
				$value = $arguments[$i]->evaluate($scope);
		
				if ($value instanceof UnitTest) {
					if ($value->status == UnitTestStatus::ERROR) {
						$test->status = UnitTestStatus::ERROR;
					}
					elseif ($value->status == UnitTestStatus::FAILED && $test->status != UnitTestStatus::ERROR) {
						$test->status = UnitTestStatus::FAILED;
					}
					
					$test->assertions += $value->assertions;
					$test->failures += $value->failures;
					$test->errors += $value->errors;
					$test->summary .= $value->summary;
					
					if (is_null($value->name)) {
						$test->tests[] = $value;
					}
					else {
						$test->tests[$value->name] = $value;
					}
				}
				elseif ($value instanceof Constraint) {
					$test->summary .= '*';
					$test->assertions++;
				}
			}
			catch (AssertionFailedException $ae) {
				$test->status = UnitTestStatus::FAILED;
				$test->failures++;
				$test->summary .= 'F';
				$test->messages[$j] = $ae->getMessage();
			}
			catch (\ErrorException $e) {
				$test->status = UnitTestStatus::ERROR;
				$test->errors++;
				$test->summary .= 'E';
				$test->messages[$j] = $e->getMessage();
			
				break;
			}
		}
		
		restore_error_handler();
		return $test;
	}
}
?>
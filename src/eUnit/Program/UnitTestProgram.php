<?php
namespace eUnit\Program;

use eMacros\Environment\Environment;
use eUnit\Unit\UnitTest;
use eUnit\Exception\AssertionFailedException;
use eUnit\Unit\UnitTestStatus;
use eUnit\Unit\Constraint\Constraint;
use eMacros\Program\Program;

class UnitTestProgram extends Program {
	public function execute(Environment $env) {
		$env->arguments = array_slice(func_get_args(), 1);
		
		$test = new UnitTest();
		$test->status = UnitTestStatus::SUCCESS;
		
		set_error_handler(function ($errno, $errstr, $errfile, $errline, $errcontext) {
			throw new \ErrorException($errstr, $errno, 0, $errfile, $errline);
		});
				
		for ($i = 0, $n = count($this->expressions); $i < $n; $i++) {
			try {
				$value = $this->expressions[$i]->evaluate($env);
		
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
				$test->messages[$i] = $ae->getMessage();
			}
			catch (\ErrorException $e) {
				$test->status = UnitTestStatus::ERROR;
				$test->errors++;
				$test->summary .= 'E';
				$test->messages[$i] = $e->getMessage();
				
				break;
			}
		}
		
		restore_error_handler();
		return $test;
	}
}
?>
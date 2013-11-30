<?php
namespace eUnit\Unit;

abstract class UnitTestStatus {
	/**
	 * Success status
	 * @var int
	 */
	const SUCCESS = 0;
	
	/**
	 * Failed status
	 * @var int
	 */
	const FAILED = 1;
	
	/**
	 * Error status
	 * @var int
	 */
	const ERROR = 2;
}
?>
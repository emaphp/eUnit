<?php
namespace eUnit\Exception;

class AssertionFailedException extends \Exception {
	public function __construct($message) {
		$this->message = $message;
	}
}
?>
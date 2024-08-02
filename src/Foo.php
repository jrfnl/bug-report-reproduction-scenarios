<?php

namespace Jrf\PHPUnit\Scenario;

class Foo {
	private $depCount = 0;
	function throwDeprecation($message = '') {
		if ('' === $message)
		{
			$message = 'Passing an empty string message is deprecated in ' . __METHOD__;
		}
		trigger_error($message, E_USER_DEPRECATED);
		return true;
	}

	function throwNotice() {
		trigger_error('notice', E_USER_NOTICE);
		return true;
	}

	function throwWarning() {
		trigger_error('warning', E_USER_WARNING);
		return true;
	}
}

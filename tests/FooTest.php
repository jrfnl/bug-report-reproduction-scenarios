<?php

namespace Jrf\PHPUnit1011\Example\Tests;

use Exception;
use Jrf\PHPUnit1011\Example\Foo;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\IgnoreDeprecations;
use PHPUnit\Framework\Attributes\WithoutErrorHandler;
use PHPUnit\Framework\TestCase;

class FooTest extends TestCase
{
	public function testExpectDeprecationMessage() {
		if (method_exists($this, 'expectDeprecationMessage') === false) {
			$this->markTestSkipped('This test only runs on PHPUnit < 10');
		}

		$this->expectDeprecation();
		$this->expectDeprecationMessage( 'foo' );

		\trigger_error( 'foo', \E_USER_DEPRECATED );
	}

	public function testExpectUserDeprecationMessageNOTIgnoringDeprecations() {
		if (method_exists($this, 'expectUserDeprecationMessage') === false) {
			$this->markTestSkipped('This test only runs on PHPUnit 11+');
		}

		$this->expectUserDeprecationMessage( 'foo' );

		\trigger_error( 'foo', \E_USER_DEPRECATED );
	}
	#[IgnoreDeprecations]
	public function testExpectUserDeprecationMessageANDIgnoringDeprecations() {
		if (method_exists($this, 'expectUserDeprecationMessage') === false) {
			$this->markTestSkipped('This test only runs on PHPUnit 11+');
		}

		$this->expectUserDeprecationMessage( 'foo' );

		\trigger_error( 'foo', \E_USER_DEPRECATED );
	}

	public function testPcreHasUtf8Support() {
		$this->assertIsBool(Foo::pcreHasUtf8Support());
	}

	public function testStreamToNonWritableFileWithPHPUnitErrorHandler() {
		// Create an unwritable file.
		$filename = tempnam(sys_get_temp_dir(), 'RLT');
		if (file_put_contents($filename, 'foo')) {
			chmod($filename, 0444);
		}

		try {
			Foo::openFile($filename);
		} catch (Exception $e) {
			// This "Failed to open stream" exception is expected.
		}

		// Now verify the original file is unchanged.
		$contents = file_get_contents($filename);
		$this->assertSame('foo', $contents);

		chmod($filename, 0755);
		unlink($filename);
	}

	#[WithoutErrorHandler]
	public function testStreamToNonWritableFileWithoutPHPUnitErrorHandler() {
		// Create an unwritable file.
		$filename = tempnam(sys_get_temp_dir(), 'RLT');
		if (file_put_contents($filename, 'foo')) {
			chmod($filename, 0444);
		}

		try {
			Foo::openFile($filename);
		} catch (Exception $e) {
			// This "Failed to open stream" exception is expected.
		}

		// Now verify the original file is unchanged.
		$contents = file_get_contents($filename);
		$this->assertSame('foo', $contents);

		chmod($filename, 0755);
		unlink($filename);
	}

	public function testStreamToInvalidFile() {
		$filename = tempnam(sys_get_temp_dir(), 'RLT') . '/missing/directory';

		$this->expectException(Exception::class);
		// First character (F) can be upper or lowercase depending on PHP version.
		$this->expectExceptionMessage('ailed to open stream');

		Foo::openFile($filename);
	}
}

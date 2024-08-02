<?php

namespace Jrf\PHPUnit\Scenario\Tests;

use Jrf\PHPUnit\Scenario\Deprecation\ExpectUserDeprecation;
use Jrf\PHPUnit\Scenario\Foo;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class FooTest extends TestCase {
	use ExpectUserDeprecation;

	private $classUnderTest;
	private $firstDone = false;

	/**
	 * Initializes the test mock.
	 */
	protected function setUp(): void
	{
		parent::setUp();
		$this->classUnderTest = new Foo();
	}
	protected function tearDown(): void
	{
		parent::tearDown();
	}

	#[DataProvider('dataDeprecation')]
	public function testHappyPath($message)
    {
		$this->expectUserDeprecationMessage($message);
		$this->classUnderTest->throwDeprecation( $message );
	}

	#[DataProvider('dataDeprecation')]
	public function testHappyPathWithMultipleAssertions($message)
    {
		$this->expectUserDeprecationMessage($message);
		$this->assertTrue($this->classUnderTest->throwDeprecation( $message ));
		$this->assertFalse(false);
	}

	#[DataProvider('dataDeprecation')]
	public function testUnhappyPath($message)
	{
		$this->expectUserDeprecationMessage('Test Unhappy Path');
		$this->classUnderTest->throwDeprecation($message);
	}

	#[DataProvider('dataDeprecation')]
	public function testUnhappyPathWithMultipleAssertions($message)
    {
		$this->expectUserDeprecationMessage('Test Unhappy Path');
		$this->assertTrue($this->classUnderTest->throwDeprecation( $message ));
		$this->assertFalse(false);
	}

	public static function dataDeprecation(): array
	{
		return [
			'1st' => array('First deprecation'),
			'2nd' => array('Second deprecation'),
			'3rd' => array('Third deprecation'),
		];
	}

	public function testAfterUnhappyPathWithMultipleAssertions()
	{
		$this->assertTrue(true);
		$this->assertTrue(true);
	}

    // public function testNotice()
    // {
	// 	$this->assertTrue($this->classUnderTest->throwNotice());
	// 	$this->assertFalse($this->classUnderTest->throwNotice());
    // }

    // public function testWarning()
    // {
	// 	$this->assertTrue($this->classUnderTest->throwWarning());
    // }
}

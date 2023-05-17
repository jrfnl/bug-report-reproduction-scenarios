<?php

namespace Jrf\PHPUnitPolyfills\Tests;

use Exception;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;

/**
 * Basic test for the PHPUnit version-based TestCase setup.
 */
final class PolyfilledTest extends TestCase {

	/**
	 * Keep track of how often the PHPUnit native `setUpBeforeClass()` method was called/
	 * called the `set_up_before_class()` method.
	 *
	 * @var int
	 */
	private static $beforeClass = 0;

	/**
	 * Keep track of how often the PHPUnit native `setUp()` method was called/
	 * called the `set_up()` method.
	 *
	 * @var int
	 */
	private static $before = 0;

	/**
	 * Keep track of how often the PHPUnit native `assertPreConditions()` method was called/
	 * called the `assert_pre_conditions()` method.
	 *
	 * @var int
	 */
	private static $preConditions = 0;

	/**
	 * Keep track of how often the PHPUnit native `assertPostConditions()` method was called/
	 * called the `assert_post_conditions()` method.
	 *
	 * @var int
	 */
	private static $postConditions = 0;

	/**
	 * Keep track of how often the PHPUnit native `tearDown()` method was called/
	 * called the `tear_down()` method.
	 *
	 * @var int
	 */
	private static $after = 0;

	/**
	 * This method is called before the first test of this test class is run.
	 *
	 * @return void
	 */
	public static function set_up_before_class() {
		++self::$beforeClass;
	}

	/**
	 * This method is called before each test.
	 *
	 * @return void
	 */
	protected function set_up() {
		++self::$before;
	}

	/**
	 * This method is called before the execution of a test starts and after set_up() is called.
	 *
	 * @return void
	 */
	protected function assert_pre_conditions() {
		++self::$preConditions;
	}

	/**
	 * This method is called before the execution of a test ends and before tear_down() is called.
	 *
	 * @return void
	 */
	protected function assert_post_conditions() {
		++self::$postConditions;
	}

	/**
	 * This method is called after each test.
	 *
	 * @return void
	 */
	protected function tear_down() {
		++self::$after;
	}

	/**
	 * This method is called after the last test of this test class is run.
	 *
	 * @return void
	 */
	public static function tear_down_after_class() {
		// Reset.
		self::$beforeClass    = 0;
		self::$before         = 0;
		self::$preConditions  = 0;
		self::$postConditions = 0;
		self::$after          = 0;
	}

	/**
	 * Test that the fixture method overloads have been triggered and run correctly.
	 *
	 * Note: Can't really test `tear_down_after_class()`, but if everything else works, that should too.
	 *
	 * @dataProvider dataHaveFixtureMethodsBeenTriggered
	 *
	 * @param int $expectedBeforeClass    Value expected for the $beforeClass property.
	 * @param int $expectedBefore         Value expected for the $before property.
	 * @param int $expectedAfter          Value expected for the $after property.
	 * @param int $expectedPreConditions  Value expected for the $preConditions property.
	 * @param int $expectedPostConditions Value expected for the $postConditions property.
	 *
	 * @return void
	 */
	public function testHaveFixtureMethodsBeenTriggered(
		$expectedBeforeClass,
		$expectedBefore,
		$expectedAfter,
		$expectedPreConditions,
		$expectedPostConditions
	) {
		$this->assertSame(
			$expectedBeforeClass,
			self::$beforeClass,
			"Failed to verify that set_up_before_class() was triggered $expectedBeforeClass time(s). Actual: "
				. self::$beforeClass
		);
		$this->assertSame(
			$expectedBefore,
			self::$before,
			"Failed to verify that set_up() was triggered $expectedBefore time(s). Actual: "
				. self::$before
		);
		$this->assertSame(
			$expectedAfter,
			self::$after,
			"Failed to verify that tear_down() was triggered $expectedAfter time(s). Actual: "
				. self::$after
		);

		$this->assertSame(
			$expectedPreConditions,
			self::$preConditions,
			"Failed to verify that assert_pre_conditions() was triggered $expectedPreConditions time(s). Actual: "
				. self::$preConditions
		);
		$this->assertSame(
			$expectedPostConditions,
			self::$postConditions,
			"Failed to verify that assert_post_conditions() was triggered $expectedPostConditions time(s). Actual: "
				. self::$postConditions
		);
	}

	/**
	 * Data provider for the testHaveFixtureMethodsBeenTriggered() test.
	 *
	 * @return array[]
	 */
	public static function dataHaveFixtureMethodsBeenTriggered() {
		return [
			[ 1, 1, 0, 1, 0 ],
			[ 1, 2, 1, 2, 1 ],
			[ 1, 3, 2, 3, 2 ],
		];
	}

	/**
	 * Test availability of trait polyfilled PHPUnit methods [1].
	 *
	 * @return void
	 *
	 * @throws Exception For testing purposes.
	 */
	public function testAvailabilityExpectExceptionObjectTrait() {
		$exception = new Exception( 'message', 101 );
		$this->expectExceptionObject( $exception );

		throw new Exception( 'message', 101 );
	}

	/**
	 * Test availability of trait polyfilled PHPUnit methods [2].
	 *
	 * @return void
	 */
	public function testAvailabilityAssertIsTypeTrait() {
		self::assertIsInt( self::$beforeClass );
	}

	/**
	 * Test availability of trait polyfilled PHPUnit methods [3].
	 *
	 * @return void
	 */
	public function testAvailabilityAssertStringContainsTrait() {
		$this->assertStringContainsString( 'foo', 'foobar' );
	}

	/**
	 * Test availability of trait polyfilled PHPUnit methods [4].
	 *
	 * @return void
	 */
	public function testAvailabilityAssertEqualsSpecializationsTrait() {
		static::assertEqualsIgnoringCase( 'a', 'A' );
	}

	/**
	 * Test availability of trait polyfilled PHPUnit methods [5].
	 *
	 * @return void
	 */
	public function testAvailabilityExpectPHPExceptionTrait() {
		$this->expectDeprecation();

		\trigger_error( 'foo', \E_USER_DEPRECATED );
	}

	/**
	 * Test availability of trait polyfilled PHPUnit methods [6].
	 *
	 * @return void
	 *
	 * @throws Exception For testing purposes.
	 */
	public function testAvailabilityExpectExceptionMessageMatchesTrait() {
		$this->expectException( '\Exception' );
		$this->expectExceptionMessageMatches( '`^a poly[a-z]+ [a-zA-Z0-9_]+ me(s){2}age$`i' );

		throw new Exception( 'A polymorphic exception message' );
	}

	/**
	 * Test availability of trait polyfilled PHPUnit methods [8].
	 *
	 * @return void
	 */
	public function testAvailabilityAssertionRenamesTrait() {
		$this->assertMatchesRegularExpression( '/foo/', 'foobar' );
	}

	/**
	 * Verify availability of trait polyfilled PHPUnit methods [9].
	 *
	 * @return void
	 */
	public function testAvailabilityAssertNumericTypeTrait() {
		self::assertNan( \acos( 8 ) );
	}

	/**
	 * Test availability of trait polyfilled PHPUnit methods [10].
	 *
	 * @return void
	 *
	 * @throws Exception For testing purposes.
	 */
	public function testAvailabilityExpectExceptionTrait() {
		$this->expectException( '\Exception' );
		$this->expectExceptionMessage( 'message' );

		throw new Exception( 'message' );
	}

	/**
	 * Verify availability of trait polyfilled PHPUnit methods [11].
	 *
	 * @return void
	 */
	public function testAvailabilityAssertFileDirectory() {
		$path = __DIR__ . \DIRECTORY_SEPARATOR;
		$this->assertDirectoryExists( $path );
	}

	/**
	 * Verify availability of trait polyfilled PHPUnit methods [12].
	 *
	 * @return void
	 */
	public function testAvailabilityAssertClosedResource() {
		$resource = \fopen( __FILE__, 'r' );
		\fclose( $resource );

		$this->assertIsClosedResource( $resource );
	}

	/**
	 * Verify availability of trait polyfilled PHPUnit methods [13].
	 *
	 * @return void
	 */
	public function testAvailabilityEqualToSpecializations() {
		self::assertThat( [ 2, 3, 1 ], $this->equalToCanonicalizing( [ 3, 2, 1 ] ) );
	}
}

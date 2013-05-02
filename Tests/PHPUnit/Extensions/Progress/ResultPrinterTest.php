<?php

/**
 * @package PHPUnit-Progress\Test
 * @group core
 */
class ResultPrinterTest extends PHPUnit_Framework_TestCase {

	/**
	 *
	 */
	public static function setUpBeforeClass() {
		require_once __DIR__ . '/../../../../PHPUnit/Extensions/Progress/ResultPrinter.php';
	}

	/**
	 * Simple test to prove the change for issue https://github.com/Maher4Ever/phpunit-progress/issues/1 is both
	 * backwards and * forwards compatible.
	 *
	 * This tests only oproves that it is "currently" compatible. So if you are above version 3.7.11 it should pass, if
	 * you are below the version then it also passes...
	 */
	public function testDeriveAllCompletelyImplementedMethodName() {
		$object = new PHPUnit_Extensions_Progress_ResultPrinter();

		$method = new ReflectionMethod($object, 'deriveAllCompletelyImplementedMethodName');
		$method->setAccessible(true);

		$result = $method->invoke($object, new PHPUnit_Framework_TestResult(), true);

		$version = new PHPUnit_Runner_Version();

		if (version_compare($version->id(), '3.7.11') === -1) {
			$this->assertEquals('allCompletlyImplemented', $result);
		} else {
			$this->assertEquals('allCompletelyImplemented', $result);
		}

	}

}
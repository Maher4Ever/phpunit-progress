<?php

/**
 * @package PHPUnit-Progress\Test
 * @group core
 */
class ResultPrinterTest extends PHPUnit_Framework_TestCase {

	/**
	 * Simple test to prove the change for issue https://github.com/Maher4Ever/phpunit-progress/issues/1 is both
	 * backwards and * forwards compatible.
	 *
	 * @dataProvider providerTestDeriveAllCompletelyImplementedMethodName
	 *
	 * @param PHPUnit_Extensions_Progress_ResultPrinter $object
	 * @param ReflectionMethod $method
	 * @param string $version
	 * @param int $expected
	 */
	public function testDeriveAllCompletelyImplementedMethodName(PHPUnit_Extensions_Progress_ResultPrinter $object,
			ReflectionMethod $method, $version, $expected) {
		$this->assertEquals($expected, $method->invoke($object, $version, true));
	}

	/**
	 * Provider for testMethodVersionCompare()
	 *
	 * Returns TestCase Structure:
	 * 		{$method, $methodParam, $expectedReturnValue}
	 *
	 * @return array
	 */
	public function providerTestDeriveAllCompletelyImplementedMethodName() {
		require_once __DIR__ . '/../../../../PHPUnit/Extensions/Progress/ResultPrinter.php';
		$method = new ReflectionMethod(
			'PHPUnit_Extensions_Progress_ResultPrinter',
			'deriveAllCompletelyImplementedMethodName'
		);
		$method->setAccessible(true);
		$object = new PHPUnit_Extensions_Progress_ResultPrinter();
		return array(
			array($object, $method, '2', 'allCompletlyImplemented'),
			array($object, $method, '3.7.10', 'allCompletlyImplemented'),
			array($object, $method, '3.7.11', 'allCompletelyImplemented'), // The version where the name was changed
			array($object, $method, '3.8', 'allCompletelyImplemented'),
			array($object, $method, '100', 'allCompletelyImplemented'),
		);
	}
}
--TEST--
phpunit Number - Only tests with errors and colors enabled 
--FILE--
<?php
$group     = 'errors';
$testClass = 'NumberTest';

$_SERVER['argv'][1] = '--group';
$_SERVER['argv'][2] = $group;
$_SERVER['argv'][3] = '--colors';
$_SERVER['argv'][4] = dirname(__FILE__) . "/_files/${testClass}.php";

require_once 'PHPUnit/Autoload.php';
PHPUnit_TextUI_Command::main();
?>
--EXPECTF--
%r(.+31.+E.+)+%r

Errors:

  1) NumberTest::testMathStillWorks[31m
     NumberException: Division by zero![0m[36m
     # %s:%i
     # %s:%i
     # %s:%i[0m

Finished in %i second%S
[31m%i test, 0 assertions, %i errors[0m

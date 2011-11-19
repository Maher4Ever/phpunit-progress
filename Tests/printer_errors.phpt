--TEST--
phpunit Number - Only tests with errors 
--FILE--
<?php
$group     = 'errors';
$testClass = 'NumberTest';

$_SERVER['argv'][1] = '--group';
$_SERVER['argv'][2] = $group;
$_SERVER['argv'][3] = dirname(__FILE__) . "/_files/${testClass}.php";

require_once 'PHPUnit/Autoload.php';
PHPUnit_TextUI_Command::main();
?>
--EXPECTF--
%rE+%r

Errors:

  1) NumberTest::testMathStillWorks
     NumberException: Division by zero!
     # %s:%i
     # %s:%i
     # %s:%i

Finished in %i second%S
%i test, 0 assertions, %i errors

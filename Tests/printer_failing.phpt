--TEST--
phpunit Number - Only failing tests 
--FILE--
<?php
$group     = 'failing';
$testClass = 'NumberTest';

$_SERVER['argv'][1] = '--group';
$_SERVER['argv'][2] = $group;
$_SERVER['argv'][3] = dirname(__FILE__) . "/_files/${testClass}.php";

require_once 'PHPUnit/Autoload.php';
PHPUnit_TextUI_Command::main();
?>
--EXPECTF--
%rF+%r

Failures:

  1) NumberTest::testThatMyMathTeacherSucked
     Failed asserting that 10 is identical to 1.
     # %s:%i
     # %s:%i

  2) NumberTest::testThatMyMathTeacherSuckedEvenMore
     Failed asserting that 'I don't know!' is identical to -1.
     # %s:%i
     # %s:%i

Finished in %i second%S
2 tests, 2 assertions, 2 failures

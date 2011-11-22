--TEST--
phpunit Number - Only failing tests and colors enabled  
--FILE--
<?php
$group     = 'failing';
$testClass = 'NumberTest';

$_SERVER['argv'][1] = '--group';
$_SERVER['argv'][2] = $group;
$_SERVER['argv'][3] = '--colors';
$_SERVER['argv'][4] = dirname(__FILE__) . "/_files/${testClass}.php";

require_once 'PHPUnit/Autoload.php';
PHPUnit_TextUI_Command::main();
?>
--EXPECTF--
[31mF[0m[31mF[0m

Failures:

  1) NumberTest::testThatMyMathTeacherSucked[31m
     Failed asserting that 10 is identical to 1.[0m[36m
     # %s:%i
     # %s:%i[0m

  2) NumberTest::testThatMyMathTeacherSuckedEvenMore[31m
     Failed asserting that 'I don't know!' is identical to -1.[0m[36m
     # %s:%i
     # %s:%i[0m

Finished in %i second%S
[31m2 tests, 2 assertions, 2 failures[0m

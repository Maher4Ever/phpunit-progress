--TEST--
phpunit empryTest - An empty test 
--FILE--
<?php
$testClass = 'emptyTest';

$_SERVER['argv'][1] = dirname(__FILE__) . "/_files/${testClass}.php";

require_once 'PHPUnit/Autoload.php';
PHPUnit_TextUI_Command::main();
?>
--EXPECTF--
%rF+%r

Failures:

  1) Warning
     No tests found in class "emptyTest".
     # %s:%i

Finished in %i second%S
1 test, 0 assertions, 1 failures

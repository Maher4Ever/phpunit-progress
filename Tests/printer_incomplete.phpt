--TEST--
phpunit Number - Only incomplete tests 
--FILE--
<?php
$group     = 'incomplete';
$testClass = 'NumberTest';

$_SERVER['argv'][1] = '--group';
$_SERVER['argv'][2] = $group;
$_SERVER['argv'][3] = dirname(__FILE__) . "/_files/${testClass}.php";

require_once 'PHPUnit/Autoload.php';
PHPUnit_TextUI_Command::main();
?>
--EXPECTF--
%rI+%r

Finished in %i second%S
1 test, 0 assertions, 1 incomplete

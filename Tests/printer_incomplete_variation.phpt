--TEST--
phpunit Number - Only incomplete tests and colors enabled  
--FILE--
<?php
$group     = 'incomplete';
$testClass = 'NumberTest';

$_SERVER['argv'][1] = '--group';
$_SERVER['argv'][2] = $group;
$_SERVER['argv'][3] = '--colors';
$_SERVER['argv'][4] = dirname(__FILE__) . "/_files/${testClass}.php";

require_once 'PHPUnit/Autoload.php';
PHPUnit_TextUI_Command::main();
?>
--EXPECTF--
[33mI[0m

Finished in %i second%S
[33m1 test, 0 assertions, 1 incomplete[0m

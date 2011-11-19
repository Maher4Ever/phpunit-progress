--TEST--
phpunit Number - Only skipped tests and colors enabled  
--FILE--
<?php
$group     = 'skipped';
$testClass = 'NumberTest';

$_SERVER['argv'][1] = '--group';
$_SERVER['argv'][2] = $group;
$_SERVER['argv'][3] = '--colors';
$_SERVER['argv'][4] = dirname(__FILE__) . "/_files/${testClass}.php";

require_once 'PHPUnit/Autoload.php';
PHPUnit_TextUI_Command::main();
?>
--EXPECTF--
[33mS[0m[33mS[0m

Finished in %i second%S
[33m2 tests, 0 assertions, 2 skipped[0m

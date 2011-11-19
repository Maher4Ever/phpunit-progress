--TEST--
phpunit Number - Only passing tests and colors enabled  
--FILE--
<?php
$group     = 'passing';
$testClass = 'NumberTest';

$_SERVER['argv'][1] = '--group';
$_SERVER['argv'][2] = $group;
$_SERVER['argv'][3] = '--colors';
$_SERVER['argv'][4] = dirname(__FILE__) . "/_files/${testClass}.php";

require_once 'PHPUnit/Autoload.php';
PHPUnit_TextUI_Command::main();
?>
--EXPECTF--
[32m.[0m[32m.[0m

Finished in %i second%S
[32m2 tests, 2 assertions[0m

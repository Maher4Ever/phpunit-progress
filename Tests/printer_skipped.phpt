--TEST--
phpunit Number - Only skipped tests 
--FILE--
<?php
$group     = 'skipped';
$testClass = 'NumberTest';

$_SERVER['argv'][1] = '--group';
$_SERVER['argv'][2] = $group;
$_SERVER['argv'][3] = dirname(__FILE__) . "/_files/${testClass}.php";

require_once 'PHPUnit/Autoload.php';
PHPUnit_TextUI_Command::main();
?>
--EXPECTF--
%rS+%r

Finished in %i second%S
%i tests, 0 assertions, %i skipped

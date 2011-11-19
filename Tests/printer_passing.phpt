--TEST--
phpunit Number - Only passing tests 
--FILE--
<?php
$group     = 'passing';
$testClass = 'NumberTest';

$_SERVER['argv'][1] = '--group';
$_SERVER['argv'][2] = $group;
$_SERVER['argv'][3] = dirname(__FILE__) . "/_files/${testClass}.php";

require_once 'PHPUnit/Autoload.php';
PHPUnit_TextUI_Command::main();
?>
--EXPECTF--
%r[.]+%r

Finished in %i second%S
%i tests, %i assertions

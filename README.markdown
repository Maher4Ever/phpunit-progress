Progress results printer for PHPUnit
====================================

This PHPUnit extention makes the printed tests results look similar to
Rspec's default formatter called "progress".

The progress printer tries to focus on the tests results only; That's why
a lot of the info printed by the default PHPUnit printer was removed.

Test results have the same colors and spacing as the Rspec's results.
If you want to see how results look, check out the screenshot below!


Usage
-----

There is more than one way to use this printer with PHPUnit. Probably
the easiest way is to pass the the printer (with it's location) as 
arguments to the `phpunit` command.

So clone this repo to someplace on your machine. Then copy the following
command and paste it to your terminal
(**Don't** forget to replace the things inside brackets)

    phpunit --include-path [Path to your clone of this repo] \
    --printer PHPUnit_Extensions_Progress_ResultPrinter   \
    --colors [Tests Path]

If you want to see a the skipped and incomplete tests too in the results,
you can add the `--verbose` argument the the command above.

Another way is to use a `phpunit.xml` file and pass its location as an argument.
If you are intrested in this way, I would recommend that you read [PHPUnit's
docs][docs].


Screenshot
----------

Here is how the results of this extention look using the progress printer:
![Progress printer results in the terminal][shot]

[docs]:http://www.phpunit.de/manual/current/en/index.html
[shot]:https://github.com/Maher4Ever/phpunit-progress/raw/master/screenshot.png

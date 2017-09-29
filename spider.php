#!/usr/bin/env php
<?php

if (true === version_compare(phpversion(), '5.4.0', '<')) {
    echo 'Your version of PHP is ' . phpversion() . PHP_EOL;
    echo 'PHP 5.4.0 or higher is required' . PHP_EOL;
    exit;
}

error_reporting(-1);
date_default_timezone_set('Europe/Berlin');

set_error_handler(
    function ($errno, $errstr, $errfile, $errline, array $errcontext) {
        throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
    }
);

chdir(__DIR__);
if (true === file_exists('./vendor/autoload.php')) {
    require_once './vendor/autoload.php';
} else {
    echo 'You must set up the project dependencies, run the following commands:' . PHP_EOL;
    echo 'curl -s https://getcomposer.org/installer | php' . PHP_EOL;
    echo 'php composer.phar install' . PHP_EOL;
    exit;
}

use Spider\Spider;

try {
    $spider = new Spider;
    $spider->run();
} catch (Exception $e) {
    var_dump($e->getMessage());
}

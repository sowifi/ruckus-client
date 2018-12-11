<?php

use VCR\VCR;

if (!file_exists(__DIR__ . "/../vendor/autoload.php")) {
    die("\n[ERROR] You need to run composer before running the test suite.\n");
}
require_once __DIR__ . '/../vendor/autoload.php';

// Due to VCR not supporting PHP7
$phpunitAliases = [
    '\PHPUnit\Framework\Test' => '\PHPUnit_Framework_Test',
    '\PHPUnit\Framework\TestListener' => '\PHPUnit_Framework_TestListener',
    '\PHPUnit\Framework\Warning' => '\PHPUnit_Framework_Warning',
    '\PHPUnit\Framework\AssertionFailedError' => '\PHPUnit_Framework_AssertionFailedError',
    '\PHPUnit\Framework\TestSuite' => '\PHPUnit_Framework_TestSuite',
];

foreach ($phpunitAliases as $namespaced => $alias) {
    if (!class_exists($alias)) {
        class_alias($namespaced, $alias);
    }
}

VCR::configure()
    ->setCassettePath(__DIR__ . '/fixtures/vcr')
    ->enableLibraryHooks(['curl'])
    ->setStorage('json')
    ->enableRequestMatchers(['method', 'url', 'host', 'query_string', 'body']);

VCR::turnOn();
VCR::turnOff();

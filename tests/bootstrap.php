<?php

use VCR\VCR;

if (!file_exists(__DIR__ . "/../vendor/autoload.php")) {
    die("\n[ERROR] You need to run composer before running the test suite.\n");
}
require_once __DIR__ . '/../vendor/autoload.php';

VCR::configure()
    ->setCassettePath(__DIR__ . '/fixtures/vcr')
    ->enableLibraryHooks(['curl'])
    ->setStorage('json')
    ->enableRequestMatchers(['method', 'url', 'host', 'query_string', 'body']);

VCR::turnOn();
VCR::turnOff();

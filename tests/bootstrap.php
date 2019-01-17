<?php

VCR\VCR::configure()
    ->setCassettePath(__DIR__ . '/fixtures/vcr')
    ->enableLibraryHooks(['curl'])
    ->setStorage('json')
    ->enableRequestMatchers(['method', 'url', 'query_string', 'body']);

// Sanitize sensitive data
allejo\VCR\VCRCleaner::enable([
    'request' => [
        'ignoreHostname' => true,
        'ignoreQueryFields' => ['serviceTicket'],
        'bodyScrubbers' => [function ($body) {
            if (!$body) {
                return $body;
            }

            $parsedBody = json_decode($body, true);
            unset($parsedBody['password']);
            unset($parsedBody['serviceTicket']);

            return json_encode($parsedBody);
        }],
    ],
    'response' => [
        'ignoreHeaders' => ['Set-Cookie'],
    ]
]);

try {
    Dotenv\Dotenv::create(__DIR__ . '/../')->load();
} catch (\Dotenv\Exception\InvalidPathException $e) {
    //
}

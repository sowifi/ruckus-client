<?php

namespace Test;

use PHPUnit\Framework\TestCase;
use SoConnect\RuckusClient\Client;

abstract class ApiTestCase extends TestCase
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();

        $this->client = new Client();
    }
}

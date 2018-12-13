<?php

namespace Test\Api;

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

        $this->client = new Client('ruckus.soconnect.com');
    }
}

<?php

namespace Test;

use PHPUnit\Framework\TestCase;
use SoConnect\RuckusClient\Client;

class ClientTest extends TestCase
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

    /**
     * @vcr service-logon
     */
    public function testServiceLogon()
    {
        $res = $this->client->serviceTicketLogon();

        $this->assertEquals('5.0.0.0.675', $res['controllerVersion']);
        $this->assertEquals('ST-28-Gc1YMh9iZK9Hb9s4wbDU-sct-rcs-ctr01', $res['serviceTicket']);
    }

    /**
     * @vcr ap-zone-create
     */
    public function testApZoneCreate()
    {
        $res = $this->client->apZoneCreate([
            'domainId' => 'ab1671ee-4d86-4b01-8b65-0b498f719abc',
            'name' => 'Test Name Unit',
            'description' => 'Test Description',
        ]);

        $this->assertEquals('0adef9f8-b925-42b2-be9b-ba7ff1404274', $res['id']);
    }
}

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
        $res = $this->client->serviceTicketLogon('admin', 'Fietstas1314!');

        $this->assertEquals('5.0.0.0.675', $res['controllerVersion']);
        $this->assertEquals('ST-28-Gc1YMh9iZK9Hb9s4wbDU-sct-rcs-ctr01', $res['serviceTicket']);
    }

    /**
     * @vcr ap-zone-create
     */
    public function testApZoneCreate()
    {
        $this->assertTrue(true);
//        $res = $this->client->serviceTicketLogon('admin', 'Fietstas1314!');
//
//        $res = $this->client->apZoneCreate([]);
//
//        var_dump($res);
    }
}

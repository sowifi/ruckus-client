<?php

namespace Test;

use PHPUnit\Framework\TestCase;
use SoConnect\RuckusClient\Api\ApZone;
use SoConnect\RuckusClient\Api\ServiceTicket;
use SoConnect\RuckusClient\Api\Wlan;
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
    public function testServiceTicketManipulation()
    {
        $this->assertFalse($this->client->hasServiceTicket());

        $this->client->serviceTicket()->logon();

        $this->assertTrue($this->client->hasServiceTicket());
        $this->assertEquals('ST-28-Gc1YMh9iZK9Hb9s4wbDU-sct-rcs-ctr01', $this->client->getServiceTicket());

        $newTicket = 'someAnotherTicket';
        $this->client->setServiceTicket($newTicket);
        $this->assertEquals($newTicket, $this->client->getServiceTicket());
    }

    /**
     * @expectedException \SoConnect\RuckusClient\Exception\ClientException
     */
    public function testCallThrowsClientException()
    {
        $this->client->notExisting();
    }

    /**
     * @test
     * @dataProvider apiClassesMappingProvider
     */
    public function testShouldGetApiInstance($apiName, $class)
    {
        $this->assertInstanceOf($class, $this->client->$apiName());
    }

    /**
     * @return array
     */
    public function apiClassesMappingProvider()
    {
        return [
            ['wlan', Wlan::class],
            ['serviceTicket', ServiceTicket::class],
            ['apZone', ApZone::class],
        ];
    }
}

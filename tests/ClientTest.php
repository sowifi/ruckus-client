<?php

namespace Test;

use SoConnect\RuckusClient\Api\ApConfig;
use SoConnect\RuckusClient\Api\ApOperational;
use SoConnect\RuckusClient\Api\ApZone;
use SoConnect\RuckusClient\Api\ServiceTicket;
use SoConnect\RuckusClient\Api\Wlan;

class ClientTest extends ApiTestCase
{
    /**
     * @vcr service-logon
     */
    public function testServiceTicketManipulation()
    {
        $this->assertFalse($this->client->hasServiceTicket());

        $this->client->serviceTicket()->logon();

        $this->assertTrue($this->client->hasServiceTicket());
        $this->assertEquals('ST-84-ne0Ttad35SutWCRbNpMP-sct-rcs-ctr01', $this->client->getServiceTicket());

        $newTicket = 'someAnotherTicket';
        $this->client->setServiceTicket($newTicket);
        $this->assertEquals($newTicket, $this->client->getServiceTicket());
    }

    /**
     * @expectedException \SoConnect\RuckusClient\Exception\ClientException
     */
    public function testInvalidCallThrowsClientException()
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
            ['serviceTicket', ServiceTicket::class],
            ['apZone', ApZone::class],
            ['apConfig', ApConfig::class],
            ['apOperational', ApOperational::class],
            ['wlan', Wlan::class],
        ];
    }
}

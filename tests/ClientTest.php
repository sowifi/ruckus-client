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
     * @vcr service-logon
     */
    public function testServiceLogon()
    {
        $res = $this->client->serviceTicket()->serviceTicketLogon();

        $this->assertEquals('5.0.0.0.675', $res['controllerVersion']);
        $this->assertEquals('ST-28-Gc1YMh9iZK9Hb9s4wbDU-sct-rcs-ctr01', $res['serviceTicket']);
    }

    /**
     * @vcr service-logoff
     * @doesNotPerformAssertions
     */
    public function testServiceLogoff()
    {
        // If logoff does not return exception, all is good
        $this->client->serviceTicket()->serviceTicketLogoff();
    }

    /**
     * @vcr ap-zone-create
     */
    public function testApZoneCreate()
    {
        $res = $this->client->apZone()->apZoneCreate([
            'domainId' => 'ab1671ee-4d86-4b01-8b65-0b498f719abc',
            'name' => 'Test Name Unit',
            'description' => 'Test Description',
            'login' => ['apLoginName' => 'some-name', 'apLoginPassword' => 'Pass123!'],
        ]);

        $this->assertEquals('842ad983-1d49-46dd-be54-f70c14040679', $res['id']);
    }

    /**
     * @vcr wlan-create-standard8021x
     */
    public function testWlanCreateStandard8021x()
    {
        $res = $this->client->wlan()->wlanCreateStandard8021x('4757aaa9-aa3b-4acf-9731-8970049d9109', [
            'name' => 'Test Name Unit',
            'description' => 'Test Description',
            'ssid' => 'test-wlan-1234',
            'authServiceOrProfile' => [
                "name" => "soconnect-venue-1234-radius-auth"
            ]
        ]);

        $this->assertEquals('26', $res['id']);
    }

    /**
     * @vcr wlan-create-wispr
     */
    public function testWlanCreateWispr()
    {
        $res = $this->client->wlan()->wlanCreateWispr('4757aaa9-aa3b-4acf-9731-8970049d9109', [
            'name' => 'Test Name Wispr Unit',
            'description' => 'Test Description',
            'ssid' => 'test-wlan-1234',
            'authServiceOrProfile' => [
                "name" => "soconnect-venue-1234-radius-auth"
            ],
            'portalServiceProfile' => [
                'name' => 'soconnect-captive-portal',
            ]
        ]);

        $this->assertEquals('27', $res['id']);
    }

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();

        $this->client = new Client('ruckus.soconnect.com');
    }
}

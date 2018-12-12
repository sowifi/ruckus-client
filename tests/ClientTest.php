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

        $this->assertEquals('476bcc2d-1d4b-4fa7-a3ad-45ac35f64af3', $res['id']);
    }

    /**
     * @vcr wlan-create-standard8021x
     */
    public function testWlanCreateStandard8021x()
    {
        $res = $this->client->wlanCreateStandard8021x('4757aaa9-aa3b-4acf-9731-8970049d9109', [
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
        $res = $this->client->wlanCreateWispr('4757aaa9-aa3b-4acf-9731-8970049d9109', [
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
}

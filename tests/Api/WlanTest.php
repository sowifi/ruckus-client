<?php

namespace Test\Api;

use SoConnect\RuckusClient\Api\Wlan;
use Test\ApiTestCase;

class WlanTest extends ApiTestCase
{
    /**
     * @var Wlan
     */
    protected $wlanApi;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();

        $this->wlanApi = $this->client->wlan();
    }

    /**
     * @vcr wlan-create-standard8021x
     */
    public function testWlanCreateStandard8021x()
    {
        $res = $this->wlanApi->create8021x('4757aaa9-aa3b-4acf-9731-8970049d9109', [
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
        $res = $this->wlanApi->createWispr('4757aaa9-aa3b-4acf-9731-8970049d9109', [
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

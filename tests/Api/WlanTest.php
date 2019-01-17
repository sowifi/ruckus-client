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
    public function testCreateStandard8021x()
    {
        $res = $this->wlanApi->create8021x('4757aaa9-aa3b-4acf-9731-8970049d9109', [
            'name' => 'Test Name Unit',
            'description' => 'Test Description',
            'ssid' => 'test-wlan-1234',
            'authServiceOrProfile' => [
                "name" => "soconnect-venue-1234-radius-auth"
            ]
        ]);

        $this->assertIsNumeric($res['id']);
    }

    /**
     * @vcr wlan-create-wispr
     */
    public function testCreateWispr()
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

        $this->assertIsNumeric($res['id']);
    }

    /**
     * @vcr wlan-modify
     */
    public function testModify()
    {
        $res = $this->wlanApi->modify('4757aaa9-aa3b-4acf-9731-8970049d9109', 27, [
            'name' => 'Some Another Test Name',
        ]);

        $this->assertEmpty($res);
    }
}

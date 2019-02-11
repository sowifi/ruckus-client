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
     * @vcr wlan-create-standard-open
     */
    public function testCreateStandardOpen()
    {
        $res = $this->wlanApi->createStandardOpen('4757aaa9-aa3b-4acf-9731-8970049d9109', [
            'name' => 'Test Name Unit Open',
            'description' => 'Test Description',
            'ssid' => 'test-wlan-1234',
            'encryption' => [
                'method' => 'WPA2',
                'algorithm' => 'AES',
                'passphrase' => 'password',
                'mfp' => 'disabled',
            ]
        ]);

        $this->assertIsNumeric($res['id']);
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
                'name' => 'soconnect-venue-1234-radius-auth'
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
                'name' => 'soconnect-venue-1234-radius-auth'
            ],
            'portalServiceProfile' => [
                'name' => 'soconnect-captive-portal',
            ]
        ]);

        $this->assertIsNumeric($res['id']);
    }

    /**
     * @vcr wlan-create-wisprmac
     */
    public function testCreateWisprMac()
    {
        $res = $this->wlanApi->createWisprMac('4757aaa9-aa3b-4acf-9731-8970049d9109', [
            'name' => 'Test Name Wispr MAC bypass Unit',
            'description' => 'Test Description',
            'ssid' => 'test-wlan-mac-1234',
            'authServiceOrProfile' => [
                'name' => 'soconnect-venue-1234-radius-auth'
            ],
            'portalServiceProfile' => [
                'name' => 'soconnect-captive-portal',
            ],
            'macAuth' => [
                'macAuthMacFormat' => '802.1X',
            ],
        ]);

        $this->assertIsNumeric($res['id']);
    }

    /**
     * @vcr wlan-retrieve-list
     */
    public function testRetrieveList()
    {
        $res = $this->wlanApi->retrieveList('4757aaa9-aa3b-4acf-9731-8970049d9109');

        $this->assertSame(2, $res['totalCount']);
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

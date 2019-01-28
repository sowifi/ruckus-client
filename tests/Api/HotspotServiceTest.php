<?php

namespace Test\Api;

use SoConnect\RuckusClient\Api\HotspotService;
use Test\ApiTestCase;

class HotspotServiceTest extends ApiTestCase
{
    /**
     * @var HotspotService
     */
    protected $hotspotApi;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();

        $this->hotspotApi = $this->client->hotspotService();
    }

    /**
     * @vcr hotspot-service-create-external
     */
    public function testCreateStandardOpen()
    {
        $res = $this->hotspotApi->createExternal('4757aaa9-aa3b-4acf-9731-8970049d9109', [
           'name' => 'soconnect-captive-portal-unit',
           'smartClientSupport' => 'Enabled',
           'portalUrl' => 'https://login.internetaccess.io/partner/ruckusvsz?location_id=49857',
           'redirect' => [
                'url' => 'https://login.internetaccess.io/portal/index/post-login-redirect'
           ],
           'walledGardens' => [
                '*.akamaihd.net',
                '*.facebook.net'
            ],
           'macAddressFormat' => 1
        ]);

        $this->assertEquals('621ac077-a1f7-437c-b2c6-d16f98e780c2', $res['id']);
    }
}

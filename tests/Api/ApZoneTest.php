<?php

namespace Test\Api;

use SoConnect\RuckusClient\Api\ApZone;
use Test\ApiTestCase;

class ApZoneTest extends ApiTestCase
{
    /**
     * @var ApZone
     */
    protected $apZoneApi;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();

        $this->apZoneApi = $this->client->apZone();
    }

    /**
     * @vcr ap-zone-create
     */
    public function testCreateZone()
    {
        $res = $this->apZoneApi->create([
            'domainId' => 'ab1671ee-4d86-4b01-8b65-0b498f719abc',
            'name' => 'Test Name Unit',
            'description' => 'Test Description',
            'login' => ['apLoginName' => 'some-name', 'apLoginPassword' => 'Pass123!'],
        ]);

        $this->assertEquals('d4648e7d-def0-4115-b702-c38065ee93b1', $res['id']);
    }

    /**
     * @vcr ap-zone-delete
     */
    public function testDeleteZone()
    {
        $res = $this->apZoneApi->deleteZone('d4648e7d-def0-4115-b702-c38065ee93b1');

        $this->assertEmpty($res);
    }
}

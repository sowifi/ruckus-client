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

        $this->assertEquals('9eaf6f09-6f3f-45cf-9676-2f7ac2eba4c2', $res['id']);
    }

    /**
     * @vcr ap-zone-delete
     */
    public function testDeleteZone()
    {
        $res = $this->apZoneApi->deleteZone('d91149be-1e54-4f48-b670-20536538b3f8');

        $this->assertEmpty($res);
    }
}

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
    public function testApZoneCreate()
    {
        $res = $this->apZoneApi->createZone([
            'domainId' => 'ab1671ee-4d86-4b01-8b65-0b498f719abc',
            'name' => 'Test Name Unit',
            'description' => 'Test Description',
            'login' => ['apLoginName' => 'some-name', 'apLoginPassword' => 'Pass123!'],
        ]);

        $this->assertEquals('842ad983-1d49-46dd-be54-f70c14040679', $res['id']);
    }
}

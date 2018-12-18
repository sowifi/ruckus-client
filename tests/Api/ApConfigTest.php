<?php

namespace Test\Api;

use SoConnect\RuckusClient\Api\ApConfig;
use Test\ApiTestCase;

class ApConfigTest extends ApiTestCase
{
    /**
     * @var ApConfig
     */
    protected $apConfigApi;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();

        $this->apConfigApi = $this->client->apConfig();
    }

    /**
     * @vcr ap-config-list
     */
    public function testList()
    {
        $res = $this->apConfigApi->list();

        $this->assertEquals(1, $res['totalCount']);
        $this->assertEquals('F8:E7:1E:0E:EA:60', $res['list'][0]['mac']);
    }

    /**
     * @vcr ap-config-modify
     */
    public function testModify()
    {
        $res = $this->apConfigApi->modify('F8:E7:1E:0E:EA:60', ['zoneId' => '16adc469-8a48-47b8-b431-7164ceb0f4eb']);

        $this->assertEmpty($res);
    }
}

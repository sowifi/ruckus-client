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
     * @vcr ap-config-create
     */
    public function testCreate()
    {
        $res = $this->apConfigApi->create([
            'mac' => '00:A0:C9:14:C8:29',
            'zoneId' => '4757aaa9-aa3b-4acf-9731-8970049d9109',
        ]);

        $this->assertEmpty($res);
    }

    /**
     * @vcr ap-config-list
     */
    public function testList()
    {
        $res = $this->apConfigApi->listAll();

        $this->assertIsNumeric($res['totalCount']);
        $this->assertEquals('00:A0:C9:14:C8:28', $res['list'][0]['mac']);
    }

    /**
     * @vcr ap-config-list-param
     */
    public function testListWithParams()
    {
        $res = $this->apConfigApi->listAll(['zoneId' => '169d08ce-7434-4a38-8fac-0d43e4b625a8']);

        $this->assertEquals(1, $res['totalCount']);
        $this->assertEquals('00:A0:C9:14:C8:39', $res['list'][0]['mac']);
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

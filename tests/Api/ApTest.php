<?php

namespace Test\Api;

use SoConnect\RuckusClient\Api\Ap;
use Test\ApiTestCase;

class ApTest extends ApiTestCase
{
    /**
     * @var Ap
     */
    protected $apApi;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();

        $this->apApi = $this->client->ap();
    }

    /**
     * @vcr ap-modify
     */
    public function testModify()
    {
        $res = $this->apApi->modify('F8:E7:1E:0E:EA:60', ['zoneId' => '16adc469-8a48-47b8-b431-7164ceb0f4eb']);

        $this->assertEmpty($res);
    }
}

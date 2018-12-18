<?php

namespace Test\Api;

use SoConnect\RuckusClient\Api\ApOperational;
use Test\ApiTestCase;

class ApOperationalTest extends ApiTestCase
{
    /**
     * @var ApOperational
     */
    protected $apOperationalApi;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();

        $this->apOperationalApi = $this->client->apOperational();
    }

    /**
     * @vcr ap-operational-summary
     */
    public function testSummary()
    {
        $apMac = 'F8:E7:1E:0E:EA:60';
        $res = $this->apOperationalApi->summary($apMac);

        $this->assertEquals($apMac, $res['mac']);
    }
}

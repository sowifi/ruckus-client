<?php

namespace Test\Api;

use SoConnect\RuckusClient\Api\ServiceTicket;
use Test\ApiTestCase;

class ServiceTicketTest extends ApiTestCase
{
    /**
     * @var ServiceTicket
     */
    protected $serviceApi;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();

        $this->serviceApi = $this->client->serviceTicket();
    }

    /**
     * @vcr service-logon
     */
    public function testLogon()
    {
        $res = $this->serviceApi->logon();

        $this->assertTrue($this->client->hasServiceTicket());
        $this->assertEquals('ST-99-Wa9gcyfVmbvlj0N0LHcI-sct-rcs-ctr01', $res['serviceTicket']);
    }

    /**
     * @vcr service-logoff
     */
    public function testLogoff()
    {
        $res = $this->serviceApi->logoff();

        $this->assertFalse($this->client->hasServiceTicket());
        $this->assertEmpty($res);
    }
}

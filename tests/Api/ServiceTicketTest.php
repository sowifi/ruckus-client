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
    public function testServiceLogon()
    {
        $res = $this->serviceApi->logon();

        $this->assertTrue($this->client->hasServiceTicket());
        $this->assertEquals('5.0.0.0.675', $res['controllerVersion']);
        $this->assertEquals('ST-28-Gc1YMh9iZK9Hb9s4wbDU-sct-rcs-ctr01', $res['serviceTicket']);
    }

    /**
     * @vcr service-logoff
     */
    public function testServiceLogoff()
    {
        $res = $this->serviceApi->logoff();

        $this->assertFalse($this->client->hasServiceTicket());
        $this->assertEmpty($res);
    }
}

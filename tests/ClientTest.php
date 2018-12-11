<?php

namespace Test;

use GuzzleHttp\Client as HttpClient;
use PHPUnit\Framework\TestCase;
use SoConnect\RuckusClient\Client;

class ClientTest extends TestCase
{
    /**
     * @vcr service-logon
     */
    public function testServiceLogon()
    {
        $http = new HttpClient;
        $client = new Client($http, 'ruckus.soconnect.com');
        $res = $client->serviceTicketLogon('admin', 'Fietstas1314!');

        $this->assertArrayHasKey('serviceTicket', $res);
        $this->assertArrayHasKey('controllerVersion', $res);
    }
}

<?php

namespace SoConnect\RuckusClient;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\RequestOptions;

class Client
{
    const BASE_URI = 'https://%s:8443/wsg/api/public/%s';

    /**
     * @var HttpClient
     */
    private $http;

    /**
     * @var string
     */
    private $uri;

    /**
     * @param string $host
     * @param string $version
     */
    public function __construct($host, $version = 'v7_0')
    {
        $this->http = new HttpClient();
        $this->uri = sprintf(self::BASE_URI, $host, $version);
    }

    /**
     * Log on to the controller and acquire a valid service ticket.
     *
     * @param string $username
     * @param string $password
     *
     * @return array
     */
    public function serviceTicketLogon($username, $password)
    {
        return $this->post($this->uri . '/serviceTicket', ['username' => $username, 'password' => $password]);
    }

    /**
     * Create a new Ruckus Wireless AP zone.
     *
     * @param array $params
     *
     * @return array
     */
    public function apZoneCreate(array $params)
    {
        return $this->post($this->uri . '/rkszones', $params);
    }

    /**
     * Generate POST request
     *
     * @param array $params
     * @param string $uri
     *
     * @return array
     */
    protected function post($uri, array $params)
    {
        $res = $this->http->post($uri, [
            RequestOptions::JSON => $params,
            RequestOptions::VERIFY => false,
        ]);

        return json_decode($res->getBody(), true);
    }
}

<?php

namespace SoConnect\RuckusClient;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\RequestOptions;

class Client
{
    CONST BASE_URI = 'https://%s:8443/wsg/api/public/v7_0';

    /**
     * @var HttpClient
     */
    private $http;

    /**
     * @var string
     */
    private $uri;

    /**
     * @param HttpClient $http
     * @param string $host
     */
    public function __construct(HttpClient $http, $host)
    {
        $this->http = $http;
        $this->uri = sprintf(self::BASE_URI, $host);
    }

    /**
     * Use this API command to log on to the controller and acquire a valid service ticket.
     *
     * @param string $username
     * @param string $password
     *
     * @return array
     */
    public function serviceTicketLogon($username, $password)
    {
        $res = $this->http->post($this->uri . '/serviceTicket', [
            RequestOptions::JSON => ['username' => $username, 'password' => $password],
            RequestOptions::VERIFY => false,
        ]);

        return json_decode($res->getBody(), true);
    }
}

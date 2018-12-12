<?php

namespace SoConnect\RuckusClient;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use SoConnect\RuckusClient\Handler\ServiceTicketHandler;

class Client
{
    const BASE_URI = 'https://%s:8443/wsg/api/public/%s';
    const USERNAME = 'admin';
    const USERPASS = 'Fietstas1314!';

    /**
     * @var HttpClient
     */
    private $http;

    /**
     * @var string
     */
    private $uri;

    /**
     * @var string
     */
    private $serviceTicket;

    /**
     * @param string $host
     * @param string $version
     */
    public function __construct($host, $version = 'v7_0')
    {
        $handler = new CurlHandler();
        $stack = HandlerStack::create($handler);
        $stack->push(new ServiceTicketHandler($this));
        $this->http = new HttpClient(['handler' => $stack]);
        $this->uri = sprintf(self::BASE_URI, $host, $version);
    }

    public function __destruct()
    {
        // Logoff from the controller's API
        if ($this->hasServiceTicket() && getenv('APP_ENV') !== 'testing') {
            $this->serviceTicketLogoff();
        }
    }

    /**
     * Log off of the controller.
     *
     * @return array
     */
    public function serviceTicketLogoff()
    {
        $res = $this->http->delete($this->uri . '/serviceTicket');

        return $this->jsonDecode($res);
    }

    /**
     * JSON decode response
     *
     * @param ResponseInterface $res
     *
     * @return array
     */
    private function jsonDecode(ResponseInterface $res)
    {
        return json_decode($res->getBody(), true);
    }

    /**
     * Log on to the controller and acquire a valid service ticket.
     *
     * @return array
     */
    public function serviceTicketLogon()
    {
        $res = $this->post($this->uri . '/serviceTicket', [
            'username' => self::USERNAME, 'password' => self::USERPASS
        ]);
        $this->setServiceTicket($res['serviceTicket']);

        return $res;
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
        ]);

        return $this->jsonDecode($res);
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
        $params['login'] = ['apLoginName' => Client::USERNAME, 'apLoginPassword' => Client::USERPASS];

        return $this->post($this->uri . '/rkszones', $params);
    }

    /**
     * @return string
     */
    public function getServiceTicket()
    {
        return $this->serviceTicket;
    }

    /**
     * @param string $serviceTicket
     */
    public function setServiceTicket(string $serviceTicket)
    {
        $this->serviceTicket = $serviceTicket;
    }

    /**
     * @return bool
     */
    public function hasServiceTicket()
    {
        return !empty($this->serviceTicket);
    }

    public function isServiceLogonRequest(RequestInterface $req)
    {
        return (string) $req->getUri() === $this->uri . '/serviceTicket' && $req->getMethod() === 'POST';
    }
}

<?php

namespace SoConnect\RuckusClient;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\HandlerStack;
use SoConnect\RuckusClient\Api\AbstractApi;
use SoConnect\RuckusClient\Exception\ClientException;
use SoConnect\RuckusClient\Handler\ServiceTicketHandler;

/**
 * Ruckus WLAN controller API client
 *
 * @method Api\Wlan wlan()
 * @method Api\ServiceTicket serviceTicket()
 * @method Api\ApZone apZone()
 */
class Client
{
    const BASE_URI = '%s/wsg/api/public/%s';

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
    private $serviceTicket = '';

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

    public function __destruct()
    {
        // Logoff from the controller's API
        if ($this->hasServiceTicket() && getenv('APP_ENV') !== 'testing') {
            $this->serviceTicket()->logoff();
        }
    }

    /**
     * @param string $name
     * @return mixed
     *
     * @throws ClientException
     */
    public function __call($name, $arg)
    {
        try {
            return $this->api($name);
        } catch (\InvalidArgumentException $e) {
            throw new ClientException(sprintf('Undefined method called: "%s"', $name));
        }
    }

    /**
     * @return HttpClient
     */
    public function getHttp()
    {
        return $this->http;
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * API factory
     *
     * @param string $name
     * @return AbstractApi
     *
     * @throws \InvalidArgumentException
     */
    private function api($name)
    {
        switch ($name) {
            case 'apZone':
                return new Api\ApZone($this);
            case 'serviceTicket':
                return new Api\ServiceTicket($this);
            case 'wlan':
                return new Api\Wlan($this);
            default:
                throw new \InvalidArgumentException(sprintf('Undefined api instance called: "%s"', $name));
        }
    }
}

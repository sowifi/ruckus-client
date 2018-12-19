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
 * @method Api\ServiceTicket serviceTicket()
 * @method Api\ApZone apZone()
 * @method Api\ApConfig apConfig()
 * @method Api\ApOperational apOperational()
 * @method Api\Wlan wlan()
 */
class Client
{
    const BASE_URI_FORMAT = '%s/wsg/api/public/%s';

    /**
     * @var HttpClient
     */
    private $http;

    /**
     * @var string
     */
    private $baseUri;

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
        $this->baseUri = sprintf(self::BASE_URI_FORMAT, $host, $version);
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
    public function setServiceTicket($serviceTicket)
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
    public function getBaseUri()
    {
        return $this->baseUri;
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
            case 'serviceTicket':
                return new Api\ServiceTicket($this);
            case 'apZone':
                return new Api\ApZone($this);
            case 'apConfig':
                return new Api\ApConfig($this);
            case 'apOperational':
                return new Api\ApOperational($this);
            case 'wlan':
                return new Api\Wlan($this);
            default:
                throw new \InvalidArgumentException(sprintf('Undefined api instance called: "%s"', $name));
        }
    }
}

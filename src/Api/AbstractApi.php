<?php

namespace SoConnect\RuckusClient\Api;

use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;
use SoConnect\RuckusClient\Client;

abstract class AbstractApi
{
    /**
     * @var Client
     */
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Generate POST request
     *
     * @param string $uri
     * @param array $params
     *
     * @return array
     */
    protected function post($uri, array $params = [])
    {
        $res = $this->client->getHttp()->post($this->getUri() . $uri, [
            RequestOptions::JSON => $params,
        ]);

        return $this->jsonDecode($res);
    }

    /**
     * Generate DELETE request
     *
     * @param string $uri
     * @param array $params
     *
     * @return array
     */
    protected function delete($uri, array $params = [])
    {
        $res = $this->client->getHttp()->delete($this->getUri() . $uri, [
            RequestOptions::JSON => $params,
        ]);

        return $this->jsonDecode($res);
    }

    /**
     * @return string
     */
    protected function getUri()
    {
        return $this->client->getUri();
    }

    /**
     * JSON decode response
     *
     * @param ResponseInterface $res
     *
     * @return array
     */
    protected function jsonDecode(ResponseInterface $res)
    {
        return json_decode($res->getBody(), true);
    }
}

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
     * Generate GET request
     *
     * @param string $uri
     * @return array
     */
    protected function get($uri)
    {
        return $this->doRequest('get', $uri);
    }

    /**
     * Generate POST request
     *
     * @param string $uri
     * @param array $body
     *
     * @return array
     */
    protected function post($uri, array $body = [])
    {
        return $this->doRequest('post', $uri, $body);
    }

    /**
     * Generate PATCH request
     *
     * @param string $uri
     * @param array $body
     *
     * @return array
     */
    protected function patch($uri, array $body = [])
    {
        return $this->doRequest('patch', $uri, $body);
    }

    /**
     * Generate DELETE request
     *
     * @param string $uri
     *
     * @return array
     */
    protected function delete($uri)
    {
        return $this->doRequest('delete', $uri);
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array $body
     *
     * @return array
     */
    protected function doRequest($method, $uri, $body = [])
    {
        $options = [];
        if (!empty($body)) {
            $options = [RequestOptions::JSON => $body];
        }
        $res = $this->client->getHttp()->$method($this->getUri() . $uri, $options);

        return $this->jsonDecode($res);
    }

    /**
     * @return string
     */
    protected function getUri()
    {
        return $this->client->getBaseUri();
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
        if ($res->getBody()->getSize() === 0) {
            return [];
        }

        return json_decode($res->getBody(), true);
    }
}

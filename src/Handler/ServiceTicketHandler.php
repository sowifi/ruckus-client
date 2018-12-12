<?php

namespace SoConnect\RuckusClient\Handler;

use Psr\Http\Message\RequestInterface;
use SoConnect\RuckusClient\Client;

/**
 * Custom Guzzle middleware handler to hide work required for the
 * Ruckus serviceTicket and its expiry
 *
 * @see http://docs.ruckuswireless.com/smartzone/5.0/vsze-public-api-reference-guide-5-0.html#logon
 */
class ServiceTicketHandler
{
    /**
     * @var Client
     */
    public $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function __invoke(callable $handler)
    {
        return function (RequestInterface $request, array $options) use ($handler) {
            // Todo: Remove this once SSL is sorted
            $options['verify'] = false;

            // Ignore this middleware for service ticket request itself
            // to prevent infinite loop
            if ($this->client->isServiceLogonRequest($request)) {
                return $handler($request, $options);
            }

            // If we have service ticket already we will attempt to reuse it
            // otherwise create new one
            $ticket = $this->client->hasServiceTicket()
                ? $this->client->getServiceTicket()
                : $this->client->serviceTicketLogon()['serviceTicket'];
            $uri = $request->getUri()->withQuery('serviceTicket=' . $ticket);
            $request = $request->withUri($uri);

            return $handler($request, $options);
        };
    }
}

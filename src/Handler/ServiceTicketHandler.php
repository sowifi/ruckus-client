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
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Call the handler in the stack
     *
     * @param callable $handler
     * @return \Closure
     */
    public function __invoke(callable $handler)
    {
        return function (RequestInterface $request, array $options) use ($handler) {
            // Todo: Remove this once SSL is sorted
            $options['verify'] = false;

            // Ignore this middleware for service ticket request itself
            // to prevent infinite loop
            $serviceApi = $this->client->serviceTicket();
            if ($serviceApi->isServiceLogonRequest($request)) {
                return $handler($request, $options);
            }

            // If we have service ticket already we will attempt to reuse it
            // otherwise create new one
            $ticket = $this->client->hasServiceTicket()
                ? $this->client->getServiceTicket()
                : $serviceApi->logon()['serviceTicket'];

            $query = $request->getUri()->getQuery() . '&serviceTicket=' . $ticket;
            $uri = $request->getUri()->withQuery($query);
            $request = $request->withUri($uri);

            return $handler($request, $options);
        };
    }
}

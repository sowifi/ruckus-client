<?php

namespace SoConnect\RuckusClient\Api;

use Psr\Http\Message\RequestInterface;

/**
 * Logon / Logoff through service tickets
 */
class ServiceTicket extends AbstractApi
{
    const USERNAME = 'admin';
    const USERPASS = 'Fietstas1314!';

    /**
     * Log off of the controller.
     *
     * @return array
     */
    public function logoff()
    {
        $res = $this->delete('/serviceTicket');
        $this->client->setServiceTicket('');

        return $res;
    }

    /**
     * Log on to the controller and acquire a valid service ticket.
     *
     * @return array
     */
    public function logon()
    {
        $res = $this->post('/serviceTicket', [
            'username' => self::USERNAME,
            'password' => self::USERPASS
        ]);
        $this->client->setServiceTicket($res['serviceTicket']);

        return $res;
    }

    /**
     * Returns true when given request is service logon
     *
     * @param RequestInterface $req
     * @return bool
     */
    public function isServiceLogonRequest(RequestInterface $req)
    {
        return (string) $req->getUri() === $this->getUri() . '/serviceTicket' && $req->getMethod() === 'POST';
    }
}

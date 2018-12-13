<?php

namespace SoConnect\RuckusClient\Api;

use Psr\Http\Message\RequestInterface;

class ServiceTicket extends AbstractApi
{
    const USERNAME = 'admin';
    const USERPASS = 'Fietstas1314!';

    /**
     * Log off of the controller.
     */
    public function logoff()
    {
        $this->delete('/serviceTicket');
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

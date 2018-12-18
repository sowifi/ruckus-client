<?php

namespace SoConnect\RuckusClient\Api;

/**
 * Manage Ruckus Wireless AP Zones
 */
class ApZone extends AbstractApi
{
    /**
     * Create a new Ruckus Wireless AP zone.
     *
     * @param array $body
     *
     * @return array
     */
    public function createZone(array $body)
    {
        return $this->post('/rkszones', $body);
    }
}

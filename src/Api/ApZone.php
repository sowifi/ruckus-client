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
     * @param array $params
     *
     * @return array
     */
    public function createZone(array $params)
    {
        return $this->post('/rkszones', $params);
    }
}

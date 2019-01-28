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
     * @return array
     */
    public function create(array $body)
    {
        return $this->post('/rkszones', $body);
    }

    /**
     * Delete a zone.
     *
     * @param string $zoneId
     * @return array
     */
    public function deleteZone($zoneId)
    {
        return $this->delete('/rkszones/' . $zoneId);
    }
}

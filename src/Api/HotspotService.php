<?php

namespace SoConnect\RuckusClient\Api;

/**
 * Manage hotspot (WISPr) portals
 */
class HotspotService extends AbstractApi
{
    /**
     * Create a new Hotspot (WISPr) with external logon URL of a zone.MacAddressFormat.
     *
     * @param string $zoneId
     * @param array $body
     *
     * @return array
     */
    public function createExternal($zoneId, array $body)
    {
        return $this->post('/rkszones/' . $zoneId . '/portals/hotspot/external', $body);
    }
}

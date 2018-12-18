<?php

namespace SoConnect\RuckusClient\Api;

/**
 * Manage WLAN configuration
 */
class Wlan extends AbstractApi
{
    /**
     * Create a new standard, 802.1X and non-tunneled WLAN.
     *
     * @param string $zoneId
     * @param array $body
     *
     * @return array
     */
    public function create8021x($zoneId, array $body)
    {
        return $this->post('/rkszones/' . $zoneId . '/wlans/standard8021X', $body);
    }

    /**
     * Create new hotspot (WISPr) WLAN.
     *
     * @param string $zoneId
     * @param array $body
     *
     * @return array
     */
    public function createWispr($zoneId, array $body)
    {
        return $this->post('/rkszones/' . $zoneId . '/wlans/wispr', $body);
    }
}

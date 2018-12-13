<?php

namespace SoConnect\RuckusClient\Api;

class Wlan extends AbstractApi
{
    /**
     * Create a new standard, 802.1X and non-tunneled WLAN.
     *
     * @param string $zoneId
     * @param array $params
     *
     * @return array
     */
    public function create8021x($zoneId, array $params)
    {
        return $this->post('/rkszones/' . $zoneId . '/wlans/standard8021X', $params);
    }

    /**
     * Create new hotspot (WISPr) WLAN.
     *
     * @param string $zoneId
     * @param array $params
     *
     * @return array
     */
    public function createWispr($zoneId, array $params)
    {
        return $this->post('/rkszones/' . $zoneId . '/wlans/wispr', $params);
    }
}

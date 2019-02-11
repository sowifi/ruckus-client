<?php

namespace SoConnect\RuckusClient\Api;

/**
 * Manage WLAN configuration
 */
class Wlan extends AbstractApi
{
    /**
     * Create a new standard, open and non-tunneled basic WLAN.
     *
     * @param string $zoneId
     * @param array $body
     *
     * @return array
     */
    public function createStandardOpen($zoneId, array $body)
    {
        return $this->post('/rkszones/' . $zoneId . '/wlans', $body);
    }

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

    /**
     * Create new hotspot (WISPr) WLAN with MAC bypass WLAN.
     *
     * @param string $zoneId
     * @param array $body
     *
     * @return array
     */
    public function createWisprMac($zoneId, array $body)
    {
        return $this->post('/rkszones/' . $zoneId . '/wlans/wisprmac', $body);
    }

    /**
     * Retrieve a list of WLANs within a zone
     *
     * @param string $zoneId
     * @param array $uriParams
     *
     * @return array
     */
    public function retrieveList($zoneId, array $uriParams = [])
    {
        return $this->get('/rkszones/' . $zoneId . '/wlans', $uriParams);
    }

    /**
     * Modify the basic information of a WLAN.
     *
     * @param string $zoneId
     * @param int $wlanId
     * @param array $body
     *
     * @return array
     */
    public function modify($zoneId, $wlanId, array $body)
    {
        return $this->patch('/rkszones/' . $zoneId . '/wlans/' . $wlanId, $body);
    }
}

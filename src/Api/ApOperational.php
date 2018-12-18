<?php

namespace SoConnect\RuckusClient\Api;

/**
 * Access Point Operational
 */
class ApOperational extends AbstractApi
{
    /**
     * Retrieve the operational information of an AP.
     *
     * @param string $apMac
     * @return array
     */
    public function summary($apMac)
    {
        return $this->get('/aps/' . $apMac . '/operational/summary');
    }
}

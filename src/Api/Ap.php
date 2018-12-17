<?php

namespace SoConnect\RuckusClient\Api;

/**
 * Access Point configuration
 */
class Ap extends AbstractApi
{
    /**
     * Modify the basic information of an AP.
     *
     * @param string $apMac
     * @param array $params
     *
     * @return array
     */
    public function modify($apMac, array $params)
    {
        return $this->patch('/aps/' . $apMac, $params);
    }
}

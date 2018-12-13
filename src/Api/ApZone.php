<?php

namespace SoConnect\RuckusClient\Api;

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

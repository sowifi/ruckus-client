<?php

namespace SoConnect\RuckusClient\Api;

/**
 * Access Point configuration
 */
class Ap extends AbstractApi
{
    /**
     * Retrieve the list of APs that belong to a zone or a domain.
     *
     * @param array $uriParams
     * @return array
     */
    public function list(array $uriParams = [])
    {
        return $this->get('/aps' . http_build_query($uriParams));
    }

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

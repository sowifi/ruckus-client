<?php

namespace SoConnect\RuckusClient\Api;

/**
 * Access Point configuration
 */
class ApConfig extends AbstractApi
{
    /**
     * Create a new access point.
     *
     * @param array $body
     * @return array
     */
    public function create(array $body)
    {
        return $this->post('/aps', $body);
    }

    /**
     * Retrieve the list of APs that belong to a zone or a domain.
     * Todo: Rename to `list` once moved to PHP 7
     *
     * @param array $uriParams
     * @return array
     */
    public function listAll(array $uriParams = [])
    {
        return $this->get('/aps', $uriParams);
    }

    /**
     * Modify the basic information of an AP.
     *
     * @param string $apMac
     * @param array $body
     *
     * @return array
     */
    public function modify($apMac, array $body)
    {
        return $this->patch('/aps/' . $apMac, $body);
    }
}

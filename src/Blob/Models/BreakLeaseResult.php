<?php

namespace AzureOSS\Storage\Blob\Models;

use AzureOSS\Storage\Blob\Internal\BlobResources as Resources;
use AzureOSS\Storage\Common\Internal\Utilities;

class BreakLeaseResult
{
    private $_leaseTime;

    /**
     * Creates BreakLeaseResult from response headers
     *
     * @param array $headers response headers
     *
     * @return BreakLeaseResult
     */
    public static function create($headers)
    {
        $result = new BreakLeaseResult();

        $result->setLeaseTime(
            Utilities::tryGetValue($headers, Resources::X_MS_LEASE_TIME),
        );

        return $result;
    }

    /**
     * Gets lease time.
     *
     * @return string
     */
    public function getLeaseTime()
    {
        return $this->_leaseTime;
    }

    /**
     * Sets lease time.
     *
     * @param string $leaseTime the blob lease time.
     */
    protected function setLeaseTime($leaseTime)
    {
        $this->_leaseTime = $leaseTime;
    }
}

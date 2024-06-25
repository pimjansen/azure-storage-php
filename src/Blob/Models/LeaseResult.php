<?php

namespace AzureOSS\Storage\Blob\Models;

use AzureOSS\Storage\Blob\Internal\BlobResources as Resources;
use AzureOSS\Storage\Common\Internal\Utilities;

class LeaseResult
{
    private $leaseId;

    /**
     * Creates LeaseResult from response headers
     *
     * @param array $headers response headers
     *
     * @internal
     *
     * @return \AzureOSS\Storage\Blob\Models\LeaseResult
     */
    public static function create(array $headers)
    {
        $result = new LeaseResult();

        $result->setLeaseId(
            Utilities::tryGetValue($headers, Resources::X_MS_LEASE_ID),
        );

        return $result;
    }

    /**
     * Gets lease Id for the blob
     *
     * @return string
     */
    public function getLeaseId()
    {
        return $this->leaseId;
    }

    /**
     * Sets lease Id for the blob
     *
     * @param string $leaseId the blob lease id.
     */
    protected function setLeaseId($leaseId)
    {
        $this->leaseId = $leaseId;
    }
}

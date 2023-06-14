<?php

namespace AzureOSS\Storage\Blob\Models;

use AzureOSS\Storage\Common\Models\ServiceOptions;

class BlobServiceOptions extends ServiceOptions
{
    private $_leaseId;
    private $_accessConditions;

    /**
     * Gets lease Id for the blob
     *
     * @return string
     */
    public function getLeaseId()
    {
        return $this->_leaseId;
    }

    /**
     * Sets lease Id for the blob
     *
     * @param string $leaseId the blob lease id.
     */
    public function setLeaseId($leaseId)
    {
        $this->_leaseId = $leaseId;
    }

    /**
     * Gets access condition
     *
     * @return \AzureOSS\Storage\Blob\Models\AccessCondition[]
     */
    public function getAccessConditions()
    {
        return $this->_accessConditions;
    }

    /**
     * Sets access condition
     *
     * @param mixed $accessConditions value to use.
     */
    public function setAccessConditions($accessConditions)
    {
        if (
            null !== $accessConditions
            && is_array($accessConditions)
        ) {
            $this->_accessConditions = $accessConditions;
        } else {
            $this->_accessConditions = [$accessConditions];
        }
    }
}

<?php

namespace AzureOSS\Storage\Blob\Models;

use AzureOSS\Storage\Blob\Internal\BlobResources as Resources;
use AzureOSS\Storage\Common\Internal\MetadataTrait;
use AzureOSS\Storage\Common\Internal\Utilities;
use AzureOSS\Storage\Common\Internal\Validate;

class GetContainerPropertiesResult
{
    use MetadataTrait;

    private $leaseStatus;
    private $leaseState;
    private $leaseDuration;
    private $publicAccess;

    /**
     * Gets blob leaseStatus.
     *
     * @return string
     */
    public function getLeaseStatus()
    {
        return $this->leaseStatus;
    }

    /**
     * Sets blob leaseStatus.
     *
     * @param string $leaseStatus value.
     */
    public function setLeaseStatus($leaseStatus)
    {
        $this->leaseStatus = $leaseStatus;
    }

    /**
     * Gets blob lease state.
     *
     * @return string
     */
    public function getLeaseState()
    {
        return $this->leaseState;
    }

    /**
     * Sets blob lease state.
     *
     * @param string $leaseState value.
     */
    public function setLeaseState($leaseState)
    {
        $this->leaseState = $leaseState;
    }

    /**
     * Gets blob lease duration.
     *
     * @return string
     */
    public function getLeaseDuration()
    {
        return $this->leaseDuration;
    }

    /**
     * Sets blob leaseStatus.
     *
     * @param string $leaseDuration value.
     */
    public function setLeaseDuration($leaseDuration)
    {
        $this->leaseDuration = $leaseDuration;
    }

    /**
     * Gets container publicAccess.
     *
     * @return string
     */
    public function getPublicAccess()
    {
        return $this->publicAccess;
    }

    /**
     * Sets container publicAccess.
     *
     * @param string $publicAccess value.
     */
    public function setPublicAccess($publicAccess)
    {
        Validate::isTrue(
            PublicAccessType::isValid($publicAccess),
            Resources::INVALID_BLOB_PAT_MSG,
        );
        $this->publicAccess = $publicAccess;
    }

    /**
     * Create an instance using the response headers from the API call.
     *
     * @param array $responseHeaders The array contains all the response headers
     *
     * @internal
     *
     * @return GetContainerPropertiesResult
     */
    public static function create(array $responseHeaders)
    {
        $result = static::createMetadataResult($responseHeaders);

        $result->setLeaseStatus(Utilities::tryGetValueInsensitive(
            Resources::X_MS_LEASE_STATUS,
            $responseHeaders,
        ));
        $result->setLeaseState(Utilities::tryGetValueInsensitive(
            Resources::X_MS_LEASE_STATE,
            $responseHeaders,
        ));
        $result->setLeaseDuration(Utilities::tryGetValueInsensitive(
            Resources::X_MS_LEASE_DURATION,
            $responseHeaders,
        ));
        $result->setPublicAccess(Utilities::tryGetValueInsensitive(
            Resources::X_MS_BLOB_PUBLIC_ACCESS,
            $responseHeaders,
        ));

        return $result;
    }
}

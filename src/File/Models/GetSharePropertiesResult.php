<?php

namespace AzureOSS\Storage\File\Models;

use AzureOSS\Storage\Common\Internal\MetadataTrait;
use AzureOSS\Storage\Common\Internal\Utilities;
use AzureOSS\Storage\File\Internal\FileResources as Resources;

class GetSharePropertiesResult
{
    use MetadataTrait;

    private $quota;

    /**
     * Gets file quota.
     *
     * @return int
     */
    public function getQuota()
    {
        return $this->quota;
    }

    /**
     * Sets file quota.
     *
     * @param int $quota value.
     */
    protected function setQuota($quota)
    {
        $this->quota = $quota;
    }

    /**
     * Create an instance using the response headers from the API call.
     *
     * @param array $responseHeaders The array contains all the response headers
     *
     * @internal
     *
     * @return GetSharePropertiesResult
     */
    public static function create(array $responseHeaders)
    {
        $result = static::createMetadataResult($responseHeaders);

        $result->setQuota((int) (Utilities::tryGetValueInsensitive(
            Resources::X_MS_SHARE_QUOTA,
            $responseHeaders
        )));

        return $result;
    }
}

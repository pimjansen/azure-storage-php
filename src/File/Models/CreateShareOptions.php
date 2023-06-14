<?php

namespace AzureOSS\Storage\File\Models;

use AzureOSS\Storage\Common\Internal\Validate;

class CreateShareOptions extends FileServiceOptions
{
    private $quota;
    private $metadata;

    /**
     * Gets share quota.
     *
     * @return int
     */
    public function getQuota()
    {
        return $this->quota;
    }

    /**
     * Specifies the maximum size of the share, in gigabytes.
     * Must be greater than 0, and less than or equal to 5TB (5120)
     *
     * @param int $quota quota for the share
     */
    public function setQuota($quota)
    {
        Validate::isInteger($quota, 'quota');
        $this->quota = $quota;
    }

    /**
     * Gets user defined metadata.
     *
     * @return array
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * Sets user defined metadata. This metadata should be added without the header
     * prefix (x-ms-meta-*).
     *
     * @param array $metadata user defined metadata object in array form.
     */
    public function setMetadata(array $metadata)
    {
        $this->metadata = $metadata;
    }

    /**
     * Adds new metadata element. This element should be added without the header
     * prefix (x-ms-meta-*).
     *
     * @param string $key   metadata key element.
     * @param string $value metadata value element.
     */
    public function addMetadata($key, $value)
    {
        $this->metadata[$key] = $value;
    }
}

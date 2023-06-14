<?php

namespace AzureOSS\Storage\Blob\Models;

class CopyBlobFromURLOptions extends BlobServiceOptions
{
    use AccessTierTrait;

    private $sourceLeaseId;
    private $sourceAccessConditions;
    private $metadata;
    private $isIncrementalCopy;

    /**
     * Gets source access condition
     *
     * @return AccessCondition[]
     */
    public function getSourceAccessConditions()
    {
        return $this->sourceAccessConditions;
    }

    /**
     * Sets source access condition
     *
     * @param array $sourceAccessConditions value to use.
     */
    public function setSourceAccessConditions($sourceAccessConditions)
    {
        if (
            null !== $sourceAccessConditions
            && is_array($sourceAccessConditions)
        ) {
            $this->sourceAccessConditions = $sourceAccessConditions;
        } else {
            $this->sourceAccessConditions = [$sourceAccessConditions];
        }
    }

    /**
     * Gets metadata.
     *
     * @return array
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * Sets metadata.
     *
     * @param array $metadata value.
     */
    public function setMetadata(array $metadata)
    {
        $this->metadata = $metadata;
    }

    /**
     * Gets source lease ID.
     *
     * @return string
     */
    public function getSourceLeaseId()
    {
        return $this->sourceLeaseId;
    }

    /**
     * Sets source lease ID.
     *
     * @param string $sourceLeaseId value.
     */
    public function setSourceLeaseId($sourceLeaseId)
    {
        $this->sourceLeaseId = $sourceLeaseId;
    }

    /**
     * Gets isIncrementalCopy.
     *
     * @return bool
     */
    public function getIsIncrementalCopy()
    {
        return $this->isIncrementalCopy;
    }

    /**
     * Sets isIncrementalCopy.
     *
     * @param bool $isIncrementalCopy
     */
    public function setIsIncrementalCopy($isIncrementalCopy)
    {
        $this->isIncrementalCopy = $isIncrementalCopy;
    }
}

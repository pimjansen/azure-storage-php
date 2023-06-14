<?php

namespace AzureOSS\Storage\File\Models;

class CreateDirectoryOptions extends FileServiceOptions
{
    private $metadata;

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

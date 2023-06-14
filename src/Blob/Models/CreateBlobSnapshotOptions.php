<?php

namespace AzureOSS\Storage\Blob\Models;

class CreateBlobSnapshotOptions extends BlobServiceOptions
{
    private $_metadata;

    /**
     * Gets metadata.
     *
     * @return array
     */
    public function getMetadata()
    {
        return $this->_metadata;
    }

    /**
     * Sets metadata.
     *
     * @param array $metadata The metadata array.
     */
    public function setMetadata(array $metadata)
    {
        $this->_metadata = $metadata;
    }
}

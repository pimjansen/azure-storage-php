<?php

namespace AzureOSS\Storage\Blob\Models;

class GetBlobMetadataOptions extends BlobServiceOptions
{
    private $_snapshot;

    /**
     * Gets blob snapshot.
     *
     * @return string
     */
    public function getSnapshot()
    {
        return $this->_snapshot;
    }

    /**
     * Sets blob snapshot.
     *
     * @param string $snapshot value.
     */
    public function setSnapshot($snapshot)
    {
        $this->_snapshot = $snapshot;
    }
}

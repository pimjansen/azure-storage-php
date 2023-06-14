<?php

namespace AzureOSS\Storage\Blob\Models;

class CopyBlobOptions extends CopyBlobFromURLOptions
{
    private $sourceSnapshot;

    /**
     * Gets source snapshot.
     *
     * @return string
     */
    public function getSourceSnapshot()
    {
        return $this->sourceSnapshot;
    }

    /**
     * Sets source snapshot.
     *
     * @param string $sourceSnapshot value.
     */
    public function setSourceSnapshot($sourceSnapshot)
    {
        $this->sourceSnapshot = $sourceSnapshot;
    }
}

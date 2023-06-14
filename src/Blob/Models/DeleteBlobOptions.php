<?php

namespace AzureOSS\Storage\Blob\Models;

use AzureOSS\Storage\Common\Internal\Validate;

class DeleteBlobOptions extends BlobServiceOptions
{
    private $_snapshot;
    private $_deleteSnaphotsOnly;

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

    /**
     * Gets blob deleteSnaphotsOnly.
     *
     * @return bool
     */
    public function getDeleteSnaphotsOnly()
    {
        return $this->_deleteSnaphotsOnly;
    }

    /**
     * Sets blob deleteSnaphotsOnly.
     *
     * @param string $deleteSnaphotsOnly value.
     *
     * @return bool
     */
    public function setDeleteSnaphotsOnly($deleteSnaphotsOnly)
    {
        Validate::isBoolean($deleteSnaphotsOnly);
        $this->_deleteSnaphotsOnly = $deleteSnaphotsOnly;
    }
}

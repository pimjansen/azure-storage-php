<?php

namespace AzureOSS\Storage\Table\Models;

class DeleteEntityOptions extends TableServiceOptions
{
    private $_etag;

    /**
     * Gets entity etag.
     *
     * @return string
     */
    public function getETag()
    {
        return $this->_etag;
    }

    /**
     * Sets entity etag.
     *
     * @param string $etag The entity ETag.
     */
    public function setETag($etag)
    {
        $this->_etag = $etag;
    }
}

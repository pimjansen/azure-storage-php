<?php

namespace AzureOSS\Storage\Blob\Models;

class CreateBlobPagesOptions extends BlobServiceOptions
{
    private $_contentMD5;

    /**
     * Gets blob contentMD5.
     *
     * @return string
     */
    public function getContentMD5()
    {
        return $this->_contentMD5;
    }

    /**
     * Sets blob contentMD5.
     *
     * @param string $contentMD5 value.
     */
    public function setContentMD5($contentMD5)
    {
        $this->_contentMD5 = $contentMD5;
    }
}

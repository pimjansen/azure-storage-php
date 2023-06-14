<?php

namespace AzureOSS\Storage\File\Models;

class PutFileRangeOptions extends FileServiceOptions
{
    private $contentMD5;

    /**
     * Gets contentMD5.
     *
     * @return string
     */
    public function getContentMD5()
    {
        return $this->contentMD5;
    }

    /**
     * Sets contentMD5.
     *
     * @param string $contentMD5 value.
     */
    public function setContentMD5($contentMD5)
    {
        $this->contentMD5 = $contentMD5;
    }
}

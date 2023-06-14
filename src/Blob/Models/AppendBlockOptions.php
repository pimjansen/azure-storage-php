<?php

namespace AzureOSS\Storage\Blob\Models;

class AppendBlockOptions extends BlobServiceOptions
{
    private $contentMD5;
    private $maxBlobSize;
    private $appendPosition;

    /**
     * Gets block contentMD5.
     *
     * @return string
     */
    public function getContentMD5()
    {
        return $this->contentMD5;
    }

    /**
     * Sets block contentMD5.
     *
     * @param string $contentMD5 value.
     */
    public function setContentMD5($contentMD5)
    {
        $this->contentMD5 = $contentMD5;
    }

    /**
     * Gets the max length in bytes allowed for the append blob to grow to.
     *
     * @return int
     */
    public function getMaxBlobSize()
    {
        return $this->maxBlobSize;
    }

    /**
     * Sets the max length in bytes allowed for the append blob to grow to.
     *
     * @param int $maxBlobSize value.
     */
    public function setMaxBlobSize($maxBlobSize)
    {
        $this->maxBlobSize = $maxBlobSize;
    }

    /**
     * Gets append blob appendPosition.
     *
     * @return int
     */
    public function getAppendPosition()
    {
        return $this->appendPosition;
    }

    /**
     * Sets append blob appendPosition.
     *
     * @param int $appendPosition value.
     */
    public function setAppendPosition($appendPosition)
    {
        $this->appendPosition = $appendPosition;
    }
}

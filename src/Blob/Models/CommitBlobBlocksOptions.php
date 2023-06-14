<?php

namespace AzureOSS\Storage\Blob\Models;

class CommitBlobBlocksOptions extends BlobServiceOptions
{
    private $_contentType;
    private $_contentEncoding;
    private $_contentLanguage;
    private $_contentMD5;
    private $_cacheControl;
    private $_contentDisposition;
    private $_metadata;

    /**
     * Gets ContentType.
     *
     * @return string
     */
    public function getContentType()
    {
        return $this->_contentType;
    }

    /**
     * Sets ContentType.
     *
     * @param string $contentType value.
     */
    public function setContentType($contentType)
    {
        $this->_contentType = $contentType;
    }

    /**
     * Gets ContentEncoding.
     *
     * @return string
     */
    public function getContentEncoding()
    {
        return $this->_contentEncoding;
    }

    /**
     * Sets ContentEncoding.
     *
     * @param string $contentEncoding value.
     */
    public function setContentEncoding($contentEncoding)
    {
        $this->_contentEncoding = $contentEncoding;
    }

    /**
     * Gets ContentLanguage.
     *
     * @return string
     */
    public function getContentLanguage()
    {
        return $this->_contentLanguage;
    }

    /**
     * Sets ContentLanguage.
     *
     * @param string $contentLanguage value.
     */
    public function setContentLanguage($contentLanguage)
    {
        $this->_contentLanguage = $contentLanguage;
    }

    /**
     * Gets ContentMD5.
     *
     * @return string
     */
    public function getContentMD5()
    {
        return $this->_contentMD5;
    }

    /**
     * Sets ContentMD5.
     *
     * @param string $contentMD5 value.
     */
    public function setContentMD5($contentMD5)
    {
        $this->_contentMD5 = $contentMD5;
    }

    /**
     * Gets cache control.
     *
     * @return string
     */
    public function getCacheControl()
    {
        return $this->_cacheControl;
    }

    /**
     * Sets cacheControl.
     *
     * @param string $cacheControl value to use.
     */
    public function setCacheControl($cacheControl)
    {
        $this->_cacheControl = $cacheControl;
    }

    /**
     * Gets content disposition.
     *
     * @return string
     */
    public function getContentDisposition()
    {
        return $this->_contentDisposition;
    }

    /**
     * Sets contentDisposition.
     *
     * @param string $contentDisposition value to use.
     */
    public function setContentDisposition($contentDisposition)
    {
        $this->_contentDisposition = $contentDisposition;
    }

    /**
     * Gets blob metadata.
     *
     * @return array
     */
    public function getMetadata()
    {
        return $this->_metadata;
    }

    /**
     * Sets blob metadata.
     *
     * @param array $metadata value.
     */
    public function setMetadata(array $metadata = null)
    {
        $this->_metadata = $metadata;
    }

    /**
     * Create a instance using the given options
     *
     * @param mixed $options Input options
     *
     * @internal
     *
     * @return self
     */
    public static function create($options)
    {
        $result = new CommitBlobBlocksOptions();
        $result->setContentType($options->getContentType());
        $result->setContentEncoding($options->getContentEncoding());
        $result->setContentLanguage($options->getContentLanguage());
        $result->setContentMD5($options->getContentMD5());
        $result->setCacheControl($options->getCacheControl());
        $result->setContentDisposition($options->getContentDisposition());
        $result->setMetadata($options->getMetadata());
        $result->setLeaseId($options->getLeaseId());
        $result->setAccessConditions($options->getAccessConditions());

        return $result;
    }
}

<?php

namespace AzureOSS\Storage\Blob\Models;

class SetBlobPropertiesOptions extends BlobServiceOptions
{
    private $_blobProperties;
    private $_sequenceNumberAction;

    /**
     * Creates a new SetBlobPropertiesOptions with a specified BlobProperties
     * instance.
     *
     * @param BlobProperties $blobProperties The blob properties instance.
     */
    public function __construct(BlobProperties $blobProperties = null)
    {
        parent::__construct();
        $this->_blobProperties = null === $blobProperties
            ? new BlobProperties() : clone $blobProperties;
    }

    /**
     * Gets blob sequenceNumber.
     *
     * @return int
     */
    public function getSequenceNumber()
    {
        return $this->_blobProperties->getSequenceNumber();
    }

    /**
     * Sets blob sequenceNumber.
     *
     * @param int $sequenceNumber value.
     */
    public function setSequenceNumber($sequenceNumber)
    {
        $this->_blobProperties->setSequenceNumber($sequenceNumber);
    }

    /**
     * Gets lease Id for the blob
     *
     * @return string
     */
    public function getSequenceNumberAction()
    {
        return $this->_sequenceNumberAction;
    }

    /**
     * Sets lease Id for the blob
     *
     * @param string $sequenceNumberAction action.
     */
    public function setSequenceNumberAction($sequenceNumberAction)
    {
        $this->_sequenceNumberAction = $sequenceNumberAction;
    }

    /**
     * Gets blob contentLength.
     *
     * @return int
     */
    public function getContentLength()
    {
        return $this->_blobProperties->getContentLength();
    }

    /**
     * Sets blob contentLength.
     *
     * @param int $contentLength value.
     */
    public function setContentLength($contentLength)
    {
        $this->_blobProperties->setContentLength($contentLength);
    }

    /**
     * Gets ContentType.
     *
     * @return string
     */
    public function getContentType()
    {
        return $this->_blobProperties->getContentType();
    }

    /**
     * Sets ContentType.
     *
     * @param string $contentType value.
     */
    public function setContentType($contentType)
    {
        $this->_blobProperties->setContentType($contentType);
    }

    /**
     * Gets ContentEncoding.
     *
     * @return string
     */
    public function getContentEncoding()
    {
        return $this->_blobProperties->getContentEncoding();
    }

    /**
     * Sets ContentEncoding.
     *
     * @param string $contentEncoding value.
     */
    public function setContentEncoding($contentEncoding)
    {
        $this->_blobProperties->setContentEncoding($contentEncoding);
    }

    /**
     * Gets ContentLanguage.
     *
     * @return string
     */
    public function getContentLanguage()
    {
        return $this->_blobProperties->getContentLanguage();
    }

    /**
     * Sets ContentLanguage.
     *
     * @param string $contentLanguage value.
     */
    public function setContentLanguage($contentLanguage)
    {
        $this->_blobProperties->setContentLanguage($contentLanguage);
    }

    /**
     * Gets ContentMD5.
     */
    public function getContentMD5()
    {
        return $this->_blobProperties->getContentMD5();
    }

    /**
     * Sets blob ContentMD5.
     *
     * @param string $contentMD5 value.
     */
    public function setContentMD5($contentMD5)
    {
        $this->_blobProperties->setContentMD5($contentMD5);
    }

    /**
     * Gets cache control.
     *
     * @return string
     */
    public function getCacheControl()
    {
        return $this->_blobProperties->getCacheControl();
    }

    /**
     * Sets cacheControl.
     *
     * @param string $cacheControl value to use.
     */
    public function setCacheControl($cacheControl)
    {
        $this->_blobProperties->setCacheControl($cacheControl);
    }

    /**
     * Gets content disposition.
     *
     * @return string
     */
    public function getContentDisposition()
    {
        return $this->_blobProperties->getContentDisposition();
    }

    /**
     * Sets contentDisposition.
     *
     * @param string $contentDisposition value to use.
     */
    public function setContentDisposition($contentDisposition)
    {
        $this->_blobProperties->setContentDisposition($contentDisposition);
    }
}

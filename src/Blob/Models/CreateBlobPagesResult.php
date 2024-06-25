<?php

namespace AzureOSS\Storage\Blob\Models;

use AzureOSS\Storage\Blob\Internal\BlobResources as Resources;
use AzureOSS\Storage\Common\Internal\Utilities;
use AzureOSS\Storage\Common\Internal\Validate;

class CreateBlobPagesResult
{
    private $contentMD5;
    private $etag;
    private $lastModified;
    private $requestServerEncrypted;
    private $sequenceNumber;

    /**
     * Creates CreateBlobPagesResult object from $parsed response in array
     * representation
     *
     * @param array $headers HTTP response headers
     *
     * @internal
     *
     * @return CreateBlobPagesResult
     */
    public static function create(array $headers)
    {
        $result = new CreateBlobPagesResult();
        $clean = array_change_key_case($headers);

        $date = $clean[Resources::LAST_MODIFIED];
        $date = Utilities::rfc1123ToDateTime($date);
        $result->setETag($clean[Resources::ETAG]);
        $result->setLastModified($date);

        $result->setContentMD5(
            Utilities::tryGetValue($clean, Resources::CONTENT_MD5),
        );

        $result->setRequestServerEncrypted(
            Utilities::toBoolean(
                Utilities::tryGetValueInsensitive(
                    Resources::X_MS_REQUEST_SERVER_ENCRYPTED,
                    $headers,
                ),
                true,
            ),
        );

        $result->setSequenceNumber(
            (int) (
                Utilities::tryGetValue(
                    $clean,
                    Resources::X_MS_BLOB_SEQUENCE_NUMBER,
                )
            ),
        );

        return $result;
    }

    /**
     * Gets blob lastModified.
     *
     * @return \DateTime.
     */
    public function getLastModified()
    {
        return $this->lastModified;
    }

    /**
     * Sets blob lastModified.
     *
     * @param \DateTime $lastModified value.
     */
    protected function setLastModified($lastModified)
    {
        Validate::isDate($lastModified);
        $this->lastModified = $lastModified;
    }

    /**
     * Gets blob etag.
     *
     * @return string
     */
    public function getETag()
    {
        return $this->etag;
    }

    /**
     * Sets blob etag.
     *
     * @param string $etag value.
     */
    protected function setETag($etag)
    {
        Validate::canCastAsString($etag, 'etag');
        $this->etag = $etag;
    }

    /**
     * Gets blob contentMD5.
     *
     * @return string
     */
    public function getContentMD5()
    {
        return $this->contentMD5;
    }

    /**
     * Sets blob contentMD5.
     *
     * @param string $contentMD5 value.
     */
    protected function setContentMD5($contentMD5)
    {
        $this->contentMD5 = $contentMD5;
    }

    /**
     * Gets the whether the contents of the request are successfully encrypted.
     *
     * @return bool
     */
    public function getRequestServerEncrypted()
    {
        return $this->requestServerEncrypted;
    }

    /**
     * Sets the request server encryption value.
     *
     * @param bool $requestServerEncrypted
     */
    public function setRequestServerEncrypted($requestServerEncrypted)
    {
        $this->requestServerEncrypted = $requestServerEncrypted;
    }

    /**
     * Gets blob sequenceNumber.
     *
     * @return int
     */
    public function getSequenceNumber()
    {
        return $this->sequenceNumber;
    }

    /**
     * Sets blob sequenceNumber.
     *
     * @param int $sequenceNumber value.
     */
    protected function setSequenceNumber($sequenceNumber)
    {
        Validate::isInteger($sequenceNumber, 'sequenceNumber');
        $this->sequenceNumber = $sequenceNumber;
    }
}

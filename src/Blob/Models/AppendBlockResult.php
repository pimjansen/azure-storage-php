<?php

namespace AzureOSS\Storage\Blob\Models;

use AzureOSS\Storage\Blob\Internal\BlobResources as Resources;
use AzureOSS\Storage\Common\Internal\Utilities;

class AppendBlockResult
{
    private $appendOffset;
    private $committedBlockCount;
    private $contentMD5;
    private $etag;
    private $lastModified;
    private $requestServerEncrypted;

    /**
     * Creates AppendBlockResult object from the response of the put block request.
     *
     * @param array $headers The HTTP response headers in array representation.
     *
     * @internal
     *
     * @return AppendBlockResult
     */
    public static function create(array $headers)
    {
        $result = new AppendBlockResult();

        $result->setAppendOffset(
            (int) (
                Utilities::tryGetValueInsensitive(
                    Resources::X_MS_BLOB_APPEND_OFFSET,
                    $headers,
                )
            ),
        );

        $result->setCommittedBlockCount(
            (int) (
                Utilities::tryGetValueInsensitive(
                    Resources::X_MS_BLOB_COMMITTED_BLOCK_COUNT,
                    $headers,
                )
            ),
        );

        $result->setContentMD5(
            Utilities::tryGetValueInsensitive(Resources::CONTENT_MD5, $headers),
        );

        $result->setEtag(
            Utilities::tryGetValueInsensitive(Resources::ETAG, $headers),
        );

        if (Utilities::arrayKeyExistsInsensitive(
            Resources::LAST_MODIFIED,
            $headers,
        )) {
            $lastModified = Utilities::tryGetValueInsensitive(
                Resources::LAST_MODIFIED,
                $headers,
            );
            $lastModified = Utilities::rfc1123ToDateTime($lastModified);

            $result->setLastModified($lastModified);
        }

        $result->setRequestServerEncrypted(
            Utilities::toBoolean(
                Utilities::tryGetValueInsensitive(
                    Resources::X_MS_REQUEST_SERVER_ENCRYPTED,
                    $headers,
                ),
                true,
            ),
        );

        return $result;
    }

    /**
     * Gets Etag of the blob that the client can use to perform conditional
     * PUT operations by using the If-Match request header.
     *
     * @return string
     */
    public function getEtag()
    {
        return $this->etag;
    }

    /**
     * Sets the etag value.
     *
     * @param string $etag etag as a string.
     */
    protected function setEtag($etag)
    {
        $this->etag = $etag;
    }

    /**
     * Gets $lastModified value.
     *
     * @return \DateTime
     */
    public function getLastModified()
    {
        return $this->lastModified;
    }

    /**
     * Sets the $lastModified value.
     *
     * @param \DateTime $lastModified $lastModified value.
     */
    protected function setLastModified($lastModified)
    {
        $this->lastModified = $lastModified;
    }

    /**
     * Gets block content MD5.
     *
     * @return string
     */
    public function getContentMD5()
    {
        return $this->contentMD5;
    }

    /**
     * Sets the content MD5 value.
     *
     * @param string $contentMD5 conent MD5 as a string.
     */
    protected function setContentMD5($contentMD5)
    {
        $this->contentMD5 = $contentMD5;
    }

    /**
     * Gets the offset at which the block was committed, in bytes.
     *
     * @return int
     */
    public function getAppendOffset()
    {
        return $this->appendOffset;
    }

    /**
     * Sets the offset at which the block was committed, in bytes.
     *
     * @param int $appendOffset append offset, in bytes.
     */
    protected function setAppendOffset($appendOffset)
    {
        $this->appendOffset = $appendOffset;
    }

    /**
     * Gets the number of committed blocks present in the blob.
     *
     * @return int
     */
    public function getCommittedBlockCount()
    {
        return $this->committedBlockCount;
    }

    /**
     * Sets the number of committed blocks present in the blob.
     *
     * @param int $committedBlockCount the number of committed blocks present in the blob.
     */
    protected function setCommittedBlockCount($committedBlockCount)
    {
        $this->committedBlockCount = $committedBlockCount;
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
}

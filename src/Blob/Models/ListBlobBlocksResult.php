<?php

namespace AzureOSS\Storage\Blob\Models;

use AzureOSS\Storage\Blob\Internal\BlobResources as Resources;
use AzureOSS\Storage\Common\Internal\Utilities;
use AzureOSS\Storage\Common\Internal\Validate;

class ListBlobBlocksResult
{
    private $lastModified;
    private $etag;
    private $contentType;
    private $contentLength;
    private $committedBlocks;
    private $uncommittedBlocks;

    /**
     * Gets block entries from parsed response
     *
     * @param array  $parsed HTTP response
     * @param string $type   Block type
     *
     * @return array
     */
    private static function getEntries(array $parsed, $type)
    {
        $entries = [];

        if (is_array($parsed)) {
            $rawEntries = [];

            if (
                array_key_exists($type, $parsed)
                && is_array($parsed[$type])
                && !empty($parsed[$type])
            ) {
                $rawEntries = Utilities::getArray($parsed[$type]['Block']);
            }

            foreach ($rawEntries as $value) {
                $entries[$value['Name']] = $value['Size'];
            }
        }

        return $entries;
    }

    /**
     * Creates ListBlobBlocksResult from given response headers and parsed body
     *
     * @param array $headers HTTP response headers
     * @param array $parsed  HTTP response body in array representation
     *
     * @internal
     *
     * @return ListBlobBlocksResult
     */
    public static function create(array $headers, array $parsed)
    {
        $result = new ListBlobBlocksResult();
        $clean = array_change_key_case($headers);

        $result->setETag(Utilities::tryGetValue($clean, Resources::ETAG));
        $date = Utilities::tryGetValue($clean, Resources::LAST_MODIFIED);
        if (null !== $date) {
            $date = Utilities::rfc1123ToDateTime($date);
            $result->setLastModified($date);
        }
        $result->setContentLength(
            (int) (
                Utilities::tryGetValue($clean, Resources::X_MS_BLOB_CONTENT_LENGTH)
            ),
        );
        $result->setContentType(
            Utilities::tryGetValue($clean, Resources::CONTENT_TYPE_LOWER_CASE),
        );

        $result->uncommittedBlocks = self::getEntries(
            $parsed,
            'UncommittedBlocks',
        );
        $result->committedBlocks = self::getEntries($parsed, 'CommittedBlocks');

        return $result;
    }

    /**
     * Gets blob lastModified.
     *
     * @return \DateTime
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
    protected function setLastModified(\DateTime $lastModified)
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
        $this->etag = $etag;
    }

    /**
     * Gets blob contentType.
     *
     * @return string
     */
    public function getContentType()
    {
        return $this->contentType;
    }

    /**
     * Sets blob contentType.
     *
     * @param string $contentType value.
     */
    protected function setContentType($contentType)
    {
        $this->contentType = $contentType;
    }

    /**
     * Gets blob contentLength.
     *
     * @return int
     */
    public function getContentLength()
    {
        return $this->contentLength;
    }

    /**
     * Sets blob contentLength.
     *
     * @param int $contentLength value.
     */
    protected function setContentLength($contentLength)
    {
        Validate::isInteger($contentLength, 'contentLength');
        $this->contentLength = $contentLength;
    }

    /**
     * Gets uncommitted blocks
     *
     * @return array
     */
    public function getUncommittedBlocks()
    {
        return $this->uncommittedBlocks;
    }

    /**
     * Sets uncommitted blocks
     *
     * @param array $uncommittedBlocks The uncommitted blocks entries
     */
    protected function setUncommittedBlocks(array $uncommittedBlocks)
    {
        $this->uncommittedBlocks = $uncommittedBlocks;
    }

    /**
     * Gets committed blocks
     *
     * @return array
     */
    public function getCommittedBlocks()
    {
        return $this->committedBlocks;
    }

    /**
     * Sets committed blocks
     *
     * @param array $committedBlocks The committed blocks entries
     */
    protected function setCommittedBlocks(array $committedBlocks)
    {
        $this->committedBlocks = $committedBlocks;
    }
}

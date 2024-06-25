<?php

namespace AzureOSS\Storage\Blob\Models;

use AzureOSS\Storage\Blob\Internal\BlobResources as Resources;
use AzureOSS\Storage\Common\Internal\Utilities;
use AzureOSS\Storage\Common\Internal\Validate;
use AzureOSS\Storage\Common\Models\Range;

class ListPageBlobRangesResult
{
    private $_lastModified;
    private $_etag;
    private $_contentLength;
    private $_pageRanges;

    /**
     * Creates BlobProperties object from $parsed response in array representation
     *
     * @param array $headers HTTP response headers
     * @param array $parsed  parsed response in array format.
     *
     * @internal
     *
     * @return ListPageBlobRangesResult
     */
    public static function create(array $headers, array $parsed = null)
    {
        $result = new ListPageBlobRangesResult();
        $headers = array_change_key_case($headers);

        $date = $headers[Resources::LAST_MODIFIED];
        $date = Utilities::rfc1123ToDateTime($date);
        $blobLength = (int) ($headers[Resources::X_MS_BLOB_CONTENT_LENGTH]);
        $rawRanges = [];

        if (!empty($parsed[Resources::XTAG_PAGE_RANGE])) {
            $parsed = array_change_key_case($parsed);
            $rawRanges = Utilities::getArray($parsed[strtolower(RESOURCES::XTAG_PAGE_RANGE)]);
        }

        $pageRanges = [];
        foreach ($rawRanges as $value) {
            $pageRanges[] = new Range(
                (int) ($value[Resources::XTAG_RANGE_START]),
                (int) ($value[Resources::XTAG_RANGE_END]),
            );
        }
        $result->setRanges($pageRanges);
        $result->setContentLength($blobLength);
        $result->setETag($headers[Resources::ETAG]);
        $result->setLastModified($date);

        return $result;
    }

    /**
     * Gets blob lastModified.
     *
     * @return \DateTime
     */
    public function getLastModified()
    {
        return $this->_lastModified;
    }

    /**
     * Sets blob lastModified.
     *
     * @param \DateTime $lastModified value.
     */
    protected function setLastModified(\DateTime $lastModified)
    {
        Validate::isDate($lastModified);
        $this->_lastModified = $lastModified;
    }

    /**
     * Gets blob etag.
     *
     * @return string
     */
    public function getETag()
    {
        return $this->_etag;
    }

    /**
     * Sets blob etag.
     *
     * @param string $etag value.
     */
    protected function setETag($etag)
    {
        Validate::canCastAsString($etag, 'etag');
        $this->_etag = $etag;
    }

    /**
     * Gets blob contentLength.
     *
     * @return int
     */
    public function getContentLength()
    {
        return $this->_contentLength;
    }

    /**
     * Sets blob contentLength.
     *
     * @param int $contentLength value.
     */
    protected function setContentLength($contentLength)
    {
        Validate::isInteger($contentLength, 'contentLength');
        $this->_contentLength = $contentLength;
    }

    /**
     * Gets page ranges
     *
     * @return array
     */
    public function getRanges()
    {
        return $this->_pageRanges;
    }

    /**
     * Sets page ranges
     *
     * @param array $pageRanges page ranges to set
     */
    protected function setRanges(array $pageRanges)
    {
        $this->_pageRanges = [];
        foreach ($pageRanges as $pageRange) {
            $this->_pageRanges[] = clone $pageRange;
        }
    }
}

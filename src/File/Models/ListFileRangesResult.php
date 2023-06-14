<?php

namespace AzureOSS\Storage\File\Models;

use AzureOSS\Storage\Common\Internal\Utilities;
use AzureOSS\Storage\Common\Internal\Validate;
use AzureOSS\Storage\Common\Models\Range;
use AzureOSS\Storage\File\Internal\FileResources as Resources;

class ListFileRangesResult
{
    private $lastModified;
    private $etag;
    private $contentLength;
    private $ranges;

    /**
     * Creates ListFileRangesResult object from $parsed response and
     * $headers in array representation
     *
     * @param array $headers HTTP response headers
     * @param array $parsed  parsed response in array format.
     *
     * @internal
     *
     * @return ListFileRangesResult
     */
    public static function create(array $headers, array $parsed = null)
    {
        $result = new ListFileRangesResult();
        $headers = array_change_key_case($headers);

        $date = $headers[Resources::LAST_MODIFIED];
        $date = Utilities::rfc1123ToDateTime($date);
        $fileLength = (int) ($headers[Resources::X_MS_CONTENT_LENGTH]);
        $rawRanges = [];
        if (!empty($parsed['Range'])) {
            $rawRanges = Utilities::getArray($parsed['Range']);
        }

        $ranges = [];
        foreach ($rawRanges as $value) {
            $ranges[] = new Range(
                (int) ($value['Start']),
                (int) ($value['End'])
            );
        }
        $result->setRanges($ranges);
        $result->setContentLength($fileLength);
        $result->setETag($headers[Resources::ETAG]);
        $result->setLastModified($date);

        return $result;
    }

    /**
     * Gets file lastModified.
     *
     * @return \DateTime
     */
    public function getLastModified()
    {
        return $this->lastModified;
    }

    /**
     * Sets file lastModified.
     *
     * @param \DateTime $lastModified value.
     */
    protected function setLastModified(\DateTime $lastModified)
    {
        Validate::isDate($lastModified);
        $this->lastModified = $lastModified;
    }

    /**
     * Gets file etag.
     *
     * @return string
     */
    public function getETag()
    {
        return $this->etag;
    }

    /**
     * Sets file etag.
     *
     * @param string $etag value.
     */
    protected function setETag($etag)
    {
        Validate::canCastAsString($etag, 'etag');
        $this->etag = $etag;
    }

    /**
     * Gets file contentLength.
     *
     * @return int
     */
    public function getContentLength()
    {
        return $this->contentLength;
    }

    /**
     * Sets file contentLength.
     *
     * @param int $contentLength value.
     */
    protected function setContentLength($contentLength)
    {
        Validate::isInteger($contentLength, 'contentLength');
        $this->contentLength = $contentLength;
    }

    /**
     * Gets ranges
     *
     * @return array
     */
    public function getRanges()
    {
        return $this->ranges;
    }

    /**
     * Sets ranges
     *
     * @param array $ranges ranges to set
     */
    protected function setRanges(array $ranges)
    {
        $this->ranges = [];
        foreach ($ranges as $range) {
            $this->ranges[] = clone $range;
        }
    }
}

<?php

namespace AzureOSS\Storage\Blob\Models;

use Psr\Http\Message\StreamInterface;

/**
 * Holds result of GetBlob API.
 *
 * @see      https://github.com/azure/azure-storage-php
 */
class GetBlobResult
{
    private $properties;
    private $metadata;
    private $contentStream;

    /**
     * Creates GetBlobResult from getBlob call.
     *
     * @param array           $headers  The HTTP response headers.
     * @param StreamInterface $body     The response body.
     * @param array           $metadata The blob metadata.
     *
     * @internal
     *
     * @return GetBlobResult
     */
    public static function create(
        array $headers,
        StreamInterface $body,
        array $metadata,
    ) {
        $result = new GetBlobResult();
        $result->setContentStream($body->detach());
        $result->setProperties(BlobProperties::createFromHttpHeaders($headers));
        $result->setMetadata(null === $metadata ? [] : $metadata);

        return $result;
    }

    /**
     * Gets blob metadata.
     *
     * @return array
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * Sets blob metadata.
     *
     * @param array $metadata value.
     */
    protected function setMetadata(array $metadata)
    {
        $this->metadata = $metadata;
    }

    /**
     * Gets blob properties.
     *
     * @return BlobProperties
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * Sets blob properties.
     *
     * @param BlobProperties $properties value.
     */
    protected function setProperties(BlobProperties $properties)
    {
        $this->properties = $properties;
    }

    /**
     * Gets blob contentStream.
     *
     * @return resource
     */
    public function getContentStream()
    {
        return $this->contentStream;
    }

    /**
     * Sets blob contentStream.
     *
     * @param resource $contentStream The stream handle.
     */
    protected function setContentStream($contentStream)
    {
        $this->contentStream = $contentStream;
    }
}

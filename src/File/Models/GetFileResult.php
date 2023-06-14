<?php

namespace AzureOSS\Storage\File\Models;

use Psr\Http\Message\StreamInterface;

class GetFileResult
{
    private $properties;
    private $metadata;
    private $contentStream;

    /**
     * Creates GetFileResult from getFile call.
     *
     * @param array           $headers  The HTTP response headers.
     * @param StreamInterface $body     The response body.
     * @param array           $metadata The file metadata.
     *
     * @internal
     *
     * @return GetFileResult
     */
    public static function create(
        array $headers,
        StreamInterface $body,
        array $metadata
    ) {
        $result = new GetFileResult();
        $result->setContentStream($body->detach());
        $result->setProperties(FileProperties::createFromHttpHeaders($headers));
        $result->setMetadata(null === $metadata ? [] : $metadata);

        return $result;
    }

    /**
     * Gets file metadata.
     *
     * @return array
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * Sets file metadata.
     *
     * @param array $metadata value.
     */
    protected function setMetadata(array $metadata)
    {
        $this->metadata = $metadata;
    }

    /**
     * Gets file properties.
     *
     * @return FileProperties
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * Sets file properties.
     *
     * @param FileProperties $properties value.
     */
    protected function setProperties(FileProperties $properties)
    {
        $this->properties = $properties;
    }

    /**
     * Gets file contentStream.
     *
     * @return resource
     */
    public function getContentStream()
    {
        return $this->contentStream;
    }

    /**
     * Sets file contentStream.
     *
     * @param resource $contentStream The stream handle.
     */
    protected function setContentStream($contentStream)
    {
        $this->contentStream = $contentStream;
    }
}

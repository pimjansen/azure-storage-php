<?php

namespace AzureOSS\Storage\Common\Internal;

trait MetadataTrait
{
    private $lastModified;
    private $etag;
    private $metadata;

    /**
     * Any operation that modifies the share or its properties or metadata
     * updates the last modified time. Operations on files do not affect the
     * last modified time of the share.
     *
     * @return \DateTime.
     */
    public function getLastModified()
    {
        return $this->lastModified;
    }

    /**
     * Sets share lastModified.
     *
     * @param \DateTime $lastModified value.
     */
    protected function setLastModified(\DateTime $lastModified)
    {
        $this->lastModified = $lastModified;
    }

    /**
     * The entity tag for the share. If the request version is 2011-08-18 or
     * newer, the ETag value will be in quotes.
     *
     * @return string
     */
    public function getETag()
    {
        return $this->etag;
    }

    /**
     * Sets share etag.
     *
     * @param string $etag value.
     */
    protected function setETag($etag)
    {
        $this->etag = $etag;
    }

    /**
     * Gets user defined metadata.
     *
     * @return array
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * Sets user defined metadata. This metadata should be added without the
     * header prefix (x-ms-meta-*).
     *
     * @param array $metadata user defined metadata object in array form.
     */
    protected function setMetadata(array $metadata)
    {
        $this->metadata = $metadata;
    }

    /**
     * Create an instance using the response headers from the API call.
     *
     * @param array $responseHeaders The array contains all the response headers
     *
     * @internal
     *
     * @return GetShareMetadataResult
     */
    public static function createMetadataResult(array $responseHeaders)
    {
        $result = new static();
        $metadata = Utilities::getMetadataArray($responseHeaders);
        $date = Utilities::tryGetValueInsensitive(
            Resources::LAST_MODIFIED,
            $responseHeaders,
        );
        $date = Utilities::rfc1123ToDateTime($date);
        $result->setETag(Utilities::tryGetValueInsensitive(
            Resources::ETAG,
            $responseHeaders,
        ));
        $result->setMetadata($metadata);
        $result->setLastModified($date);

        return $result;
    }
}

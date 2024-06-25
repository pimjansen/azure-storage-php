<?php

namespace AzureOSS\Storage\Blob\Models;

use AzureOSS\Storage\Blob\Internal\BlobResources as Resources;
use AzureOSS\Storage\Common\Internal\Utilities;

class CreateBlobSnapshotResult
{
    private $_snapshot;
    private $_etag;
    private $_lastModified;

    /**
     * Creates CreateBlobSnapshotResult object from the response of the
     * create Blob snapshot request.
     *
     * @param array $headers The HTTP response headers in array representation.
     *
     * @internal
     *
     * @return CreateBlobSnapshotResult
     */
    public static function create(array $headers)
    {
        $result = new CreateBlobSnapshotResult();
        $headerWithLowerCaseKey = array_change_key_case($headers);

        $result->setETag($headerWithLowerCaseKey[Resources::ETAG]);

        $result->setLastModified(
            Utilities::rfc1123ToDateTime(
                $headerWithLowerCaseKey[Resources::LAST_MODIFIED],
            ),
        );

        $result->setSnapshot($headerWithLowerCaseKey[Resources::X_MS_SNAPSHOT]);

        return $result;
    }

    /**
     * Gets snapshot.
     *
     * @return string
     */
    public function getSnapshot()
    {
        return $this->_snapshot;
    }

    /**
     * Sets snapshot.
     *
     * @param string $snapshot value.
     */
    protected function setSnapshot($snapshot)
    {
        $this->_snapshot = $snapshot;
    }

    /**
     * Gets ETag.
     *
     * @return string
     */
    public function getETag()
    {
        return $this->_etag;
    }

    /**
     * Sets ETag.
     *
     * @param string $etag value.
     */
    protected function setETag($etag)
    {
        $this->_etag = $etag;
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
    protected function setLastModified($lastModified)
    {
        $this->_lastModified = $lastModified;
    }
}

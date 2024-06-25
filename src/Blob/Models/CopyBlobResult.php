<?php

namespace AzureOSS\Storage\Blob\Models;

use AzureOSS\Storage\Blob\Internal\BlobResources as Resources;
use AzureOSS\Storage\Common\Internal\Utilities;

class CopyBlobResult
{
    private $_etag;
    private $_lastModified;
    private $_copyId;
    private $_copyStatus;

    /**
     * Creates CopyBlobResult object from the response of the copy blob request.
     *
     * @param array $headers The HTTP response headers in array representation.
     *
     * @internal
     *
     * @return CopyBlobResult
     */
    public static function create(array $headers)
    {
        $result = new CopyBlobResult();
        $result->setETag(
            Utilities::tryGetValueInsensitive(
                Resources::ETAG,
                $headers,
            ),
        );
        $result->setCopyId(
            Utilities::tryGetValueInsensitive(
                Resources::X_MS_COPY_ID,
                $headers,
            ),
        );
        $result->setCopyStatus(
            Utilities::tryGetValueInsensitive(
                Resources::X_MS_COPY_STATUS,
                $headers,
            ),
        );
        if (Utilities::arrayKeyExistsInsensitive(Resources::LAST_MODIFIED, $headers)) {
            $lastModified = Utilities::tryGetValueInsensitive(
                Resources::LAST_MODIFIED,
                $headers,
            );
            $result->setLastModified(Utilities::rfc1123ToDateTime($lastModified));
        }

        return $result;
    }

    /**
     * Gets copy Id
     *
     * @return string
     */
    public function getCopyId()
    {
        return $this->_copyId;
    }

    /**
     * Sets copy Id
     *
     * @param string $copyId the blob copy id.
     *
     * @internal
     */
    protected function setCopyId($copyId)
    {
        $this->_copyId = $copyId;
    }

    /**
     * Gets copy status
     *
     * @return string
     */
    public function getCopyStatus()
    {
        return $this->_copyStatus;
    }

    /**
     * Sets copy status
     *
     * @internal
     */
    protected function setCopyStatus($copystatus)
    {
        $this->_copyStatus = $copystatus;
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
    protected function setLastModified(\DateTime $lastModified)
    {
        $this->_lastModified = $lastModified;
    }
}

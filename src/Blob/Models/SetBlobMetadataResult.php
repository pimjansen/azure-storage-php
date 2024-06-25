<?php

namespace AzureOSS\Storage\Blob\Models;

use AzureOSS\Storage\Blob\Internal\BlobResources as Resources;
use AzureOSS\Storage\Common\Internal\Utilities;
use AzureOSS\Storage\Common\Internal\Validate;

class SetBlobMetadataResult
{
    private $etag;
    private $lastModified;
    private $requestServerEncrypted;

    /**
     * Creates SetBlobMetadataResult from response headers.
     *
     * @param array $headers response headers
     *
     * @internal
     *
     * @return SetBlobMetadataResult
     */
    public static function create(array $headers)
    {
        $result = new SetBlobMetadataResult();

        $result->setETag(Utilities::tryGetValueInsensitive(
            Resources::ETAG,
            $headers,
        ));

        $date = Utilities::tryGetValueInsensitive(
            Resources::LAST_MODIFIED,
            $headers,
        );
        $result->setLastModified(Utilities::rfc1123ToDateTime($date));

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
        Validate::canCastAsString($etag, 'etag');
        $this->etag = $etag;
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

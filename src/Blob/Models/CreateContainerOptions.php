<?php

namespace AzureOSS\Storage\Blob\Models;

use AzureOSS\Storage\Common\Internal\Validate;

class CreateContainerOptions extends BlobServiceOptions
{
    private $_publicAccess;
    private $_metadata;

    /**
     * Gets container public access.
     *
     * @return string
     */
    public function getPublicAccess()
    {
        return $this->_publicAccess;
    }

    /**
     * Specifies whether data in the container may be accessed publicly and the level
     * of access. Possible values include:
     * 1) container: Specifies full public read access for container and blob data.
     *    Clients can enumerate blobs within the container via anonymous request, but
     *    cannot enumerate containers within the storage account.
     * 2) blob: Specifies public read access for blobs. Blob data within this
     *    container can be read via anonymous request, but container data is not
     *    available. Clients cannot enumerate blobs within the container via
     *    anonymous request.
     * If this value is not specified in the request, container data is private to
     * the account owner.
     *
     * @param string $publicAccess access modifier for the container
     */
    public function setPublicAccess($publicAccess)
    {
        Validate::canCastAsString($publicAccess, 'publicAccess');
        $this->_publicAccess = $publicAccess;
    }

    /**
     * Gets user defined metadata.
     *
     * @return array
     */
    public function getMetadata()
    {
        return $this->_metadata;
    }

    /**
     * Sets user defined metadata. This metadata should be added without the header
     * prefix (x-ms-meta-*).
     *
     * @param array $metadata user defined metadata object in array form.
     */
    public function setMetadata(array $metadata)
    {
        $this->_metadata = $metadata;
    }

    /**
     * Adds new metadata element. This element should be added without the header
     * prefix (x-ms-meta-*).
     *
     * @param string $key   metadata key element.
     * @param string $value metadata value element.
     */
    public function addMetadata($key, $value)
    {
        $this->_metadata[$key] = $value;
    }
}

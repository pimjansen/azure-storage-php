<?php

namespace AzureOSS\Storage\Blob\Models;

class GetContainerACLResult
{
    private $containerACL;
    private $lastModified;

    private $etag;

    /**
     * Parses the given array into signed identifiers
     *
     * @param string    $publicAccess container public access
     * @param string    $etag         container etag
     * @param \DateTime $lastModified last modification date
     * @param array     $parsed       parsed response into array
     *                                representation
     *
     * @internal
     *
     * @return self
     */
    public static function create(
        $publicAccess,
        $etag,
        \DateTime $lastModified,
        array $parsed = null,
    ) {
        $result = new GetContainerAclResult();
        $result->setETag($etag);
        $result->setLastModified($lastModified);
        $acl = ContainerACL::create($publicAccess, $parsed);
        $result->setContainerAcl($acl);

        return $result;
    }

    /**
     * Gets container ACL
     *
     * @return ContainerACL
     */
    public function getContainerAcl()
    {
        return $this->containerACL;
    }

    /**
     * Sets container ACL
     *
     * @param ContainerACL $containerACL value.
     */
    protected function setContainerAcl(ContainerACL $containerACL)
    {
        $this->containerACL = $containerACL;
    }

    /**
     * Gets container lastModified.
     *
     * @return \DateTime.
     */
    public function getLastModified()
    {
        return $this->lastModified;
    }

    /**
     * Sets container lastModified.
     *
     * @param \DateTime $lastModified value.
     */
    protected function setLastModified(\DateTime $lastModified)
    {
        $this->lastModified = $lastModified;
    }

    /**
     * Gets container etag.
     *
     * @return string
     */
    public function getETag()
    {
        return $this->etag;
    }

    /**
     * Sets container etag.
     *
     * @param string $etag value.
     */
    protected function setETag($etag)
    {
        $this->etag = $etag;
    }
}

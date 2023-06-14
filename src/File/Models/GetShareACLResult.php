<?php

namespace AzureOSS\Storage\File\Models;

class GetShareACLResult
{
    private $shareACL;
    private $lastModified;
    private $etag;

    /**
     * Parses the given array into signed identifiers
     *
     * @param string    $etag         share etag
     * @param \DateTime $lastModified last modification date
     * @param array     $parsed       parsed response into array
     *                                representation
     *
     * @internal
     *
     * @return self
     */
    public static function create(
        $etag,
        \DateTime $lastModified,
        array $parsed = null
    ) {
        $result = new GetShareAclResult();
        $result->setETag($etag);
        $result->setLastModified($lastModified);
        $acl = ShareACL::create($parsed);
        $result->setShareAcl($acl);

        return $result;
    }

    /**
     * Gets share ACL
     *
     * @return ShareACL
     */
    public function getShareAcl()
    {
        return $this->shareACL;
    }

    /**
     * Sets share ACL
     *
     * @param ShareACL $shareACL value.
     */
    protected function setShareAcl(ShareACL $shareACL)
    {
        $this->shareACL = $shareACL;
    }

    /**
     * Gets share lastModified.
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
     * Gets share etag.
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
}

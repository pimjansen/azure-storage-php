<?php

namespace AzureOSS\Storage\File\Models;

use AzureOSS\Storage\Common\Internal\Utilities;
use AzureOSS\Storage\File\Internal\FileResources as Resources;

class ShareProperties
{
    private $lastModified;
    private $etag;
    private $quota;

    /**
     * Creates an instance with given response array.
     *
     * @param array $parsedResponse The response array.
     *
     * @return ShareProperties
     */
    public static function create(array $parsedResponse)
    {
        $result = new ShareProperties();
        $date = $parsedResponse[Resources::QP_LAST_MODIFIED];
        $date = Utilities::rfc1123ToDateTime($date);
        $result->setLastModified($date);
        $result->setETag($parsedResponse[Resources::QP_ETAG]);
        $result->setQuota($parsedResponse[Resources::QP_QUOTA]);
        return $result;
    }

    /**
     * Gets share lastModified.
     *
     * @return \DateTime
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
    public function setLastModified(\DateTime $lastModified)
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
    public function setETag($etag)
    {
        $this->etag = $etag;
    }

    /**
     * Gets share quota.
     *
     * @return string
     */
    public function getQuota()
    {
        return $this->quota;
    }

    /**
     * Sets share quota.
     *
     * @param string $quota value.
     */
    public function setQuota($quota)
    {
        $this->quota = $quota;
    }
}

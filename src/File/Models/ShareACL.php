<?php

namespace AzureOSS\Storage\File\Models;

use AzureOSS\Storage\Common\Internal\ACLBase;
use AzureOSS\Storage\Common\Internal\Validate;
use AzureOSS\Storage\File\Internal\FileResources as Resources;

class ShareACL extends ACLBase
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        //setting the resource type to a default value.
        $this->setResourceType(Resources::RESOURCE_TYPE_SHARE);
    }

    /**
     * Parses the given array into signed identifiers and create an instance of
     * ShareACL
     *
     * @param array $parsed The parsed response into array representation.
     *
     * @internal
     *
     * @return ShareACL
     */
    public static function create(array $parsed = null)
    {
        $result = new ShareACL();
        $result->fromXmlArray($parsed);

        return $result;
    }

    /**
     * Validate if the resource type is for the class.
     *
     * @param string $resourceType the resource type to be validated.
     *
     * @throws \InvalidArgumentException
     *
     * @internal
     */
    protected static function validateResourceType($resourceType)
    {
        Validate::isTrue(
            $resourceType == Resources::RESOURCE_TYPE_SHARE
                || $resourceType == Resources::RESOURCE_TYPE_FILE,
            Resources::INVALID_RESOURCE_TYPE
        );
    }

    /**
     * Create a ShareAccessPolicy object.
     *
     * @return ShareAccessPolicy
     */
    protected static function createAccessPolicy()
    {
        return new ShareAccessPolicy();
    }
}

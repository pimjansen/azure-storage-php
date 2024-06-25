<?php

namespace AzureOSS\Storage\Blob\Models;

use AzureOSS\Storage\Blob\Internal\BlobResources as Resources;
use AzureOSS\Storage\Common\Internal\ACLBase;
use AzureOSS\Storage\Common\Internal\Validate;

class ContainerACL extends ACLBase
{
    private $publicAccess;

    /**
     * Constructor.
     */
    public function __construct()
    {
        //setting the resource type to a default value.
        $this->setResourceType(Resources::RESOURCE_TYPE_CONTAINER);
    }

    /**
     * Parses the given array into signed identifiers and create an instance of
     * ContainerACL
     *
     * @param string $publicAccess The container public access.
     * @param array  $parsed       The parsed response into array representation.
     *
     * @internal
     *
     * @return ContainerACL
     */
    public static function create($publicAccess, array $parsed = null)
    {
        Validate::isTrue(
            PublicAccessType::isValid($publicAccess),
            Resources::INVALID_BLOB_PAT_MSG,
        );
        $result = new ContainerACL();
        $result->fromXmlArray($parsed);
        $result->setPublicAccess($publicAccess);

        return $result;
    }

    /**
     * Gets container publicAccess.
     *
     * @return string
     */
    public function getPublicAccess()
    {
        return $this->publicAccess;
    }

    /**
     * Sets container publicAccess.
     *
     * @param string $publicAccess value.
     */
    public function setPublicAccess($publicAccess)
    {
        Validate::isTrue(
            PublicAccessType::isValid($publicAccess),
            Resources::INVALID_BLOB_PAT_MSG,
        );
        $this->publicAccess = $publicAccess;
        $this->setResourceType(
            self::getResourceTypeByPublicAccess($publicAccess),
        );
    }

    /**
     * Gets the resource type according to the given public access. Default
     * value is Resources::RESOURCE_TYPE_CONTAINER.
     *
     * @param string $publicAccess The public access that determines the
     *                             resource type.
     *
     * @return string
     */
    private static function getResourceTypeByPublicAccess($publicAccess)
    {
        $result = '';

        switch ($publicAccess) {
            case PublicAccessType::BLOBS_ONLY:
                $result = Resources::RESOURCE_TYPE_BLOB;
                break;
            case PublicAccessType::CONTAINER_AND_BLOBS:
                $result = Resources::RESOURCE_TYPE_CONTAINER;
                break;
            default:
                $result = Resources::RESOURCE_TYPE_CONTAINER;
                break;
        }

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
            $resourceType == Resources::RESOURCE_TYPE_BLOB
                || $resourceType == Resources::RESOURCE_TYPE_CONTAINER,
            Resources::INVALID_RESOURCE_TYPE,
        );
    }

    /**
     * Create a ContainerAccessPolicy object.
     *
     * @return ContainerAccessPolicy
     */
    protected static function createAccessPolicy()
    {
        return new ContainerAccessPolicy();
    }
}

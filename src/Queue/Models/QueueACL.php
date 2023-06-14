<?php

namespace AzureOSS\Storage\Queue\Models;

use AzureOSS\Storage\Common\Internal\ACLBase;
use AzureOSS\Storage\Common\Internal\Validate;
use AzureOSS\Storage\Queue\Internal\QueueResources as Resources;

class QueueACL extends ACLBase
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        //setting the resource type to a default value.
        $this->setResourceType(Resources::RESOURCE_TYPE_QUEUE);
    }

    /**
     * Parses the given array into signed identifiers and create an instance of
     * QueueACL
     *
     * @param array $parsed The parsed response into array representation.
     *
     * @internal
     *
     * @return QueueACL
     */
    public static function create(array $parsed = null)
    {
        $result = new QueueACL();
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
            $resourceType == Resources::RESOURCE_TYPE_QUEUE,
            Resources::INVALID_RESOURCE_TYPE
        );
    }

    /**
     * Create a QueueAccessPolicy object.
     *
     * @return QueueAccessPolicy
     */
    protected static function createAccessPolicy()
    {
        return new QueueAccessPolicy();
    }
}

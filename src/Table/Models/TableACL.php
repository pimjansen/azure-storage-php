<?php

namespace AzureOSS\Storage\Table\Models;

use AzureOSS\Storage\Common\Internal\ACLBase;
use AzureOSS\Storage\Common\Internal\Validate;
use AzureOSS\Storage\Table\Internal\TableResources as Resources;

class TableACL extends ACLBase
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        //setting the resource type to a default value.
        $this->setResourceType(Resources::RESOURCE_TYPE_TABLE);
    }

    /**
     * Parses the given array into signed identifiers and create an instance of
     * TableACL
     *
     * @param array $parsed The parsed response into array representation.
     *
     * @internal
     *
     * @return TableACL
     */
    public static function create(array $parsed = null)
    {
        $result = new TableACL();
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
            $resourceType == Resources::RESOURCE_TYPE_TABLE,
            Resources::INVALID_RESOURCE_TYPE
        );
    }

    /**
     * Create a TableAccessPolicy object.
     *
     * @return TableAccessPolicy
     */
    protected static function createAccessPolicy()
    {
        return new TableAccessPolicy();
    }
}

<?php

namespace AzureOSS\Storage\Common\Models;

use AzureOSS\Storage\Common\Internal\Resources;
use AzureOSS\Storage\Common\Internal\Utilities;
use AzureOSS\Storage\Common\Internal\Validate;

abstract class AccessPolicy
{
    private $start;
    private $expiry;
    private $permission;
    private $resourceType;

    /**
     * Get the valid permissions for the given resource.
     *
     * @return array
     */
    abstract protected static function getResourceValidPermissions();

    /**
     * Constructor
     *
     * @param string $resourceType the resource type of this access policy.
     */
    public function __construct($resourceType)
    {
        Validate::canCastAsString($resourceType, 'resourceType');
        Validate::isTrue(
            $resourceType == Resources::RESOURCE_TYPE_BLOB
                || $resourceType == Resources::RESOURCE_TYPE_CONTAINER
                || $resourceType == Resources::RESOURCE_TYPE_QUEUE
                || $resourceType == Resources::RESOURCE_TYPE_TABLE
                || $resourceType == Resources::RESOURCE_TYPE_FILE
                || $resourceType == Resources::RESOURCE_TYPE_SHARE,
            Resources::ERROR_RESOURCE_TYPE_NOT_SUPPORTED,
        );

        $this->resourceType = $resourceType;
    }

    /**
     * Gets start.
     *
     * @return \DateTime.
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Sets start.
     *
     * @param \DateTime $start value.
     */
    public function setStart(\DateTime $start = null)
    {
        if ($start != null) {
            Validate::isDate($start);
        }
        $this->start = $start;
    }

    /**
     * Gets expiry.
     *
     * @return \DateTime.
     */
    public function getExpiry()
    {
        return $this->expiry;
    }

    /**
     * Sets expiry.
     *
     * @param \DateTime $expiry value.
     */
    public function setExpiry($expiry)
    {
        Validate::isDate($expiry);
        $this->expiry = $expiry;
    }

    /**
     * Gets permission.
     *
     * @return string.
     */
    public function getPermission()
    {
        return $this->permission;
    }

    /**
     * Sets permission.
     *
     * @param string $permission value.
     *
     * @throws \InvalidArgumentException
     */
    public function setPermission($permission)
    {
        $this->permission = $this->validatePermission($permission);
    }

    /**
     * Gets resource type.
     *
     * @return string.
     */
    public function getResourceType()
    {
        return $this->resourceType;
    }

    /**
     * Validate the permission against its corresponding allowed permissions
     *
     * @param string $permission The permission to be validated.
     *
     * @throws \InvalidArgumentException
     *
     * @return string
     */
    private function validatePermission($permission)
    {
        $validPermissions = static::getResourceValidPermissions();
        $result = '';
        foreach ($validPermissions as $validPermission) {
            if (strpos($permission, $validPermission) !== false) {
                //append the valid permission to result.
                $result .= $validPermission;
                //remove all the character that represents the permission.
                $permission = str_replace(
                    $validPermission,
                    '',
                    $permission,
                );
            }
        }
        //After filtering all the permissions, if there is still characters
        //left in the given permission, throw exception.
        Validate::isTrue(
            $permission == '',
            sprintf(
                Resources::INVALID_PERMISSION_PROVIDED,
                $this->getResourceType(),
                implode(', ', $validPermissions),
            ),
        );

        return $result;
    }

    /**
     * Converts this current object to XML representation.
     *
     * @internal
     *
     * @return array
     */
    public function toArray()
    {
        $array = [];

        if ($this->getStart() != null) {
            $array[Resources::XTAG_SIGNED_START] =
                Utilities::convertToEdmDateTime($this->getStart());
        }
        $array[Resources::XTAG_SIGNED_EXPIRY] =
            Utilities::convertToEdmDateTime($this->getExpiry());
        $array[Resources::XTAG_SIGNED_PERMISSION] = $this->getPermission();

        return $array;
    }
}

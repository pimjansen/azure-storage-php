<?php

namespace AzureOSS\Storage\Table\Models;

use AzureOSS\Storage\Common\Models\AccessPolicy;
use AzureOSS\Storage\Table\Internal\TableResources;

class TableAccessPolicy extends AccessPolicy
{
    /**
     * Get the valid permissions for the given resource.
     *
     * @return array
     */
    public static function getResourceValidPermissions()
    {
        return TableResources::ACCESS_PERMISSIONS[TableResources::RESOURCE_TYPE_TABLE];
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct(TableResources::RESOURCE_TYPE_TABLE);
    }
}

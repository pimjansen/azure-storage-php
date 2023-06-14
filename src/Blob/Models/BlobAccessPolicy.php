<?php

namespace AzureOSS\Storage\Blob\Models;

use AzureOSS\Storage\Blob\Internal\BlobResources;
use AzureOSS\Storage\Common\Models\AccessPolicy;

class BlobAccessPolicy extends AccessPolicy
{
    /**
     * Get the valid permissions for the given resource.
     *
     * @return array
     */
    public static function getResourceValidPermissions()
    {
        return BlobResources::ACCESS_PERMISSIONS[BlobResources::RESOURCE_TYPE_BLOB];
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct(BlobResources::RESOURCE_TYPE_BLOB);
    }
}

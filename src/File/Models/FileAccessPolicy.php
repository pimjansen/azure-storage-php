<?php

namespace AzureOSS\Storage\File\Models;

use AzureOSS\Storage\Common\Models\AccessPolicy;
use AzureOSS\Storage\File\Internal\FileResources;

class FileAccessPolicy extends AccessPolicy
{
    /**
     * Get the valid permissions for the given resource.
     *
     * @return array
     */
    public static function getResourceValidPermissions()
    {
        return FileResources::ACCESS_PERMISSIONS[FileResources::RESOURCE_TYPE_FILE];
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct(FileResources::RESOURCE_TYPE_FILE);
    }
}

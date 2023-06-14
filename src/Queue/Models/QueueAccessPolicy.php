<?php

namespace AzureOSS\Storage\Queue\Models;

use AzureOSS\Storage\Common\Models\AccessPolicy;
use AzureOSS\Storage\Queue\Internal\QueueResources;

class QueueAccessPolicy extends AccessPolicy
{
    /**
     * Get the valid permissions for the given resource.
     *
     * @return array
     */
    public static function getResourceValidPermissions()
    {
        return QueueResources::ACCESS_PERMISSIONS[QueueResources::RESOURCE_TYPE_QUEUE];
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct(QueueResources::RESOURCE_TYPE_QUEUE);
    }
}

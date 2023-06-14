<?php

namespace AzureOSS\Storage\File\Internal;

use AzureOSS\Storage\Common\Internal\Resources;

class FileResources extends Resources
{
    public const FILE_SDK_VERSION = '1.2.5';
    public const STORAGE_API_LATEST_VERSION = '2016-05-31';

    // Error messages
    public const FILE_LOCATION_IS_PRIMARY_ONLY = "Can only specify PRIMARY_ONLY for file service's location mode.";
    public const FILE_SHARE_PROPERTIES_OPERATION_INVALID = "The operation is invalid. Can only be 'metadata' or 'properties'.";

    // Headers
    public const X_MS_SHARE_QUOTA = 'x-ms-share-quota';
    public const FILE_CONTENT_MD5 = 'x-ms-content-md5';

    // Query parameters
    public const QP_SHARES = 'Shares';
    public const QP_SHARE = 'Share';
    public const QP_DIRECTORY = 'Directory';
    public const QP_FILE = 'File';

    // Common used XML tags
    public const XTAG_SHARE_USAGE = 'ShareUsage';

    // Resource permissions
    public const ACCESS_PERMISSIONS = [
        Resources::RESOURCE_TYPE_FILE => ['r', 'c', 'w', 'd'],
        Resources::RESOURCE_TYPE_SHARE => ['r', 'c', 'w', 'd', 'l'],
    ];
}

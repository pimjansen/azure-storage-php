<?php

namespace AzureOSS\Storage\Table\Models;

use AzureOSS\Storage\Common\Internal\Validate;
use AzureOSS\Storage\Table\Internal\TableResources as Resources;

class AcceptJSONContentType
{
    public const NO_METADATA = Resources::JSON_NO_METADATA_CONTENT_TYPE;
    public const MINIMAL_METADATA = Resources::JSON_MINIMAL_METADATA_CONTENT_TYPE;
    public const FULL_METADATA = Resources::JSON_FULL_METADATA_CONTENT_TYPE;

    public static function validateAcceptContentType($contentType)
    {
        Validate::isTrue(
            $contentType == self::NO_METADATA
                || $contentType == self::MINIMAL_METADATA
                || $contentType == self::FULL_METADATA,
            Resources::INVALID_ACCEPT_CONTENT_TYPE
        );
    }
}

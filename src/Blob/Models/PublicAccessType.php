<?php

namespace AzureOSS\Storage\Blob\Models;

class PublicAccessType
{
    public const NONE = null;
    public const BLOBS_ONLY = 'blob';
    public const CONTAINER_AND_BLOBS = 'container';

    /**
     * Validates the public access.
     *
     * @param string $type The public access type.
     *
     * @internal
     *
     * @return bool
     */
    public static function isValid($type)
    {
        // When $type is null, switch statement will take it
        // equal to self::NONE (EMPTY_STRING)
        switch ($type) {
            case self::NONE:
            case self::BLOBS_ONLY:
            case self::CONTAINER_AND_BLOBS:
                return true;
            default:
                return false;
        }
    }
}

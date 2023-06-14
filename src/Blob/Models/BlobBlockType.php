<?php

namespace AzureOSS\Storage\Blob\Models;

class BlobBlockType
{
    public const COMMITTED_TYPE = 'Committed';
    public const UNCOMMITTED_TYPE = 'Uncommitted';
    public const LATEST_TYPE = 'Latest';

    /**
     * Validates the provided type.
     *
     * @param string $type The entry type.
     *
     * @internal
     *
     * @return bool
     */
    public static function isValid($type)
    {
        switch ($type) {
            case self::COMMITTED_TYPE:
            case self::LATEST_TYPE:
            case self::UNCOMMITTED_TYPE:
                return true;

            default:
                return false;
        }
    }
}

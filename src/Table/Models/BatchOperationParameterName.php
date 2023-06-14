<?php

namespace AzureOSS\Storage\Table\Models;

class BatchOperationParameterName
{
    public const BP_TABLE = 'table';
    public const BP_ENTITY = 'entity';
    public const BP_PARTITION_KEY = 'PartitionKey';
    public const BP_ROW_KEY = 'RowKey';
    public const BP_ETAG = 'etag';

    /**
     * Validates if $paramName is already defined.
     *
     * @param string $paramName The batch operation parameter name.
     *
     * @internal
     *
     * @return bool
     */
    public static function isValid($paramName)
    {
        switch ($paramName) {
            case self::BP_TABLE:
            case self::BP_ENTITY:
            case self::BP_PARTITION_KEY:
            case self::BP_ROW_KEY:
            case self::BP_ETAG:
                return true;
            default:
                return false;
        }
    }
}

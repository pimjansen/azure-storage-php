<?php

namespace AzureOSS\Storage\Table\Models;

class BatchOperationType
{
    public const INSERT_ENTITY_OPERATION = 'InsertEntityOperation';
    public const UPDATE_ENTITY_OPERATION = 'UpdateEntityOperation';
    public const DELETE_ENTITY_OPERATION = 'DeleteEntityOperation';
    public const MERGE_ENTITY_OPERATION = 'MergeEntityOperation';
    public const INSERT_REPLACE_ENTITY_OPERATION = 'InsertOrReplaceEntityOperation';
    public const INSERT_MERGE_ENTITY_OPERATION = 'InsertOrMergeEntityOperation';

    /**
     * Validates if $type is already defined.
     *
     * @param string $type The operation type.
     *
     * @internal
     *
     * @return bool
     */
    public static function isValid($type)
    {
        switch ($type) {
            case self::INSERT_ENTITY_OPERATION:
            case self::UPDATE_ENTITY_OPERATION:
            case self::DELETE_ENTITY_OPERATION:
            case self::MERGE_ENTITY_OPERATION:
            case self::INSERT_REPLACE_ENTITY_OPERATION:
            case self::INSERT_MERGE_ENTITY_OPERATION:
                return true;
            default:
                return false;
        }
    }
}

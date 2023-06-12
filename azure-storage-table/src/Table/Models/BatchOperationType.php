<?php

/**
 * LICENSE: The MIT License (the "License")
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 * https://github.com/azure/azure-storage-php/LICENSE
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * PHP version 5
 *
 * @see      https://github.com/azure/azure-storage-php
 */

namespace MicrosoftAzure\Storage\Table\Models;

/**
 * Supported batch operations.
 *
 * @see      https://github.com/azure/azure-storage-php
 */
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

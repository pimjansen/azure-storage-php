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

namespace MicrosoftAzure\Storage\Blob\Models;

/**
 * Holds available blob block types
 *
 * @see      https://github.com/azure/azure-storage-php
 */
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

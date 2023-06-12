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

namespace MicrosoftAzure\Storage\Tests\Unit\Blob\Models;

use MicrosoftAzure\Storage\Blob\Models\BlobBlockType;

/**
 * Unit tests for class BlobBlockType
 *
 * @see      https://github.com/azure/azure-storage-php
 */
class BlobBlockTypeTest extends \PHPUnit\Framework\TestCase
{
    public function testBlobBlockType()
    {
        self::assertEquals(BlobBlockType::COMMITTED_TYPE, 'Committed');
        self::assertEquals(BlobBlockType::UNCOMMITTED_TYPE, 'Uncommitted');
        self::assertEquals(BlobBlockType::LATEST_TYPE, 'Latest');
    }
}

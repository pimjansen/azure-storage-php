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

use MicrosoftAzure\Storage\Blob\Models\PublicAccessType;
use MicrosoftAzure\Storage\Common\Internal\Resources;

/**
 * Unit tests for class PublicAccessType
 *
 * @see      https://github.com/azure/azure-storage-php
 */
class PublicAccessTypeTest extends \PHPUnit\Framework\TestCase
{
    public function testPublicAccessType()
    {
        self::assertEquals(PublicAccessType::BLOBS_ONLY, 'blob');
        self::assertEquals(PublicAccessType::CONTAINER_AND_BLOBS, 'container');
        self::assertEquals(PublicAccessType::NONE, Resources::EMPTY_STRING);
    }
}

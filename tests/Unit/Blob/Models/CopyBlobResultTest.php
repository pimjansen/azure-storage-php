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

namespace AzureOSS\Storage\Tests\Unit\Blob\Models;

use AzureOSS\Storage\Blob\Models\CopyBlobResult;
use AzureOSS\Storage\Common\Internal\Resources;
use AzureOSS\Storage\Common\Internal\Utilities;

/**
 * Unit tests for class SnapshotBlobResult
 *
 * @see      https://github.com/azure/azure-storage-php
 */
class CopyBlobResultTest extends \PHPUnit\Framework\TestCase
{
    public function testCreate()
    {
        $expectedEtag = '12345678';
        $expectedLastModified = 'Fri, 16 Oct 2009 21:04:30 GMT';
        $headers = [
            Resources::ETAG => $expectedEtag,
            Resources::LAST_MODIFIED => $expectedLastModified,
        ];

        $result = CopyBlobResult::create($headers);

        self::assertEquals(
            $expectedEtag,
            $result->getETag(),
        );

        self::assertEquals(
            Utilities::rfc1123ToDateTime($expectedLastModified),
            $result->getLastModified(),
        );
    }
}

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

use AzureOSS\Storage\Blob\Models\ListBlobBlocksResult;
use AzureOSS\Storage\Common\Internal\Utilities;
use AzureOSS\Storage\Tests\Framework\TestResources;

/**
 * Unit tests for class ListBlobBlocksResult
 *
 * @see      https://github.com/azure/azure-storage-php
 */
class ListBlobBlocksResultTest extends \PHPUnit\Framework\TestCase
{
    public function testCreate()
    {
        // Setup
        $sampleHeaders = TestResources::listBlocksMultipleEntriesHeaders();
        $sampleBody = TestResources::listBlocksMultipleEntriesBody();
        $expectedDate = Utilities::rfc1123ToDateTime($sampleHeaders['Last-Modified']);
        $getEntry = self::getMethod('getEntries');
        $uncommittedBlocks = $getEntry->invokeArgs(null, [$sampleBody, 'UncommittedBlocks']);
        $committedBlocks = $getEntry->invokeArgs(null, [$sampleBody, 'CommittedBlocks']);

        // Test
        $actual = ListBlobBlocksResult::create(
            $sampleHeaders,
            $sampleBody,
        );

        // Assert
        self::assertEquals($expectedDate, $actual->getLastModified());
        self::assertEquals($sampleHeaders['Etag'], $actual->getETag());
        self::assertEquals($sampleHeaders['Content-Type'], $actual->getContentType());
        self::assertEquals($sampleHeaders['x-ms-blob-content-length'], $actual->getContentLength());
        self::assertEquals($uncommittedBlocks, $actual->getUncommittedBlocks());
        self::assertEquals($committedBlocks, $actual->getCommittedBlocks());
    }

    protected static function getMethod($name)
    {
        $class = new \ReflectionClass(new ListBlobBlocksResult());
        $method = $class->getMethod($name);
        $method->setAccessible(true);
        return $method;
    }
}

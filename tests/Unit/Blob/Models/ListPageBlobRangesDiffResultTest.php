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

use AzureOSS\Storage\Blob\Models\ListPageBlobRangesDiffResult;
use AzureOSS\Storage\Common\Internal\Utilities;
use AzureOSS\Storage\Common\Models\RangeDiff;
use AzureOSS\Storage\Tests\Framework\TestResources;

/**
 * Unit tests for class ListPageBlobRangesDiffResult
 *
 * @see      https://github.com/azure/azure-storage-php
 */
class ListPageBlobRangesDiffResultTest extends \PHPUnit\Framework\TestCase
{
    public function testCreate()
    {
        // Setup
        $headers = TestResources::listPageRangeHeaders();
        $bodyArray = TestResources::listPageRangeDiffBodyInArray();
        // Prepare expected page range
        $rawPageRanges = [];
        if (!empty($bodyArray['PageRange'])) {
            $rawPageRanges = Utilities::getArray($bodyArray['PageRange']);
        }

        $rawClearRanges = [];
        if (!empty($bodyArray['ClearRange'])) {
            $rawClearRanges = Utilities::getArray($bodyArray['ClearRange']);
        }

        $pageRanges = [];

        foreach ($rawPageRanges as $value) {
            $pageRanges[] = new RangeDiff(
                (int) ($value['Start']),
                (int) ($value['End']),
                false,
            );
        }

        foreach ($rawClearRanges as $value) {
            $rawClearRanges[] = new RangeDiff(
                (int) ($value['Start']),
                (int) ($value['End']),
                true,
            );
        }

        // Prepare expected last modified date
        $expectedLastModified = Utilities::rfc1123ToDateTime($headers['Last-Modified']);

        // Test
        $result = ListPageBlobRangesDiffResult::create($headers, $bodyArray);

        //Assert
        self::assertEquals($pageRanges, $result->getRanges());
        self::assertEquals($expectedLastModified, $result->getLastModified());
        self::assertEquals($headers['Etag'], $result->getETag());
        self::assertEquals($headers['x-ms-blob-content-length'], $result->getContentLength());
    }
}

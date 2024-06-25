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

use AzureOSS\Storage\Blob\Models\BlobProperties;
use AzureOSS\Storage\Blob\Models\GetBlobResult;
use AzureOSS\Storage\Tests\Framework\TestResources;
use GuzzleHttp\Psr7;

/**
 * Unit tests for class GetBlobResult
 *
 * @see      https://github.com/azure/azure-storage-php
 */
class GetBlobResultTest extends \PHPUnit\Framework\TestCase
{
    public function testCreate()
    {
        // Setup
        $sample = TestResources::listBlobsOneEntry();
        $expected = $sample['Blobs']['Blob']['Properties'];
        $expectedProperties = BlobProperties::createFromHttpHeaders($expected);
        $expectedMetadata = $sample['Blobs']['Blob']['Metadata'];
        $expectedBody = 'test data';

        // Test
        $actual = GetBlobResult::create(
            $expected,
            Psr7\Utils::streamFor($expectedBody),
            $expectedMetadata,
        );

        // Assert
        self::assertEquals($expectedProperties, $actual->getProperties());
        self::assertEquals($expectedMetadata, $actual->getMetadata());
        $actualContent = stream_get_contents($actual->getContentStream());
        self::assertEquals($expectedBody, $actualContent);
    }
}

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

use AzureOSS\Storage\Blob\Models\ListContainersResult;
use AzureOSS\Storage\Common\Internal\Utilities;
use AzureOSS\Storage\Tests\Framework\TestResources;

/**
 * Unit tests for class ListContainersResult
 *
 * @see      https://github.com/azure/azure-storage-php
 */
class ListContainersResultTest extends \PHPUnit\Framework\TestCase
{
    public function testCreateWithEmpty()
    {
        // Setup
        $sample = TestResources::listContainersEmpty();

        // Test
        $actual = ListContainersResult::create($sample);

        // Assert
        self::assertCount(0, $actual->getContainers());
    }

    public function testCreateWithOneEntry()
    {
        // Setup
        $sample = TestResources::listContainersOneEntry();

        // Test
        $actual = ListContainersResult::create($sample);

        // Assert
        $containers = $actual->getContainers();
        self::assertCount(1, $containers);
        self::assertEquals($sample['Containers']['Container']['Name'], $containers[0]->getName());
        self::assertEquals(
            $sample['@attributes']['ServiceEndpoint'] .
                $sample['Containers']['Container']['Name'],
            $containers[0]->getUrl(),
        );
        self::assertEquals(
            Utilities::rfc1123ToDateTime(
                $sample['Containers']['Container']['Properties']['Last-Modified'],
            ),
            $containers[0]->getProperties()->getLastModified(),
        );
        self::assertEquals(
            $sample['Containers']['Container']['Properties']['Etag'],
            $containers[0]->getProperties()->getETag(),
        );
        self::assertEquals($sample['Marker'], $actual->getMarker());
        self::assertEquals($sample['MaxResults'], $actual->getMaxResults());
        self::assertEquals($sample['NextMarker'], $actual->getNextMarker());
    }

    public function testCreateWithMultipleEntries()
    {
        // Setup
        $sample = TestResources::listContainersMultipleEntries();

        // Test
        $actual = ListContainersResult::create($sample);

        // Assert
        $containers = $actual->getContainers();
        self::assertCount(2, $containers);
        self::assertEquals($sample['Containers']['Container'][0]['Name'], $containers[0]->getName());
        self::assertEquals(
            $sample['@attributes']['ServiceEndpoint'] .
            $sample['Containers']['Container'][0]['Name'],
            $containers[0]->getUrl(),
        );
        self::assertEquals(
            Utilities::rfc1123ToDateTime($sample['Containers']['Container'][0]['Properties']['Last-Modified']),
            $containers[0]->getProperties()->getLastModified(),
        );
        self::assertEquals(
            $sample['Containers']['Container'][0]['Properties']['Etag'],
            $containers[0]->getProperties()->getETag(),
        );
        self::assertEquals(
            $sample['Containers']['Container'][1]['Name'],
            $containers[1]->getName(),
        );
        self::assertEquals(
            $sample['@attributes']['ServiceEndpoint'] .
            $sample['Containers']['Container'][1]['Name'],
            $containers[1]->getUrl(),
        );
        self::assertEquals(
            Utilities::rfc1123ToDateTime($sample['Containers']['Container'][1]['Properties']['Last-Modified']),
            $containers[1]->getProperties()->getLastModified(),
        );
        self::assertEquals(
            $sample['Containers']['Container'][1]['Properties']['Etag'],
            $containers[1]->getProperties()->getETag(),
        );
        self::assertEquals($sample['MaxResults'], $actual->getMaxResults());
        self::assertEquals($sample['NextMarker'], $actual->getNextMarker());
        self::assertEquals($sample['Prefix'], $actual->getPrefix());
        self::assertEquals($sample['account'], $actual->getAccountName());

        return $actual;
    }
}

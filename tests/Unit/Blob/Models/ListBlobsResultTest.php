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
 * @link      https://github.com/azure/azure-storage-php
 */

namespace MicrosoftAzure\Storage\Tests\Unit\Blob\Models;

use MicrosoftAzure\Storage\Blob\Models\ListBlobsResult;
use MicrosoftAzure\Storage\Tests\Framework\TestResources;

/**
 * Unit tests for class ListBlobsResult
 *
 * @link      https://github.com/azure/azure-storage-php
 */
class ListBlobsResultTest extends \PHPUnit\Framework\TestCase
{
    public function testCreateWithEmpty()
    {
        // Setup
        $sample = TestResources::listBlobsEmpty();

        // Test
        $actual = ListBlobsResult::create($sample);

        // Assert
        self::assertCount(0, $actual->getBlobs());
        self::assertCount(0, $actual->getBlobPrefixes());
        self::assertEquals(0, $actual->getMaxResults());
    }

    public function testCreateWithOneEntry()
    {
        // Setup
        $sample = TestResources::listBlobsOneEntry();

        // Test
        $actual = ListBlobsResult::create($sample);

        // Assert
        self::assertCount(1, $actual->getBlobs());
        self::assertEquals($sample['@attributes']['ContainerName'], $actual->getContainerName());
        self::assertCount(1, $actual->getBlobPrefixes());
        self::assertEquals($sample['Marker'], $actual->getMarker());
        self::assertEquals((int) ($sample['MaxResults']), $actual->getMaxResults());
        self::assertEquals($sample['NextMarker'], $actual->getNextMarker());
        self::assertEquals($sample['Delimiter'], $actual->getDelimiter());
        self::assertEquals($sample['Prefix'], $actual->getPrefix());
    }

    public function testCreateWithMultipleEntries()
    {
        // Setup
        $sample = TestResources::listBlobsMultipleEntries();

        // Test
        $actual = ListBlobsResult::create($sample);

        // Assert
        self::assertCount(2, $actual->getBlobs());
        self::assertCount(2, $actual->getBlobPrefixes());
        self::assertEquals($sample['@attributes']['ContainerName'], $actual->getContainerName());
        self::assertEquals($sample['Marker'], $actual->getMarker());
        self::assertEquals((int) ($sample['MaxResults']), $actual->getMaxResults());
        self::assertEquals($sample['NextMarker'], $actual->getNextMarker());

        return $actual;
    }

    public function testCreateWithIsSecondary()
    {
        // Setup
        $sample = TestResources::listBlobsOneEntry();

        // Test
        $actual = ListBlobsResult::create($sample, 'SecondaryOnly');

        // Assert
        self::assertCount(1, $actual->getBlobs());
        self::assertEquals($sample['@attributes']['ContainerName'], $actual->getContainerName());
        self::assertCount(1, $actual->getBlobPrefixes());
        self::assertEquals($sample['Marker'], $actual->getMarker());
        self::assertEquals((int) ($sample['MaxResults']), $actual->getMaxResults());
        self::assertEquals($sample['NextMarker'], $actual->getNextMarker());
        self::assertEquals($sample['Delimiter'], $actual->getDelimiter());
        self::assertEquals($sample['Prefix'], $actual->getPrefix());
        self::assertEquals('SecondaryOnly', $actual->getLocation());
    }
}

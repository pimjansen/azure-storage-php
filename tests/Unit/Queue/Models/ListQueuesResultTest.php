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

namespace MicrosoftAzure\Storage\Tests\Unit\Queue\Models;

use MicrosoftAzure\Storage\Queue\Models\ListQueuesResult;
use MicrosoftAzure\Storage\Tests\Framework\TestResources;

/**
 * Unit tests for class ListQueuesResult
 *
 * @see      https://github.com/azure/azure-storage-php
 */
class ListQueuesResultTest extends \PHPUnit\Framework\TestCase
{
    public function testCreateWithEmpty()
    {
        // Setup
        $sample = TestResources::listQueuesEmpty();

        // Test
        $actual = ListQueuesResult::create($sample);

        // Assert
        self::assertCount(0, $actual->getQueues());
        self::assertEmpty($sample['NextMarker']);
    }

    public function testCreateWithOneEntry()
    {
        // Setup
        $sample = TestResources::listQueuesOneEntry();

        // Test
        $actual = ListQueuesResult::create($sample);

        // Assert
        $queues = $actual->getQueues();
        self::assertCount(1, $queues);
        self::assertEquals($sample['Queues']['Queue']['Name'], $queues[0]->getName());
        self::assertEquals($sample['@attributes']['ServiceEndpoint'] . $sample['Queues']['Queue']['Name'], $queues[0]->getUrl());
        self::assertEquals($sample['Marker'], $actual->getMarker());
        self::assertEquals($sample['MaxResults'], $actual->getMaxResults());
        self::assertEquals($sample['NextMarker'], $actual->getNextMarker());
    }

    public function testCreateWithMultipleEntries()
    {
        // Setup
        $sample = TestResources::listQueuesMultipleEntries();

        // Test
        $actual = ListQueuesResult::create($sample);

        // Assert
        $queues = $actual->getQueues();
        self::assertCount(2, $queues);
        self::assertEquals($sample['Queues']['Queue'][0]['Name'], $queues[0]->getName());
        self::assertEquals($sample['@attributes']['ServiceEndpoint'] . $sample['Queues']['Queue'][0]['Name'], $queues[0]->getUrl());
        self::assertEquals($sample['Queues']['Queue'][1]['Name'], $queues[1]->getName());
        self::assertEquals($sample['@attributes']['ServiceEndpoint'] . $sample['Queues']['Queue'][1]['Name'], $queues[1]->getUrl());
        self::assertEquals($sample['MaxResults'], $actual->getMaxResults());
        self::assertEquals($sample['NextMarker'], $actual->getNextMarker());
        self::assertEquals($sample['Account'], $actual->getAccountName());
        self::assertEquals($sample['Prefix'], $actual->getPrefix());

        return $actual;
    }
}

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

namespace MicrosoftAzure\Storage\Tests\Unit\Queue\Models;

use MicrosoftAzure\Storage\Common\Internal\Utilities;
use MicrosoftAzure\Storage\Queue\Models\PeekMessagesResult;
use MicrosoftAzure\Storage\Tests\Framework\TestResources;

/**
 * Unit tests for class PeekMessagesResult
 *
 * @link      https://github.com/azure/azure-storage-php
 */
class PeekMessagesResultTest extends \PHPUnit\Framework\TestCase
{
    public function testCreate()
    {
        // Setup
        $sample = TestResources::listMessagesSample();

        // Test
        $result = PeekMessagesResult::create($sample);

        // Assert
        $actual = $result->getQueueMessages();
        self::assertCount(1, $actual);
        self::assertEquals(
            $sample['QueueMessage']['MessageId'],
            $actual[0]->getMessageId()
        );
        self::assertEquals(
            Utilities::rfc1123ToDateTime(
                $sample['QueueMessage']['InsertionTime']
            ),
            $actual[0]->getInsertionDate()
        );
        self::assertEquals(
            Utilities::rfc1123ToDateTime(
                $sample['QueueMessage']['ExpirationTime']
            ),
            $actual[0]->getExpirationDate()
        );
        self::assertEquals(
            (int) ($sample['QueueMessage']['DequeueCount']),
            $actual[0]->getDequeueCount()
        );
        self::assertEquals(
            $sample['QueueMessage']['MessageText'],
            $actual[0]->getMessageText()
        );
    }

    public function testCreateMultiple()
    {
        // Setup
        $sample = TestResources::listMessagesMultipleMessagesSample();

        // Test
        $result = PeekMessagesResult::create($sample);

        // Assert
        $actual = $result->getQueueMessages();
        self::assertCount(2, $actual);
        self::assertEquals($sample['QueueMessage'][0]['MessageId'], $actual[0]->getMessageId());
        self::assertEquals(Utilities::rfc1123ToDateTime($sample['QueueMessage'][0]['InsertionTime']), $actual[0]->getInsertionDate());
        self::assertEquals(Utilities::rfc1123ToDateTime($sample['QueueMessage'][0]['ExpirationTime']), $actual[0]->getExpirationDate());
        self::assertEquals((int) ($sample['QueueMessage'][0]['DequeueCount']), $actual[0]->getDequeueCount());
        self::assertEquals($sample['QueueMessage'][0]['MessageText'], $actual[0]->getMessageText());

        self::assertEquals($sample['QueueMessage'][1]['MessageId'], $actual[1]->getMessageId());
        self::assertEquals(Utilities::rfc1123ToDateTime($sample['QueueMessage'][1]['InsertionTime']), $actual[1]->getInsertionDate());
        self::assertEquals(Utilities::rfc1123ToDateTime($sample['QueueMessage'][1]['ExpirationTime']), $actual[1]->getExpirationDate());
        self::assertEquals((int) ($sample['QueueMessage'][1]['DequeueCount']), $actual[1]->getDequeueCount());
        self::assertEquals($sample['QueueMessage'][1]['MessageText'], $actual[1]->getMessageText());
    }
}

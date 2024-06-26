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

namespace AzureOSS\Storage\Tests\unit\Queue\Models;

use AzureOSS\Storage\Common\Internal\Utilities;
use AzureOSS\Storage\Queue\Models\CreateMessageResult;
use AzureOSS\Storage\Tests\Framework\TestResources;

/**
 * Unit tests for class CreateMessageResult
 *
 * @see      https://github.com/azure/azure-storage-php
 */
class CreateMessageResultTest extends \PHPUnit\Framework\TestCase
{
    public function testCreate()
    {
        // Setup
        $sample = TestResources::createMessageSample();

        // Test
        $result = CreateMessageResult::create($sample);

        // Assert
        $actual = $result->getQueueMessage();
        self::assertNotNull($actual);
        self::assertEquals(
            $sample['QueueMessage']['MessageId'],
            $actual->getMessageId()
        );
        self::assertEquals(
            Utilities::rfc1123ToDateTime(
                $sample['QueueMessage']['InsertionTime']
            ),
            $actual->getInsertionDate()
        );
        self::assertEquals(
            Utilities::rfc1123ToDateTime(
                $sample['QueueMessage']['ExpirationTime']
            ),
            $actual->getExpirationDate()
        );
        self::assertEquals(
            $sample['QueueMessage']['PopReceipt'],
            $actual->getPopReceipt()
        );
        self::assertEquals(
            Utilities::rfc1123ToDateTime(
                $sample['QueueMessage']['TimeNextVisible']
            ),
            $actual->getTimeNextVisible()
        );
    }
}

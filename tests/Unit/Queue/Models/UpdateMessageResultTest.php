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

use MicrosoftAzure\Storage\Common\Internal\Utilities;
use MicrosoftAzure\Storage\Queue\Internal\QueueResources;
use MicrosoftAzure\Storage\Queue\Models\UpdateMessageResult;
use MicrosoftAzure\Storage\Tests\Framework\TestResources;

/**
 * Unit tests for class UpdateMessageResult
 *
 * @see      https://github.com/azure/azure-storage-php
 */
class UpdateMessageResultTest extends \PHPUnit\Framework\TestCase
{
    public function testCreate()
    {
        // Setup
        $sample = TestResources::getUpdateMessageResultSampleHeaders();
        $expectedDate = Utilities::rfc1123ToDateTime(
            $sample[QueueResources::X_MS_TIME_NEXT_VISIBLE]
        );

        // Test
        $result = UpdateMessageResult::create($sample);

        // Assert
        self::assertEquals(
            $sample[QueueResources::X_MS_POPRECEIPT],
            $result->getPopReceipt()
        );
        self::assertEquals($expectedDate, $result->getTimeNextVisible());
    }
}

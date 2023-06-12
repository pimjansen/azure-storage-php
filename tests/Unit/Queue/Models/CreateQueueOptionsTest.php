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

use MicrosoftAzure\Storage\Queue\Models\CreateQueueOptions;

/**
 * Unit tests for class CreateQueueOptions
 *
 * @see      https://github.com/azure/azure-storage-php
 */
class CreateQueueOptionsTest extends \PHPUnit\Framework\TestCase
{
    public function testSetMetadata()
    {
        // Setup
        $queue = new CreateQueueOptions();
        $expected = ['key1' => 'value1', 'key2' => 'value2'];

        // Test
        $queue->setMetadata($expected);

        // Assert
        self::assertEquals($expected, $queue->getMetadata());
    }

    public function testGetMetadata()
    {
        // Setup
        $queue = new CreateQueueOptions();
        $expected = ['key1' => 'value1', 'key2' => 'value2'];
        $queue->setMetadata($expected);

        // Test
        $actual = $queue->getMetadata();

        // Assert
        self::assertEquals($expected, $actual);
    }

    public function testAddMetadata()
    {
        // Setup
        $queue = new CreateQueueOptions();
        $key = 'key1';
        $value = 'value1';
        $expected = [$key => $value];

        // Test
        $queue->addMetadata($key, $value);

        // Assert
        self::assertEquals($expected, $queue->getMetadata());
    }
}

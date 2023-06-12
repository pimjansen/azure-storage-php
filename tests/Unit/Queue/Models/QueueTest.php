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

use MicrosoftAzure\Storage\Queue\Models\Queue;
use MicrosoftAzure\Storage\Tests\Framework\TestResources;

/**
 * Unit tests for class Queue
 *
 * @see      https://github.com/azure/azure-storage-php
 */
class QueueTest extends \PHPUnit\Framework\TestCase
{
    public function testConstruct()
    {
        // Setup
        $expectedName = TestResources::QUEUE1_NAME;
        $expectedUrl = TestResources::QUEUE_URI;

        // Test
        $queue = new Queue($expectedName, $expectedUrl);

        // Assert
        self::assertEquals($expectedName, $queue->getName());
        self::assertEquals($expectedUrl, $queue->getUrl());
    }

    public function testSetName()
    {
        // Setup
        $queue = new Queue('myqueue', 'myurl');
        $expected = TestResources::QUEUE1_NAME;

        // Test
        $queue->setName($expected);

        // Assert
        self::assertEquals($expected, $queue->getName());
    }

    public function testGetName()
    {
        // Setup
        $queue = new Queue('myqueue', 'myurl');
        $expected = TestResources::QUEUE1_NAME;
        $queue->setName($expected);

        // Test
        $actual = $queue->getName();

        // Assert
        self::assertEquals($expected, $actual);
    }

    public function testSetUrl()
    {
        // Setup
        $queue = new Queue('myqueue', 'myurl');
        $expected = TestResources::QUEUE1_NAME;

        // Test
        $queue->setUrl($expected);

        // Assert
        self::assertEquals($expected, $queue->getUrl());
    }

    public function testGetUrl()
    {
        // Setup
        $queue = new Queue('myqueue', 'myurl');
        $expected = TestResources::QUEUE_URI;
        $queue->setUrl($expected);

        // Test
        $actual = $queue->getUrl();

        // Assert
        self::assertEquals($expected, $actual);
    }

    public function testSetMetadata()
    {
        // Setup
        $queue = new Queue('myqueue', 'myurl');
        $expected = ['key1' => 'value1', 'key2' => 'value2'];

        // Test
        $queue->setMetadata($expected);

        // Assert
        self::assertEquals($expected, $queue->getMetadata());
    }

    public function testGetMetadata()
    {
        // Setup
        $queue = new Queue('myqueue', 'myurl');
        $expected = ['key1' => 'value1', 'key2' => 'value2'];
        $queue->setMetadata($expected);

        // Test
        $actual = $queue->getMetadata();

        // Assert
        self::assertEquals($expected, $actual);
    }
}

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

namespace MicrosoftAzure\Storage\Tests\Unit\Blob\Models;

use MicrosoftAzure\Storage\Blob\Models\Blob;
use MicrosoftAzure\Storage\Blob\Models\BlobProperties;
use MicrosoftAzure\Storage\Tests\Framework\TestResources;

/**
 * Unit tests for class Blob
 *
 * @see      https://github.com/azure/azure-storage-php
 */
class BlobTest extends \PHPUnit\Framework\TestCase
{
    public function testSetName()
    {
        // Setup
        $blob = new Blob();
        $expected = TestResources::QUEUE1_NAME;

        // Test
        $blob->setName($expected);

        // Assert
        self::assertEquals($expected, $blob->getName());
    }

    public function testGetName()
    {
        // Setup
        $blob = new Blob();
        $expected = TestResources::QUEUE1_NAME;
        $blob->setName($expected);

        // Test
        $actual = $blob->getName();

        // Assert
        self::assertEquals($expected, $actual);
    }

    public function testSetUrl()
    {
        // Setup
        $blob = new Blob();
        $expected = TestResources::QUEUE1_NAME;

        // Test
        $blob->setUrl($expected);

        // Assert
        self::assertEquals($expected, $blob->getUrl());
    }

    public function testGetUrl()
    {
        // Setup
        $blob = new Blob();
        $expected = TestResources::QUEUE_URI;
        $blob->setUrl($expected);

        // Test
        $actual = $blob->getUrl();

        // Assert
        self::assertEquals($expected, $actual);
    }

    public function testSetSnapshot()
    {
        // Setup
        $blob = new Blob();
        $expected = TestResources::QUEUE1_NAME;

        // Test
        $blob->setSnapshot($expected);

        // Assert
        self::assertEquals($expected, $blob->getSnapshot());
    }

    public function testGetSnapshot()
    {
        // Setup
        $blob = new Blob();
        $expected = TestResources::QUEUE_URI;
        $blob->setSnapshot($expected);

        // Test
        $actual = $blob->getSnapshot();

        // Assert
        self::assertEquals($expected, $actual);
    }

    public function testSetMetadata()
    {
        // Setup
        $blob = new Blob();
        $expected = ['key1' => 'value1', 'key2' => 'value2'];

        // Test
        $blob->setMetadata($expected);

        // Assert
        self::assertEquals($expected, $blob->getMetadata());
    }

    public function testGetMetadata()
    {
        // Setup
        $blob = new Blob();
        $expected = ['key1' => 'value1', 'key2' => 'value2'];
        $blob->setMetadata($expected);

        // Test
        $actual = $blob->getMetadata();

        // Assert
        self::assertEquals($expected, $actual);
    }

    public function testSetProperties()
    {
        // Setup
        $blob = new Blob();
        $expected = new BlobProperties();

        // Test
        $blob->setProperties($expected);

        // Assert
        self::assertEquals($expected, $blob->getProperties());
    }

    public function testGetProperties()
    {
        // Setup
        $blob = new Blob();
        $expected = new BlobProperties();
        $blob->setProperties($expected);

        // Test
        $actual = $blob->getProperties();

        // Assert
        self::assertEquals($expected, $actual);
    }
}

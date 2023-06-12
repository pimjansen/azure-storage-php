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

use MicrosoftAzure\Storage\Blob\Models\Container;
use MicrosoftAzure\Storage\Blob\Models\ContainerProperties;
use MicrosoftAzure\Storage\Common\Internal\Utilities;
use MicrosoftAzure\Storage\Tests\Framework\TestResources;

/**
 * Unit tests for class Container
 *
 * @see      https://github.com/azure/azure-storage-php
 */
class ContainerTest extends \PHPUnit\Framework\TestCase
{
    public function testSetName()
    {
        // Setup
        $container = new Container();
        $expected = TestResources::QUEUE1_NAME;

        // Test
        $container->setName($expected);

        // Assert
        self::assertEquals($expected, $container->getName());
    }

    public function testGetName()
    {
        // Setup
        $container = new Container();
        $expected = TestResources::QUEUE1_NAME;
        $container->setName($expected);

        // Test
        $actual = $container->getName();

        // Assert
        self::assertEquals($expected, $actual);
    }

    public function testSetUrl()
    {
        // Setup
        $container = new Container();
        $expected = TestResources::QUEUE1_NAME;

        // Test
        $container->setUrl($expected);

        // Assert
        self::assertEquals($expected, $container->getUrl());
    }

    public function testGetUrl()
    {
        // Setup
        $container = new Container();
        $expected = TestResources::QUEUE_URI;
        $container->setUrl($expected);

        // Test
        $actual = $container->getUrl();

        // Assert
        self::assertEquals($expected, $actual);
    }

    public function testSetMetadata()
    {
        // Setup
        $container = new Container();
        $expected = ['key1' => 'value1', 'key2' => 'value2'];

        // Test
        $container->setMetadata($expected);

        // Assert
        self::assertEquals($expected, $container->getMetadata());
    }

    public function testGetMetadata()
    {
        // Setup
        $container = new Container();
        $expected = ['key1' => 'value1', 'key2' => 'value2'];
        $container->setMetadata($expected);

        // Test
        $actual = $container->getMetadata();

        // Assert
        self::assertEquals($expected, $actual);
    }

    public function testSetProperties()
    {
        // Setup
        $date = Utilities::rfc1123ToDateTime('Wed, 12 Aug 2009 20:39:39 GMT');
        $container = new Container();
        $expected = new ContainerProperties();
        $expected->setETag('0x8CACB9BD7C1EEEC');
        $expected->setLastModified($date);

        // Test
        $container->setProperties($expected);

        // Assert
        self::assertEquals($expected, $container->getProperties());
    }

    public function testGetProperties()
    {
        // Setup
        $date = Utilities::rfc1123ToDateTime('Wed, 12 Aug 2009 20:39:39 GMT');
        $container = new Container();
        $expected = new ContainerProperties();
        $expected->setETag('0x8CACB9BD7C1EEEC');
        $expected->setLastModified($date);
        $container->setProperties($expected);

        // Test
        $actual = $container->getProperties();

        // Assert
        self::assertEquals($expected, $actual);
    }
}

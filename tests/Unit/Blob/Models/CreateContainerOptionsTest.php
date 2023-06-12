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

use MicrosoftAzure\Storage\Blob\Models\CreateContainerOptions;
use MicrosoftAzure\Storage\Common\Exceptions\InvalidArgumentTypeException;

/**
 * Unit tests for class CreateContainerOptions
 *
 * @link      https://github.com/azure/azure-storage-php
 */
class CreateContainerOptionsTest extends \PHPUnit\Framework\TestCase
{
    public function testGetPublicAccess()
    {
        // Setup
        $properties = new CreateContainerOptions();
        $expected = 'blob';
        $properties->setPublicAccess($expected);

        // Test
        $actual = $properties->getPublicAccess();

        // Assert
        self::assertEquals($expected, $actual);
    }

    public function testSetPublicAccess()
    {
        // Setup
        $properties = new CreateContainerOptions();
        $expected = 'container';

        // Test
        $properties->setPublicAccess($expected);

        // Assert
        $actual = $properties->getPublicAccess();
        self::assertEquals($expected, $actual);
    }

    public function testSetPublicAccessInvalidValueFail()
    {
        // Setup
        $properties = new CreateContainerOptions();
        $expected = new \DateTime();
        $this->expectException(get_class(new InvalidArgumentTypeException('')));

        // Test
        $properties->setPublicAccess($expected);
    }

    public function testSetMetadata()
    {
        // Setup
        $container = new CreateContainerOptions();
        $expected = ['key1' => 'value1', 'key2' => 'value2'];

        // Test
        $container->setMetadata($expected);

        // Assert
        self::assertEquals($expected, $container->getMetadata());
    }

    public function testGetMetadata()
    {
        // Setup
        $container = new CreateContainerOptions();
        $expected = ['key1' => 'value1', 'key2' => 'value2'];
        $container->setMetadata($expected);

        // Test
        $actual = $container->getMetadata();

        // Assert
        self::assertEquals($expected, $actual);
    }

    public function testAddMetadata()
    {
        // Setup
        $container = new CreateContainerOptions();
        $key = 'key1';
        $value = 'value1';
        $expected = [$key => $value];

        // Test
        $container->addMetadata($key, $value);

        // Assert
        self::assertEquals($expected, $container->getMetadata());
    }
}

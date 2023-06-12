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

namespace MicrosoftAzure\Storage\Tests\Unit\Table\Models;

use MicrosoftAzure\Storage\Table\Models\EdmType;
use MicrosoftAzure\Storage\Table\Models\Entity;
use MicrosoftAzure\Storage\Table\Models\Property;

/**
 * Unit tests for class Entity
 *
 * @see      https://github.com/azure/azure-storage-php
 */
class EntityTest extends \PHPUnit\Framework\TestCase
{
    public function testGetPropertyValue()
    {
        // Setup
        $entity = new Entity();
        $name = 'name';
        $edmType = EdmType::STRING;
        $value = 'MyName';
        $expected = 'MyNewName';
        $entity->addProperty($name, $edmType, $value);
        $entity->setPropertyValue($name, $expected);

        // Test
        $actual = $entity->getPropertyValue($name);

        // Assert
        self::assertEquals($actual, $expected);
    }

    public function testSetETag()
    {
        // Setup
        $expected = '0x8CAFB82EFF70C46';
        $entity = new Entity();
        $entity->setETag($expected);

        // Test
        $entity->setETag($expected);

        // Assert
        self::assertEquals($expected, $entity->getETag());
    }

    public function testSetPartitionKey()
    {
        // Setup
        $entity = new Entity();
        $expected = '1234';

        // Test
        $entity->setPartitionKey($expected);

        // Assert
        self::assertEquals($expected, $entity->getPartitionKey());
    }

    public function testSetRowKey()
    {
        // Setup
        $entity = new Entity();
        $expected = '1234';

        // Test
        $entity->setRowKey($expected);

        // Assert
        self::assertEquals($expected, $entity->getRowKey());
    }

    public function testSetTimestamp()
    {
        // Setup
        $entity = new Entity();
        $expected = new \DateTime();

        // Test
        $entity->setTimestamp($expected);

        // Assert
        self::assertEquals($expected, $entity->getTimestamp());
    }

    public function testSetProperties()
    {
        // Setup
        $entity = new Entity();
        $expected = ['name' => new Property(EdmType::STRING, null)];

        // Test
        $entity->setProperties($expected);

        // Assert
        self::assertEquals($expected, $entity->getProperties());
    }

    public function testSetProperty()
    {
        // Setup
        $entity = new Entity();
        $expected = new Property();
        $name = 'test';

        // Test
        $entity->setProperty($name, $expected);

        // Assert
        self::assertEquals($expected, $entity->getProperty($name));
    }

    public function testAddProperty()
    {
        // Setup
        $entity = new Entity();
        $name = 'test';
        $expected = new Property();
        $edmType = EdmType::STRING;
        $value = '01231232290234210';
        $expected->setEdmType($edmType);
        $expected->setValue($value);

        // Test
        $entity->addProperty($name, $edmType, $value);

        // Assert
        self::assertEquals($expected, $entity->getProperty($name));
    }

    public function testIsValid()
    {
        // Setup
        $entity = new Entity();
        $entity->setPartitionKey('123');
        $entity->setRowKey('456');

        // Assert
        $actual = $entity->isValid();

        // Assert
        self::assertTrue($actual);
    }

    public function testIsValidWithInvalid()
    {
        // Setup
        $entity = new Entity();

        // Assert
        $actual = $entity->isValid();

        // Assert
        self::assertFalse($actual);
    }

    public function testIsValidWithEmptyPartitionKey()
    {
        // Setup
        $entity = new Entity();
        $entity->addProperty('name', EdmType::STRING, 'string');

        // Assert
        $actual = $entity->isValid();

        // Assert
        self::assertFalse($actual);
    }
}

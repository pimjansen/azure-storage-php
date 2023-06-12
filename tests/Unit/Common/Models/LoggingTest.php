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

namespace MicrosoftAzure\Storage\Tests\Unit\Common\Models;

use MicrosoftAzure\Storage\Common\Internal\Utilities;
use MicrosoftAzure\Storage\Common\Models\Logging;
use MicrosoftAzure\Storage\Common\Models\RetentionPolicy;
use MicrosoftAzure\Storage\Tests\Framework\TestResources;

/**
 * Unit tests for class Logging
 *
 * @see      https://github.com/azure/azure-storage-php
 */
class LoggingTest extends \PHPUnit\Framework\TestCase
{
    public function testCreate()
    {
        // Setup
        $sample = TestResources::getServicePropertiesSample();

        // Test
        $actual = Logging::create($sample['Logging']);

        // Assert
        self::assertEquals(Utilities::toBoolean($sample['Logging']['Delete']), $actual->getDelete());
        self::assertEquals(Utilities::toBoolean($sample['Logging']['Read']), $actual->getRead());
        self::assertEquals(RetentionPolicy::create($sample['Logging']['RetentionPolicy']), $actual->getRetentionPolicy());
        self::assertEquals($sample['Logging']['Version'], $actual->getVersion());
        self::assertEquals(Utilities::toBoolean($sample['Logging']['Write']), $actual->getWrite());
    }

    public function testGetRetentionPolicy()
    {
        // Setup
        $sample = TestResources::getServicePropertiesSample();
        $logging = new Logging();
        $expected = RetentionPolicy::create($sample['Logging']['RetentionPolicy']);
        $logging->setRetentionPolicy($expected);

        // Test
        $actual = $logging->getRetentionPolicy();

        // Assert
        self::assertEquals($expected, $actual);
    }

    public function testSetRetentionPolicy()
    {
        // Setup
        $sample = TestResources::getServicePropertiesSample();
        $logging = new Logging();
        $expected = RetentionPolicy::create($sample['Logging']['RetentionPolicy']);

        // Test
        $logging->setRetentionPolicy($expected);

        // Assert
        $actual = $logging->getRetentionPolicy();
        self::assertEquals($expected, $actual);
    }

    public function testGetWrite()
    {
        // Setup
        $sample = TestResources::getServicePropertiesSample();
        $logging = new Logging();
        $expected = Utilities::toBoolean($sample['Logging']['Write']);
        $logging->setWrite($expected);

        // Test
        $actual = $logging->getWrite();

        // Assert
        self::assertEquals($expected, $actual);
    }

    public function testSetWrite()
    {
        // Setup
        $sample = TestResources::getServicePropertiesSample();
        $logging = new Logging();
        $expected = Utilities::toBoolean($sample['Logging']['Write']);

        // Test
        $logging->setWrite($expected);

        // Assert
        $actual = $logging->getWrite();
        self::assertEquals($expected, $actual);
    }

    public function testGetRead()
    {
        // Setup
        $sample = TestResources::getServicePropertiesSample();
        $logging = new Logging();
        $expected = Utilities::toBoolean($sample['Logging']['Read']);
        $logging->setRead($expected);

        // Test
        $actual = $logging->getRead();

        // Assert
        self::assertEquals($expected, $actual);
    }

    public function testSetRead()
    {
        // Setup
        $sample = TestResources::getServicePropertiesSample();
        $logging = new Logging();
        $expected = Utilities::toBoolean($sample['Logging']['Read']);

        // Test
        $logging->setRead($expected);

        // Assert
        $actual = $logging->getRead();
        self::assertEquals($expected, $actual);
    }

    public function testGetDelete()
    {
        // Setup
        $sample = TestResources::getServicePropertiesSample();
        $logging = new Logging();
        $expected = Utilities::toBoolean($sample['Logging']['Delete']);
        $logging->setDelete($expected);

        // Test
        $actual = $logging->getDelete();

        // Assert
        self::assertEquals($expected, $actual);
    }

    public function testSetDelete()
    {
        // Setup
        $sample = TestResources::getServicePropertiesSample();
        $logging = new Logging();
        $expected = Utilities::toBoolean($sample['Logging']['Delete']);

        // Test
        $logging->setDelete($expected);

        // Assert
        $actual = $logging->getDelete();
        self::assertEquals($expected, $actual);
    }

    public function testGetVersion()
    {
        // Setup
        $sample = TestResources::getServicePropertiesSample();
        $logging = new Logging();
        $expected = $sample['Logging']['Version'];
        $logging->setVersion($expected);

        // Test
        $actual = $logging->getVersion();

        // Assert
        self::assertEquals($expected, $actual);
    }

    public function testSetVersion()
    {
        // Setup
        $sample = TestResources::getServicePropertiesSample();
        $logging = new Logging();
        $expected = $sample['Logging']['Version'];

        // Test
        $logging->setVersion($expected);

        // Assert
        $actual = $logging->getVersion();
        self::assertEquals($expected, $actual);
    }

    public function testToArray()
    {
        // Setup
        $sample = TestResources::getServicePropertiesSample();
        $logging = Logging::create($sample['Logging']);
        $expected = [
            'Version' => $sample['Logging']['Version'],
            'Delete' => $sample['Logging']['Delete'],
            'Read' => $sample['Logging']['Read'],
            'Write' => $sample['Logging']['Write'],
            'RetentionPolicy' => $logging->getRetentionPolicy()->toArray()
        ];

        // Test
        $actual = $logging->toArray();

        // Assert
        self::assertEquals($expected, $actual);
    }
}

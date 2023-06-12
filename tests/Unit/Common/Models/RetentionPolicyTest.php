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
use MicrosoftAzure\Storage\Common\Models\RetentionPolicy;
use MicrosoftAzure\Storage\Tests\Framework\TestResources;

/**
 * Unit tests for class RetentionPolicy
 *
 * @see      https://github.com/azure/azure-storage-php
 */
class RetentionPolicyTest extends \PHPUnit\Framework\TestCase
{
    public function testCreate()
    {
        // Setup
        $sample = TestResources::getServicePropertiesSample();
        $expectedEnabled = Utilities::toBoolean($sample['Logging']['RetentionPolicy']['Enabled']);
        $expectedDays = (int) ($sample['Logging']['RetentionPolicy']['Days']);

        // Test
        $actual = RetentionPolicy::create($sample['Logging']['RetentionPolicy']);

        // Assert
        self::assertEquals($expectedEnabled, $actual->getEnabled());
        self::assertEquals($expectedDays, $actual->getDays());
    }

    public function testGetEnabled()
    {
        // Setup
        $sample = TestResources::getServicePropertiesSample();
        $retentionPolicy = new RetentionPolicy();
        $expected = Utilities::toBoolean($sample['Logging']['RetentionPolicy']['Enabled']);
        $retentionPolicy->setEnabled($expected);

        // Test
        $actual = $retentionPolicy->getEnabled();

        // Assert
        self::assertEquals($expected, $actual);
    }

    public function testSetEnabled()
    {
        // Setup
        $sample = TestResources::getServicePropertiesSample();
        $retentionPolicy = new RetentionPolicy();
        $expected = Utilities::toBoolean($sample['Logging']['RetentionPolicy']['Enabled']);

        // Test
        $retentionPolicy->setEnabled($expected);

        // Assert
        $actual = $retentionPolicy->getEnabled();
        self::assertEquals($expected, $actual);
    }

    public function testGetDays()
    {
        // Setup
        $sample = TestResources::getServicePropertiesSample();
        $retentionPolicy = new RetentionPolicy();
        $expected = (int) ($sample['Logging']['RetentionPolicy']['Days']);
        $retentionPolicy->setDays($expected);

        // Test
        $actual = $retentionPolicy->getDays();

        // Assert
        self::assertEquals($expected, $actual);
    }

    public function testSetDays()
    {
        // Setup
        $sample = TestResources::getServicePropertiesSample();
        $retentionPolicy = new RetentionPolicy();
        $expected = (int) ($sample['Logging']['RetentionPolicy']['Days']);

        // Test
        $retentionPolicy->setDays($expected);

        // Assert
        $actual = $retentionPolicy->getDays();
        self::assertEquals($expected, $actual);
    }

    public function testToArray()
    {
        // Setup
        $sample = TestResources::getServicePropertiesSample();
        $retentionPolicy = RetentionPolicy::create($sample['Logging']['RetentionPolicy']);
        $expected = [
            'Enabled' => $sample['Logging']['RetentionPolicy']['Enabled'],
            'Days' => $sample['Logging']['RetentionPolicy']['Days']
        ];

        // Test
        $actual = $retentionPolicy->toArray();

        // Assert
        self::assertEquals($expected, $actual);
    }

    public function testToArrayWithoutDays()
    {
        // Setup
        $sample = TestResources::getServicePropertiesSample();
        $retentionPolicy = RetentionPolicy::create($sample['Logging']['RetentionPolicy']);
        $expected = ['Enabled' => $sample['Logging']['RetentionPolicy']['Enabled']];
        $retentionPolicy->setDays(null);

        // Test
        $actual = $retentionPolicy->toArray();

        // Assert
        self::assertEquals($expected, $actual);
    }
}

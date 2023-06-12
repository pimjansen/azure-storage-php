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
use MicrosoftAzure\Storage\Common\Models\Metrics;
use MicrosoftAzure\Storage\Common\Models\RetentionPolicy;
use MicrosoftAzure\Storage\Tests\Framework\TestResources;

/**
 * Unit tests for class Metrics
 *
 * @see      https://github.com/azure/azure-storage-php
 */
class MetricsTest extends \PHPUnit\Framework\TestCase
{
    public function testCreate()
    {
        // Setup
        $sample = TestResources::getServicePropertiesSample();

        // Test
        $actual = Metrics::create($sample['HourMetrics']);

        // Assert
        self::assertEquals(Utilities::toBoolean($sample['HourMetrics']['Enabled']), $actual->getEnabled());
        self::assertEquals(Utilities::toBoolean($sample['HourMetrics']['IncludeAPIs']), $actual->getIncludeAPIs());
        self::assertEquals(RetentionPolicy::create($sample['HourMetrics']['RetentionPolicy']), $actual->getRetentionPolicy());
        self::assertEquals($sample['HourMetrics']['Version'], $actual->getVersion());
    }

    public function testGetRetentionPolicy()
    {
        // Setup
        $sample = TestResources::getServicePropertiesSample();
        $metrics = new Metrics();
        $expected = RetentionPolicy::create($sample['HourMetrics']['RetentionPolicy']);
        $metrics->setRetentionPolicy($expected);

        // Test
        $actual = $metrics->getRetentionPolicy();

        // Assert
        self::assertEquals($expected, $actual);
    }

    public function testSetRetentionPolicy()
    {
        // Setup
        $sample = TestResources::getServicePropertiesSample();
        $metrics = new Metrics();
        $expected = RetentionPolicy::create($sample['HourMetrics']['RetentionPolicy']);

        // Test
        $metrics->setRetentionPolicy($expected);

        // Assert
        $actual = $metrics->getRetentionPolicy();
        self::assertEquals($expected, $actual);
    }

    public function testGetVersion()
    {
        // Setup
        $sample = TestResources::getServicePropertiesSample();
        $metrics = new Metrics();
        $expected = $sample['HourMetrics']['Version'];
        $metrics->setVersion($expected);

        // Test
        $actual = $metrics->getVersion();

        // Assert
        self::assertEquals($expected, $actual);
    }

    public function testSetVersion()
    {
        // Setup
        $sample = TestResources::getServicePropertiesSample();
        $metrics = new Metrics();
        $expected = $sample['HourMetrics']['Version'];

        // Test
        $metrics->setVersion($expected);

        // Assert
        $actual = $metrics->getVersion();
        self::assertEquals($expected, $actual);
    }

    public function testGetEnabled()
    {
        // Setup
        $sample = TestResources::getServicePropertiesSample();
        $metrics = new Metrics();
        $expected = Utilities::toBoolean($sample['HourMetrics']['Enabled']);
        $metrics->setEnabled($expected);

        // Test
        $actual = $metrics->getEnabled();

        // Assert
        self::assertEquals($expected, $actual);
    }

    public function testSetEnabled()
    {
        // Setup
        $sample = TestResources::getServicePropertiesSample();
        $metrics = new Metrics();
        $expected = Utilities::toBoolean($sample['HourMetrics']['Enabled']);

        // Test
        $metrics->setEnabled($expected);

        // Assert
        $actual = $metrics->getEnabled();
        self::assertEquals($expected, $actual);
    }

    public function testGetIncludeAPIs()
    {
        // Setup
        $sample = TestResources::getServicePropertiesSample();
        $metrics = new Metrics();
        $expected = Utilities::toBoolean($sample['HourMetrics']['IncludeAPIs']);
        $metrics->setIncludeAPIs($expected);

        // Test
        $actual = $metrics->getIncludeAPIs();

        // Assert
        self::assertEquals($expected, $actual);
    }

    public function testSetIncludeAPIs()
    {
        // Setup
        $sample = TestResources::getServicePropertiesSample();
        $metrics = new Metrics();
        $expected = Utilities::toBoolean($sample['HourMetrics']['IncludeAPIs']);

        // Test
        $metrics->setIncludeAPIs($expected);

        // Assert
        $actual = $metrics->getIncludeAPIs();
        self::assertEquals($expected, $actual);
    }

    public function testToArray()
    {
        // Setup
        $sample = TestResources::getServicePropertiesSample();
        $metrics = Metrics::create($sample['HourMetrics']);
        $expected = [
            'Version' => $sample['HourMetrics']['Version'],
            'Enabled' => $sample['HourMetrics']['Enabled'],
            'IncludeAPIs' => $sample['HourMetrics']['IncludeAPIs'],
            'RetentionPolicy' => $metrics->getRetentionPolicy()->toArray(),
        ];

        // Test
        $actual = $metrics->toArray();

        // Assert
        self::assertEquals($expected, $actual);
    }

    public function testToArrayWithNotEnabled()
    {
        // Setup
        $sample = TestResources::getServicePropertiesSample();
        $sample['HourMetrics']['Enabled'] = 'false';
        $metrics = Metrics::create($sample['HourMetrics']);
        $expected = [
            'Version' => $sample['HourMetrics']['Version'],
            'Enabled' => $sample['HourMetrics']['Enabled'],
            'RetentionPolicy' => $metrics->getRetentionPolicy()->toArray(),
        ];

        // Test
        $actual = $metrics->toArray();

        // Assert
        self::assertEquals($expected, $actual);
    }
}

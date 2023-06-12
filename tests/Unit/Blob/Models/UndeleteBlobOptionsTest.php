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

use MicrosoftAzure\Storage\Blob\Models\AccessCondition;
use MicrosoftAzure\Storage\Blob\Models\UndeleteBlobOptions;

/**
 * Unit tests for class UndeleteBlobOptions
 *
 * @see      https://github.com/azure/azure-storage-php
 */
class UndeleteBlobOptionsTest extends \PHPUnit\Framework\TestCase
{
    public function testSetLeaseId()
    {
        // Setup
        $expected = '0x8CAFB82EFF70C46';
        $options = new UndeleteBlobOptions();
        $options->setLeaseId($expected);

        // Test
        $options->setLeaseId($expected);

        // Assert
        self::assertEquals($expected, $options->getLeaseId());
    }

    public function testGetAccessConditions()
    {
        // Setup
        $expected = AccessCondition::none();
        $result = new UndeleteBlobOptions();
        $result->setAccessConditions($expected);

        // Test
        $actual = $result->getAccessConditions();

        // Assert
        self::assertEquals($expected, $actual[0]);
    }

    public function testSetAccessConditions()
    {
        // Setup
        $expected = AccessCondition::none();
        $result = new UndeleteBlobOptions();

        // Test
        $result->setAccessConditions($expected);

        // Assert
        self::assertEquals($expected, $result->getAccessConditions()[0]);
    }
}

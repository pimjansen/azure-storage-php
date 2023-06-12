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
use MicrosoftAzure\Storage\Blob\Models\CreateBlobPagesOptions;

/**
 * Unit tests for class CreateBlobPagesOptions
 *
 * @see      https://github.com/azure/azure-storage-php
 */
class CreateBlobPagesOptionsTest extends \PHPUnit\Framework\TestCase
{
    public function testGetAccessConditions()
    {
        // Setup
        $expected = AccessCondition::none();
        $options = new CreateBlobPagesOptions();
        $options->setAccessConditions($expected);

        // Test
        $actual = $options->getAccessConditions();

        // Assert
        self::assertEquals($expected, $actual[0]);
    }

    public function testSetAccessConditions()
    {
        // Setup
        $expected = AccessCondition::none();
        $options = new CreateBlobPagesOptions();

        // Test
        $options->setAccessConditions($expected);

        // Assert
        self::assertEquals($expected, $options->getAccessConditions()[0]);
    }

    public function testSetContentMD5()
    {
        // Setup
        $expected = '0x8CAFB82EFF70C46';
        $options = new CreateBlobPagesOptions();
        $options->setContentMD5($expected);

        // Test
        $options->setContentMD5($expected);

        // Assert
        self::assertEquals($expected, $options->getContentMD5());
    }

    public function testSetLeaseId()
    {
        // Setup
        $expected = '0x8CAFB82EFF70C46';
        $options = new CreateBlobPagesOptions();
        $options->setLeaseId($expected);

        // Test
        $options->setLeaseId($expected);

        // Assert
        self::assertEquals($expected, $options->getLeaseId());
    }
}

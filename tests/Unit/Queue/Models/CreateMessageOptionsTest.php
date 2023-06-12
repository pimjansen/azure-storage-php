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

namespace MicrosoftAzure\Storage\Tests\Unit\Queue\Models;

use MicrosoftAzure\Storage\Queue\Models\CreateMessageOptions;

/**
 * Unit tests for class CreateMessageOptions
 *
 * @link      https://github.com/azure/azure-storage-php
 */
class CreateMessageOptionsTest extends \PHPUnit\Framework\TestCase
{
    public function testGetVisibilityTimeoutInSeconds()
    {
        // Setup
        $createMessageOptions = new CreateMessageOptions();
        $expected = 1000;
        $createMessageOptions->setVisibilityTimeoutInSeconds($expected);

        // Test
        $actual = $createMessageOptions->getVisibilityTimeoutInSeconds();

        // Assert
        self::assertEquals($expected, $actual);
    }

    public function testSetVisibilityTimeoutInSeconds()
    {
        // Setup
        $createMessageOptions = new CreateMessageOptions();
        $expected = 1000;

        // Test
        $createMessageOptions->setVisibilityTimeoutInSeconds($expected);

        // Assert
        $actual = $createMessageOptions->getVisibilityTimeoutInSeconds();
        self::assertEquals($expected, $actual);
    }

    public function testGetTimeToLiveInSeconds()
    {
        // Setup
        $createMessageOptions = new CreateMessageOptions();
        $expected = 20;
        $createMessageOptions->setTimeToLiveInSeconds($expected);

        // Test
        $actual = $createMessageOptions->getTimeToLiveInSeconds();

        // Assert
        self::assertEquals($expected, $actual);
    }

    public function testSetTimeToLiveInSeconds()
    {
        // Setup
        $createMessageOptions = new CreateMessageOptions();
        $expected = 20;

        // Test
        $createMessageOptions->setTimeToLiveInSeconds($expected);

        // Assert
        $actual = $createMessageOptions->getTimeToLiveInSeconds();
        self::assertEquals($expected, $actual);
    }
}

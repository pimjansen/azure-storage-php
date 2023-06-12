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

namespace MicrosoftAzure\Storage\Tests\Unit\Queue\Models;

use MicrosoftAzure\Storage\Queue\Models\ListMessagesOptions;

/**
 * Unit tests for class ListMessagesOptions
 *
 * @see      https://github.com/azure/azure-storage-php
 */
class ListMessagesOptionsTest extends \PHPUnit\Framework\TestCase
{
    public function testGetVisibilityTimeoutInSeconds()
    {
        // Setup
        $listMessagesOptions = new ListMessagesOptions();
        $expected = 1000;
        $listMessagesOptions->setVisibilityTimeoutInSeconds($expected);

        // Test
        $actual = $listMessagesOptions->getVisibilityTimeoutInSeconds();

        // Assert
        self::assertEquals($expected, $actual);
    }

    public function testSetVisibilityTimeoutInSeconds()
    {
        // Setup
        $listMessagesOptions = new ListMessagesOptions();
        $expected = 1000;

        // Test
        $listMessagesOptions->setVisibilityTimeoutInSeconds($expected);

        // Assert
        $actual = $listMessagesOptions->getVisibilityTimeoutInSeconds();
        self::assertEquals($expected, $actual);
    }

    public function testGetNumberOfMessages()
    {
        // Setup
        $listMessagesOptions = new ListMessagesOptions();
        $expected = 10;
        $listMessagesOptions->setNumberOfMessages($expected);

        // Test
        $actual = $listMessagesOptions->getNumberOfMessages();

        // Assert
        self::assertEquals($expected, $actual);
    }

    public function testSetNumberOfMessages()
    {
        // Setup
        $listMessagesOptions = new ListMessagesOptions();
        $expected = 10;

        // Test
        $listMessagesOptions->setNumberOfMessages($expected);

        // Assert
        $actual = $listMessagesOptions->getNumberOfMessages();
        self::assertEquals($expected, $actual);
    }
}

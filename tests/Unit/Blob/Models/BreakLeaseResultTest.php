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

use MicrosoftAzure\Storage\Blob\Models\BreakLeaseResult;

/**
 * Unit tests for class BreakLeaseResult
 *
 * @see      https://github.com/azure/azure-storage-php
 */
class BreakLeaseResultTest extends \PHPUnit\Framework\TestCase
{
    public function testCreate()
    {
        // Setup
        $expected = '10';
        $headers = ['x-ms-lease-time' => $expected];

        // Test
        $result = BreakLeaseResult::create($headers);

        // Assert
        self::assertEquals($expected, $result->getLeaseTime());
    }
}

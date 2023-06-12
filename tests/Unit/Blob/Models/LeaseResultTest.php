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

use MicrosoftAzure\Storage\Blob\Models\LeaseResult;

/**
 * Unit tests for class LeaseResult
 *
 * @see      https://github.com/azure/azure-storage-php
 */
class LeaseResultTest extends \PHPUnit\Framework\TestCase
{
    public function testCreate()
    {
        // Setup
        $expected = '0x8CAFB82EFF70C46';
        $headers = ['x-ms-lease-id' => $expected];

        // Test
        $result = LeaseResult::create($headers);

        // Assert
        self::assertEquals($expected, $result->getLeaseId());
    }
}

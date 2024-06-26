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

namespace AzureOSS\Storage\Tests\Unit\Common\Models;

use AzureOSS\Storage\Common\Internal\Resources;
use AzureOSS\Storage\Common\Internal\Utilities;
use AzureOSS\Storage\Common\Models\GetServiceStatsResult;
use AzureOSS\Storage\Tests\Framework\TestResources;

/**
 * Unit tests for class GetServiceStatsResult
 *
 * @see      https://github.com/azure/azure-storage-php
 */
class GetServiceStatsResultTest extends \PHPUnit\Framework\TestCase
{
    public function testCreate()
    {
        $sample = TestResources::getServiceStatsSample();
        $geo = $sample[Resources::XTAG_GEO_REPLICATION];
        $expectedStatus = $geo[Resources::XTAG_STATUS];
        $expectedSyncTime = Utilities::convertToDateTime($geo[Resources::XTAG_LAST_SYNC_TIME]);
        // Test
        $result = GetServiceStatsResult::create($sample);

        // Assert
        self::assertEquals($expectedSyncTime, $result->getLastSyncTime());
        self::assertEquals($expectedStatus, $result->getStatus());
    }
}

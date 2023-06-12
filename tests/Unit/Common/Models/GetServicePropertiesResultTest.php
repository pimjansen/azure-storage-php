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

use MicrosoftAzure\Storage\Common\Models\GetServicePropertiesResult;
use MicrosoftAzure\Storage\Common\Models\ServiceProperties;
use MicrosoftAzure\Storage\Tests\Framework\TestResources;

/**
 * Unit tests for class GetServicePropertiesResult
 *
 * @see      https://github.com/azure/azure-storage-php
 */
class GetServicePropertiesResultTest extends \PHPUnit\Framework\TestCase
{
    public function testCreate()
    {
        // Test
        $result = GetServicePropertiesResult::create(TestResources::getServicePropertiesSample());
        $expected = ServiceProperties::create(TestResources::getServicePropertiesSample());

        // Assert
        self::assertTrue(isset($result));
        self::assertEquals($expected, $result->getValue());
    }
}

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

namespace MicrosoftAzure\Storage\Tests\Unit\Table\Models;

use MicrosoftAzure\Storage\Table\Internal\JsonODataReaderWriter;
use MicrosoftAzure\Storage\Table\Models\GetTableResult;
use MicrosoftAzure\Storage\Tests\Framework\TestResources;

/**
 * Unit tests for class GetTableResult
 *
 * @link      https://github.com/azure/azure-storage-php
 */
class GetTableResultTest extends \PHPUnit\Framework\TestCase
{
    public function testCreate()
    {
        // Setup
        $sampleBody = TestResources::getTableSampleBody();
        $serializer = new JsonODataReaderWriter();

        // Test
        $result = GetTableResult::create($sampleBody, $serializer);

        // Assert
        self::assertEquals($serializer->parseTable($sampleBody), $result->getName());
    }
}

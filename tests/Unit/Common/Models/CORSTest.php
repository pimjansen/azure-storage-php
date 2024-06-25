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

use AzureOSS\Storage\Common\Models\CORS;
use AzureOSS\Storage\Tests\Framework\TestResources;

/**
 * Unit tests for class CORS
 *
 * @see      https://github.com/azure/azure-storage-php
 */
class CORSTest extends \PHPUnit\Framework\TestCase
{
    public function testCreateAndToArray()
    {
        $parsedResponse = TestResources::getCORSSingle();

        $cors = CORS::create($parsedResponse);

        self::assertEquals($parsedResponse, $cors->toArray());
    }

    public function testCreateNegative()
    {
        $this->expectException(\UnexpectedValueException::class);
        $this->expectExceptionMessage('does not exist in the given array');

        $parsedResponse = [];

        $cors = CORS::create($parsedResponse);
    }

    public function testToArray()
    {
        $parsedResponse = TestResources::getCORSSingle();

        $cors = new CORS(
            ['http://www.microsoft.com', 'http://www.bing.com'],
            ['GET', 'PUT'],
            ['x-ms-meta-customheader0', 'x-ms-meta-target0*'],
            ['x-ms-meta-customheader0', 'x-ms-meta-data0*'],
            500,
        );

        self::assertEquals($parsedResponse, $cors->toArray());
    }
}

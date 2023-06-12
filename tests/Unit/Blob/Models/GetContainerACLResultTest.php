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

namespace MicrosoftAzure\Storage\Tests\Unit\Blob\Models;

use MicrosoftAzure\Storage\Blob\Models\ContainerACL;
use MicrosoftAzure\Storage\Blob\Models\GetContainerACLResult;

/**
 * Unit tests for class GetContainerACLResult
 *
 * @link      https://github.com/azure/azure-storage-php
 */
class GetContainerACLResultTest extends \PHPUnit\Framework\TestCase
{
    public function testCreate()
    {
        // Setup
        $sample = [];
        $expectedETag = '0x8CAFB82EFF70C46';
        $expectedDate = new \DateTime('Sun, 25 Sep 2011 19:42:18 GMT');
        $expectedPublicAccess = 'container';
        $expectedContainerACL = ContainerACL::create($expectedPublicAccess, $sample);

        // Test
        $result = GetContainerACLResult::create(
            $expectedPublicAccess,
            $expectedETag,
            $expectedDate,
            $sample
        );

        // Assert
        self::assertEquals($expectedContainerACL, $result->getContainerAcl());
        self::assertEquals($expectedDate, $result->getLastModified());
        self::assertEquals($expectedETag, $result->getETag());
    }
}

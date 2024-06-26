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

namespace AzureOSS\Storage\Tests\Unit\File\Models;

use AzureOSS\Storage\Common\Internal\Resources;
use AzureOSS\Storage\File\Internal\FileResources;
use AzureOSS\Storage\File\Models\Directory;
use AzureOSS\Storage\Tests\Framework\TestResources;

/**
 * Unit tests for class Directory
 *
 * @see      https://github.com/azure/azure-storage-php
 */
class DirectoryTest extends \PHPUnit\Framework\TestCase
{
    public function testCreate()
    {
        // Setup
        $listArray =
            TestResources::getInterestingListDirectoriesAndFilesResultArray(5, 0);
        $samples = $listArray[Resources::QP_ENTRIES][FileResources::QP_DIRECTORY];

        // Test
        $actuals = [];
        $actuals[] = Directory::create($samples[0]);
        $actuals[] = Directory::create($samples[1]);
        $actuals[] = Directory::create($samples[2]);
        $actuals[] = Directory::create($samples[3]);
        $actuals[] = Directory::create($samples[4]);

        // Assert
        for ($i = 0; $i < count($samples); ++$i) {
            $sample = $samples[$i];
            $actual = $actuals[$i];

            self::assertEquals($sample[Resources::QP_NAME], $actual->getName());
        }
    }
}

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

use MicrosoftAzure\Storage\Tests\Framework\TestResources;
use MicrosoftAzure\Storage\Common\Internal\Utilities;
use MicrosoftAzure\Storage\Blob\Models\CreateBlobSnapshotOptions;

/**
 * Unit tests for class CreateBlobSnapshotOptions
 *
 * @link      https://github.com/azure/azure-storage-php
 */
class CreateBlobSnapshotOptionsTest extends \PHPUnit\Framework\TestCase
{
    public function testSetMetadata()
    {
        $createBlobSnapshotOptions = new CreateBlobSnapshotOptions();
        $expected = ['key1' => 'value1', 'key2' => 'value2'];
        $createBlobSnapshotOptions->setMetadata($expected);

        $this->assertEquals(
            $expected,
            $createBlobSnapshotOptions->getMetadata()
        );
    }

    public function testSetLeaseId()
    {
        $createBlobSnapshotOptions = new CreateBlobSnapshotOptions();
        $expected = "123456789";
        $createBlobSnapshotOptions->setLeaseId($expected);

        $this->assertEquals(
            $expected,
            $createBlobSnapshotOptions->getLeaseId()
        );
    }
}

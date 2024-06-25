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

namespace AzureOSS\Storage\Tests\Unit\Blob\Models;

use AzureOSS\Storage\Blob\Models\AccessCondition;
use AzureOSS\Storage\Blob\Models\CopyBlobOptions;

/**
 * Unit tests for class CopyBlobBlobOptions
 *
 * @see      https://github.com/azure/azure-storage-php
 */
class CopyBlobOptionsTest extends \PHPUnit\Framework\TestCase
{
    public function testSetMetadata()
    {
        $copyBlobOptions = new CopyBlobOptions();
        $expected = ['key1' => 'value1', 'key2' => 'value2'];
        $copyBlobOptions->setMetadata($expected);

        self::assertEquals(
            $expected,
            $copyBlobOptions->getMetadata(),
        );
    }

    public function testSetAccessConditions()
    {
        $copyBlobOptions = new CopyBlobOptions();
        $expected = AccessCondition::ifMatch('12345');
        $copyBlobOptions->setAccessConditions($expected);

        self::assertEquals(
            $expected,
            $copyBlobOptions->getAccessConditions()[0],
        );
    }

    public function testSetSourceAccessConditions()
    {
        $copyBlobOptions = new CopyBlobOptions();
        $expected = AccessCondition::IfMatch('x');
        $copyBlobOptions->setSourceAccessConditions($expected);

        self::assertEquals(
            $expected,
            $copyBlobOptions->getSourceAccessConditions()[0],
        );
    }

    public function testSetLeaseId()
    {
        $expected = '0x8CAFB82EFF70C46';
        $options = new CopyBlobOptions();

        $options->setLeaseId($expected);
        self::assertEquals($expected, $options->getLeaseId());
    }

    public function testSetSourceLeaseId()
    {
        $expected = '0x8CAFB82EFF70C46';
        $options = new CopyBlobOptions();

        $options->setSourceLeaseId($expected);
        self::assertEquals($expected, $options->getSourceLeaseId());
    }

    public function testSetIsIncrementalCopy()
    {
        $expected = true;
        $options = new CopyBlobOptions();

        $options->setIsIncrementalCopy($expected);
        self::assertEquals($expected, $options->getIsIncrementalCopy());
    }

    public function testSetSourceSnapshot()
    {
        $expected = '2017-09-19T10:39:36.8401215Z';
        $options = new CopyBlobOptions();

        $options->setSourceSnapshot($expected);
        self::assertEquals($expected, $options->getSourceSnapshot());
    }
}

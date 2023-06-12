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

use MicrosoftAzure\Storage\Blob\Models\ListBlobBlocksOptions;
use MicrosoftAzure\Storage\Tests\Framework\TestResources;

/**
 * Unit tests for class ListBlobBlocksOptions
 *
 * @link      https://github.com/azure/azure-storage-php
 */
class ListBlobBlocksOptionsTest extends \PHPUnit\Framework\TestCase
{
    public function testSetSnapshot()
    {
        // Setup
        $blob = new ListBlobBlocksOptions();
        $expected = TestResources::QUEUE1_NAME;

        // Test
        $blob->setSnapshot($expected);

        // Assert
        self::assertEquals($expected, $blob->getSnapshot());
    }

    public function testGetSnapshot()
    {
        // Setup
        $blob = new ListBlobBlocksOptions();
        $expected = TestResources::QUEUE_URI;
        $blob->setSnapshot($expected);

        // Test
        $actual = $blob->getSnapshot();

        // Assert
        self::assertEquals($expected, $actual);
    }

    public function testSetLeaseId()
    {
        // Setup
        $expected = '0x8CAFB82EFF70C46';
        $options = new ListBlobBlocksOptions();
        $options->setLeaseId($expected);

        // Test
        $options->setLeaseId($expected);

        // Assert
        self::assertEquals($expected, $options->getLeaseId());
    }

    public function testSetIncludeUncommittedBlobs()
    {
        // Setup
        $options = new ListBlobBlocksOptions();
        $expected = true;

        // Test
        $options->setIncludeUncommittedBlobs($expected);

        // Assert
        self::assertEquals($expected, $options->getIncludeUncommittedBlobs());
    }

    public function testGetIncludeUncommittedBlobs()
    {
        // Setup
        $options = new ListBlobBlocksOptions();
        $expected = true;
        $options->setIncludeUncommittedBlobs($expected);

        // Test
        $actual = $options->getIncludeUncommittedBlobs();

        // Assert
        self::assertEquals($expected, $actual);
    }

    public function testSetIncludeCommittedBlobs()
    {
        // Setup
        $options = new ListBlobBlocksOptions();
        $expected = true;

        // Test
        $options->setIncludeCommittedBlobs($expected);

        // Assert
        self::assertEquals($expected, $options->getIncludeCommittedBlobs());
    }

    public function testGetIncludeCommittedBlobs()
    {
        // Setup
        $options = new ListBlobBlocksOptions();
        $expected = true;
        $options->setIncludeCommittedBlobs($expected);

        // Test
        $actual = $options->getIncludeCommittedBlobs();

        // Assert
        self::assertEquals($expected, $actual);
    }

    public function testGetBlockListType()
    {
        // Setup
        $options = new ListBlobBlocksOptions();
        $expected = 'all';

        // Test
        $actual = $options->getBlockListType();

        // Assert
        self::assertEquals($expected, $actual);
    }
}

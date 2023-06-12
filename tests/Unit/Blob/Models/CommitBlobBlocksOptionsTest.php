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

use MicrosoftAzure\Storage\Blob\Models\AccessCondition;
use MicrosoftAzure\Storage\Blob\Models\CommitBlobBlocksOptions;

/**
 * Unit tests for class CommitBlobBlocksOptions
 *
 * @link      https://github.com/azure/azure-storage-php
 */
class CommitBlobBlocksOptionsTest extends \PHPUnit\Framework\TestCase
{
    public function testSetContentType()
    {
        // Setup
        $expected = '0x8CAFB82EFF70C46';
        $options = new CommitBlobBlocksOptions();
        $options->setContentType($expected);

        // Test
        $options->setContentType($expected);

        // Assert
        self::assertEquals($expected, $options->getContentType());
    }

    public function testSetContentEncoding()
    {
        // Setup
        $expected = '0x8CAFB82EFF70C46';
        $options = new CommitBlobBlocksOptions();
        $options->setContentEncoding($expected);

        // Test
        $options->setContentEncoding($expected);

        // Assert
        self::assertEquals($expected, $options->getContentEncoding());
    }

    public function testSetContentLanguage()
    {
        // Setup
        $expected = '0x8CAFB82EFF70C46';
        $options = new CommitBlobBlocksOptions();
        $options->setContentLanguage($expected);

        // Test
        $options->setContentLanguage($expected);

        // Assert
        self::assertEquals($expected, $options->getContentLanguage());
    }

    public function testSetContentMD5()
    {
        // Setup
        $expected = '0x8CAFB82EFF70C46';
        $options = new CommitBlobBlocksOptions();
        $options->setContentMD5($expected);

        // Test
        $options->setContentMD5($expected);

        // Assert
        self::assertEquals($expected, $options->getContentMD5());
    }

    public function testSetCacheControl()
    {
        // Setup
        $expected = '0x8CAFB82EFF70C46';
        $options = new CommitBlobBlocksOptions();
        $options->setCacheControl($expected);

        // Test
        $options->setCacheControl($expected);

        // Assert
        self::assertEquals($expected, $options->getCacheControl());
    }

    public function testSetContentDisposition()
    {
        // Setup
        $expected = '0x8CAFB82EFF70C46';
        $options = new CommitBlobBlocksOptions();
        $options->setContentDisposition($expected);

        // Test
        $options->setContentDisposition($expected);

        // Assert
        self::assertEquals($expected, $options->getContentDisposition());
    }

    public function testSetLeaseId()
    {
        // Setup
        $expected = '0x8CAFB82EFF70C46';
        $options = new CommitBlobBlocksOptions();
        $options->setLeaseId($expected);

        // Test
        $options->setLeaseId($expected);

        // Assert
        self::assertEquals($expected, $options->getLeaseId());
    }

    public function testSetMetadata()
    {
        // Setup
        $container = new CommitBlobBlocksOptions();
        $expected = ['key1' => 'value1', 'key2' => 'value2'];

        // Test
        $container->setMetadata($expected);

        // Assert
        self::assertEquals($expected, $container->getMetadata());
    }

    public function testGetMetadata()
    {
        // Setup
        $container = new CommitBlobBlocksOptions();
        $expected = ['key1' => 'value1', 'key2' => 'value2'];
        $container->setMetadata($expected);

        // Test
        $actual = $container->getMetadata();

        // Assert
        self::assertEquals($expected, $actual);
    }

    public function testGetAccessConditions()
    {
        // Setup
        $expected = AccessCondition::none();
        $result = new CommitBlobBlocksOptions();
        $result->setAccessConditions($expected);

        // Test
        $actual = $result->getAccessConditions();

        // Assert
        self::assertEquals($expected, $actual[0]);
    }

    public function testSetAccessConditions()
    {
        // Setup
        $expected = AccessCondition::none();
        $result = new CommitBlobBlocksOptions();

        // Test
        $result->setAccessConditions($expected);

        // Assert
        self::assertEquals($expected, $result->getAccessConditions()[0]);
    }
}

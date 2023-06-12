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

namespace MicrosoftAzure\Storage\Tests\Unit\Blob\Models;

use MicrosoftAzure\Storage\Blob\Models\AccessCondition;
use MicrosoftAzure\Storage\Blob\Models\BlobProperties;
use MicrosoftAzure\Storage\Blob\Models\SetBlobPropertiesOptions;

/**
 * Unit tests for class SetBlobPropertiesOptions
 *
 * @see      https://github.com/azure/azure-storage-php
 */
class SetBlobPropertiesOptionsTest extends \PHPUnit\Framework\TestCase
{
    public function testconstruct()
    {
        // Setup
        $expectedLength = 10;
        $blobProperties = new BlobProperties();
        $blobProperties->setContentLength($expectedLength);

        // Test
        $options = new SetBlobPropertiesOptions($blobProperties);

        // Assert
        self::assertNotNull($options);
        self::assertEquals($expectedLength, $options->getContentLength());
    }

    public function testSetContentType()
    {
        // Setup
        $expected = '0x8CAFB82EFF70C46';
        $options = new SetBlobPropertiesOptions();
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
        $options = new SetBlobPropertiesOptions();
        $options->setContentEncoding($expected);

        // Test
        $options->setContentEncoding($expected);

        // Assert
        self::assertEquals($expected, $options->getContentEncoding());
    }

    public function testSetContentLength()
    {
        // Setup
        $expected = 123;
        $options = new SetBlobPropertiesOptions();
        $options->setContentLength($expected);

        // Test
        $options->setContentLength($expected);

        // Assert
        self::assertEquals($expected, $options->getContentLength());
    }

    public function testSetContentLanguage()
    {
        // Setup
        $expected = '0x8CAFB82EFF70C46';
        $options = new SetBlobPropertiesOptions();
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
        $options = new SetBlobPropertiesOptions();
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
        $options = new SetBlobPropertiesOptions();
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
        $options = new SetBlobPropertiesOptions();
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
        $options = new SetBlobPropertiesOptions();
        $options->setLeaseId($expected);

        // Test
        $options->setLeaseId($expected);

        // Assert
        self::assertEquals($expected, $options->getLeaseId());
    }

    public function testSetSequenceNumber()
    {
        // Setup
        $expected = 123;
        $options = new SetBlobPropertiesOptions();
        $options->setSequenceNumber($expected);

        // Test
        $options->setSequenceNumber($expected);

        // Assert
        self::assertEquals($expected, $options->getSequenceNumber());
    }

    public function testGetAccessConditions()
    {
        // Setup
        $expected = AccessCondition::none();
        $result = new SetBlobPropertiesOptions();
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
        $result = new SetBlobPropertiesOptions();

        // Test
        $result->setAccessConditions($expected);

        // Assert
        self::assertEquals($expected, $result->getAccessConditions()[0]);
    }
}

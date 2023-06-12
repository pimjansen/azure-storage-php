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

use MicrosoftAzure\Storage\Blob\Models\BlobProperties;
use MicrosoftAzure\Storage\Common\Internal\Utilities;
use MicrosoftAzure\Storage\Tests\Framework\TestResources;

/**
 * Unit tests for class BlobProperties
 *
 * @link      https://github.com/azure/azure-storage-php
 */
class BlobPropertiesTest extends \PHPUnit\Framework\TestCase
{
    public function testCreate()
    {
        // Setup
        $sample = TestResources::listBlobsOneEntry();
        $expected = $sample['Blobs']['Blob']['Properties'];
        $expectedDate = Utilities::rfc1123ToDateTime($expected['Last-Modified']);

        // Test
        $actual = BlobProperties::createFromHttpHeaders($expected);

        // Assert
        self::assertEquals($expectedDate, $actual->getLastModified());
        self::assertEquals($expected['Etag'], $actual->getETag());
        self::assertEquals((int) ($expected['Content-Length']), $actual->getContentLength());
        self::assertEquals($expected['Content-Type'], $actual->getContentType());
        self::assertEquals($expected['Content-Encoding'], $actual->getContentEncoding());
        self::assertEquals($expected['Content-Language'], $actual->getContentLanguage());
        self::assertEquals($expected['Content-MD5'], $actual->getContentMD5());
        self::assertEquals($expected['Cache-Control'], $actual->getCacheControl());
        self::assertEquals((int) ($expected['x-ms-blob-sequence-number']), $actual->getSequenceNumber());
        self::assertEquals($expected['x-ms-blob-type'], $actual->getBlobType());
        self::assertEquals($expected['x-ms-lease-status'], $actual->getLeaseStatus());
        self::assertEquals(Utilities::toBoolean($expected['x-ms-server-encrypted']), $actual->getServerEncrypted());
        self::assertEquals(Utilities::toBoolean($expected['x-ms-incremental-copy']), $actual->getIncrementalCopy());
        self::assertEquals($expected['x-ms-copy-destination-snapshot'], $actual->getCopyDestinationSnapshot());
    }

    public function testSetLastModified()
    {
        // Setup
        $expected = Utilities::rfc1123ToDateTime('Sun, 25 Sep 2011 19:42:18 GMT');
        $properties = new BlobProperties();

        // Test
        $properties->setLastModified($expected);

        // Assert
        self::assertEquals($expected, $properties->getLastModified());
    }

    public function testSetCreationTime()
    {
        // Setup
        $expected = Utilities::rfc1123ToDateTime('Sun, 25 Sep 2011 19:42:18 GMT');
        $properties = new BlobProperties();

        // Test
        $properties->setCreationTime($expected);

        // Assert
        self::assertEquals($expected, $properties->getCreationTime());
    }

    public function testSetETag()
    {
        // Setup
        $expected = '0x8CAFB82EFF70C46';
        $properties = new BlobProperties();
        $properties->setETag($expected);

        // Test
        $properties->setETag($expected);

        // Assert
        self::assertEquals($expected, $properties->getETag());
    }

    public function testSetContentRange()
    {
        // Setup
        $expected = '0x8CAFB82EFF70C46';
        $properties = new BlobProperties();
        $properties->setContentRange($expected);

        // Test
        $properties->setContentRange($expected);

        // Assert
        self::assertEquals($expected, $properties->getContentRange());
    }

    public function testSetContentType()
    {
        // Setup
        $expected = '0x8CAFB82EFF70C46';
        $properties = new BlobProperties();
        $properties->setContentType($expected);

        // Test
        $properties->setContentType($expected);

        // Assert
        self::assertEquals($expected, $properties->getContentType());
    }

    public function testSetContentLength()
    {
        // Setup
        $expected = 100;
        $properties = new BlobProperties();
        $properties->setContentLength($expected);

        // Test
        $properties->setContentLength($expected);

        // Assert
        self::assertEquals($expected, $properties->getContentLength());
    }

    public function testSetContentEncoding()
    {
        // Setup
        $expected = '0x8CAFB82EFF70C46';
        $properties = new BlobProperties();
        $properties->setContentEncoding($expected);

        // Test
        $properties->setContentEncoding($expected);

        // Assert
        self::assertEquals($expected, $properties->getContentEncoding());
    }

    public function testSetContentLanguage()
    {
        // Setup
        $expected = '0x8CAFB82EFF70C46';
        $properties = new BlobProperties();
        $properties->setContentLanguage($expected);

        // Test
        $properties->setContentLanguage($expected);

        // Assert
        self::assertEquals($expected, $properties->getContentLanguage());
    }

    public function testSetContentMD5()
    {
        // Setup
        $expected = '0x8CAFB82EFF70C46';
        $properties = new BlobProperties();
        $properties->setContentMD5($expected);

        // Test
        $properties->setContentMD5($expected);

        // Assert
        self::assertEquals($expected, $properties->getContentMD5());
    }

    public function testSetCacheControl()
    {
        // Setup
        $expected = '0x8CAFB82EFF70C46';
        $properties = new BlobProperties();
        $properties->setCacheControl($expected);

        // Test
        $properties->setCacheControl($expected);

        // Assert
        self::assertEquals($expected, $properties->getCacheControl());
    }

    public function testSetContentDisposition()
    {
        // Setup
        $expected = '0x8CAFB82EFF70C46';
        $properties = new BlobProperties();
        $properties->setContentDisposition($expected);

        // Test
        $properties->setContentDisposition($expected);

        // Assert
        self::assertEquals($expected, $properties->getContentDisposition());
    }

    public function testSetBlobType()
    {
        // Setup
        $expected = '0x8CAFB82EFF70C46';
        $properties = new BlobProperties();
        $properties->setBlobType($expected);

        // Test
        $properties->setBlobType($expected);

        // Assert
        self::assertEquals($expected, $properties->getblobType());
    }

    public function testSetLeaseStatus()
    {
        // Setup
        $expected = '0x8CAFB82EFF70C46';
        $properties = new BlobProperties();
        $properties->setLeaseStatus($expected);

        // Test
        $properties->setLeaseStatus($expected);

        // Assert
        self::assertEquals($expected, $properties->getLeaseStatus());
    }

    public function testSetSequenceNumber()
    {
        // Setup
        $expected = 123;
        $properties = new BlobProperties();

        // Test
        $properties->setSequenceNumber($expected);

        // Assert
        self::assertEquals($expected, $properties->getSequenceNumber());
    }

    public function testSetCopyDestinationSnapshot()
    {
        // Setup
        $expected = '2017-09-07T06:57:06.0830478Z';
        $properties = new BlobProperties();

        // Test
        $properties->setCopyDestinationSnapshot($expected);

        // Assert
        self::assertEquals($expected, $properties->getCopyDestinationSnapshot());
    }

    public function testSetIncrementalCopy()
    {
        // Setup
        $expected = true;
        $properties = new BlobProperties();

        // Test
        $properties->setIncrementalCopy($expected);

        // Assert
        self::assertEquals($expected, $properties->getIncrementalCopy());
    }

    public function testSetServerEncrypted()
    {
        // Setup
        $expectedTrue = true;
        $expectedFalse = false;
        $expectedNull = null;

        $propertiesTrue = new BlobProperties();
        $propertiesFalse = new BlobProperties();
        $propertiesNull = new BlobProperties();

        // Test
        $propertiesTrue->setServerEncrypted($expectedTrue);
        $propertiesFalse->setServerEncrypted($expectedFalse);
        $propertiesNull->setServerEncrypted($expectedNull);

        // Assert
        self::assertEquals($expectedTrue, $propertiesTrue->getServerEncrypted());
        self::assertEquals($expectedFalse, $propertiesFalse->getServerEncrypted());
        self::assertEquals($expectedNull, $propertiesNull->getServerEncrypted());
    }

    public function testSetDeletedTime()
    {
        // Setup
        $expected = Utilities::rfc1123ToDateTime('Sun, 25 Sep 2011 19:42:18 GMT');
        $properties = new BlobProperties();

        // Test
        $properties->setDeletedTime($expected);

        // Assert
        self::assertEquals($expected, $properties->getDeletedTime());
    }

    public function testSetRemainingRetentionDays()
    {
        // Setup
        $expected = 8;
        $properties = new BlobProperties();

        // Test
        $properties->setRemainingRetentionDays($expected);

        // Assert
        self::assertEquals($expected, $properties->getRemainingRetentionDays());
    }
}

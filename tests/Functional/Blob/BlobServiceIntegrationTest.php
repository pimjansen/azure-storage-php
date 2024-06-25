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

namespace AzureOSS\Storage\Tests\Functional\Blob;

use AzureOSS\Storage\Blob\Models\AccessCondition;
use AzureOSS\Storage\Blob\Models\BlobBlockType;
use AzureOSS\Storage\Blob\Models\Block;
use AzureOSS\Storage\Blob\Models\BlockList;
use AzureOSS\Storage\Blob\Models\ContainerACL;
use AzureOSS\Storage\Blob\Models\CreateBlobSnapshotOptions;
use AzureOSS\Storage\Blob\Models\CreateBlockBlobOptions;
use AzureOSS\Storage\Blob\Models\CreateContainerOptions;
use AzureOSS\Storage\Blob\Models\CreatePageBlobOptions;
use AzureOSS\Storage\Blob\Models\GetBlobOptions;
use AzureOSS\Storage\Blob\Models\GetBlobPropertiesOptions;
use AzureOSS\Storage\Blob\Models\ListBlobBlocksOptions;
use AzureOSS\Storage\Blob\Models\ListBlobsOptions;
use AzureOSS\Storage\Blob\Models\ListContainersOptions;
use AzureOSS\Storage\Blob\Models\PublicAccessType;
use AzureOSS\Storage\Blob\Models\SetBlobPropertiesOptions;
use AzureOSS\Storage\Common\Exceptions\ServiceException;
use AzureOSS\Storage\Common\Internal\Utilities;
use AzureOSS\Storage\Common\Models\Range;
use AzureOSS\Storage\Tests\Framework\TestResources;

class BlobServiceIntegrationTest extends IntegrationTestBase
{
    private static $_testContainersPrefix = 'sdktest-';
    private static $_createableContainersPrefix = 'csdktest-';
    private static $_blob_for_root_container = 'sdktestroot';
    private static $_creatable_container_1;
    private static $_creatable_container_2;
    private static $_creatable_container_3;
    private static $_creatable_container_4;
    private static $_test_container_for_blobs;
    private static $_test_container_for_blobs_2;
    private static $_test_container_for_listing;
    private static $_creatableContainers;
    private static $_testContainers;

    private static $isOneTimeSetup = false;

    protected function setUp(): void
    {
        parent::setUp();
        if (!self::$isOneTimeSetup) {
            $this->doOneTimeSetup();
            self::$isOneTimeSetup = true;
        }
    }

    private function doOneTimeSetup()
    {
        // Setup container names array (list of container names used by
        // integration tests)
        $rint = mt_rand(0, 1000000);
        self::$_testContainers = [];
        for ($i = 0; $i < 10; ++$i) {
            self::$_testContainers[$i] = self::$_testContainersPrefix . ($rint + $i);
        }

        self::$_creatableContainers = [];
        for ($i = 0; $i < 10; ++$i) {
            self::$_creatableContainers[$i] = self::$_createableContainersPrefix . ($rint + $i);
        }

        self::$_creatable_container_1 = self::$_creatableContainers[0];
        self::$_creatable_container_2 = self::$_creatableContainers[1];
        self::$_creatable_container_3 = self::$_creatableContainers[2];
        self::$_creatable_container_4 = self::$_creatableContainers[3];

        self::$_test_container_for_blobs = self::$_testContainers[0];
        self::$_test_container_for_blobs_2 = self::$_testContainers[1];
        self::$_test_container_for_listing = self::$_testContainers[2];

        // Create all test containers and their content
        $this->createContainers(self::$_testContainers, self::$_testContainersPrefix);
    }

    public static function tearDownAfterClass(): void
    {
        if (self::$isOneTimeSetup) {
            $inst = new IntegrationTestBase();
            $inst->setUp();
            $inst->deleteContainers(self::$_testContainers, self::$_testContainersPrefix);
            $inst->deleteContainers(self::$_creatableContainers, self::$_createableContainersPrefix);
            self::$isOneTimeSetup = false;
        }
        parent::tearDownAfterClass();
    }

    protected function tearDown(): void
    {
        // tearDown of parent will delete the container created in setUp
        // Do nothing here
    }

    public function testGetServicePropertiesWorks()
    {
        // Act
        $shouldReturn = false;
        try {
            $props = $this->restProxy->getServiceProperties()->getValue();
            self::assertTrue(!$this->isEmulated(), 'Should succeed if and only if not running in emulator');
        } catch (ServiceException $e) {
            // Expect failure in emulator, as v1.6 doesn't support this method
            if ($this->isEmulated()) {
                self::assertEquals(TestResources::STATUS_BAD_REQUEST, $e->getCode(), 'getCode');
                $shouldReturn = true;
            } else {
                throw $e;
            }
        }
        if ($shouldReturn) {
            return;
        }

        // Assert
        self::assertNotNull($props, '$props');
        self::assertNotNull($props->getLogging(), '$props->getLogging');
        self::assertNotNull($props->getLogging()->getRetentionPolicy(), '$props->getLogging()->getRetentionPolicy');
        self::assertNotNull($props->getLogging()->getVersion(), '$props->getLogging()->getVersion');
        self::assertNotNull($props->getHourMetrics()->getRetentionPolicy(), '$props->getHourMetrics()->getRetentionPolicy');
        self::assertNotNull($props->getHourMetrics()->getVersion(), '$props->getHourMetrics()->getVersion');
    }

    public function testSetServicePropertiesWorks()
    {
        // Act
        $shouldReturn = false;
        try {
            $props = $this->restProxy->getServiceProperties()->getValue();
            self::assertTrue(!$this->isEmulated(), 'Should succeed if and only if not running in emulator');
        } catch (ServiceException $e) {
            // Expect failure in emulator, as v1.6 doesn't support this method
            if ($this->isEmulated()) {
                self::assertEquals(TestResources::STATUS_BAD_REQUEST, $e->getCode(), 'getCode');
                $shouldReturn = true;
            } else {
                throw $e;
            }
        }
        if ($shouldReturn) {
            return;
        }

        $props->getLogging()->setRead(true);
        $this->restProxy->setServiceProperties($props);

        $props = $this->restProxy->getServiceProperties()->getValue();

        // Assert
        self::assertNotNull($props, '$props');
        self::assertNotNull($props->getLogging(), '$props->getLogging');
        self::assertNotNull($props->getLogging()->getRetentionPolicy(), '$props->getLogging()->getRetentionPolicy');
        self::assertNotNull($props->getLogging()->getVersion(), '$props->getLogging()->getVersion');
        self::assertTrue($props->getLogging()->getRead(), '$props->getLogging()->getRead');
        self::assertNotNull($props->getHourMetrics()->getRetentionPolicy(), '$props->getHourMetrics()->getRetentionPolicy');
        self::assertNotNull($props->getHourMetrics()->getVersion(), '$props->getHourMetrics()->getVersion');
    }

    public function testCreateContainerWorks()
    {
        // Act
        $this->restProxy->createContainer(self::$_creatable_container_1);

        // Assert
        $opts = new ListContainersOptions();
        $opts->setPrefix(self::$_creatable_container_1);
        $results = $this->restProxy->listContainers($opts);

        self::assertNotNull($results, '$results');
        self::assertCount(1, $results->getContainers(), 'count($results->getContainers())');
        $container0 = $results->getContainers();
        $container0 = $container0[0];
        self::assertEquals(
            self::$_creatable_container_1,
            $container0->getName(),
            '$results->getContainers()[0]->getName',
        );
    }

    public function testCreateContainerWithMetadataWorks()
    {
        // Act
        $opts = new CreateContainerOptions();
        $opts->setPublicAccess('blob');
        $opts->addMetadata('test', 'bar');
        $opts->addMetadata('blah', 'bleah');
        $this->restProxy->createContainer(self::$_creatable_container_2, $opts);

        $prop = $this->restProxy->getContainerMetadata(
            self::$_creatable_container_2,
        );
        $prop2 = $this->restProxy->getContainerProperties(
            self::$_creatable_container_2,
        );
        $acl = $this->restProxy->getContainerACL(
            self::$_creatable_container_2,
        )->getContainerACL();

        $opts = new ListContainersOptions();
        $opts->setPrefix(self::$_creatable_container_2);
        $opts->setIncludeMetadata(true);
        $results2 = $this->restProxy->listContainers($opts);

        $this->restProxy->deleteContainer(self::$_creatable_container_2);

        // Assert
        self::assertNotNull($prop, '$prop');
        self::assertNotNull($prop->getETag(), '$prop->getETag()');
        self::assertNotNull($prop->getLastModified(), '$prop->getLastModified()');
        self::assertNotNull($prop->getMetadata(), '$prop->getMetadata()');
        self::assertCount(
            2,
            $prop->getMetadata(),
            'count($prop->getMetadata())',
        );
        self::assertTrue(
            Utilities::arrayKeyExistsInsensitive(
                'test',
                $prop->getMetadata(),
            ),
            'Utilities::arrayKeyExistsInsensitive(\'test\', $prop->getMetadata())',
        );
        self::assertTrue(
            !(array_search('bar', $prop->getMetadata(), true) === false),
            '!(array_search(\'bar\', $prop->getMetadata()) === FALSE)',
        );
        self::assertTrue(
            Utilities::arrayKeyExistsInsensitive('blah', $prop->getMetadata()),
            'Utilities::arrayKeyExistsInsensitive(\'blah\', $prop->getMetadata())',
        );
        self::assertTrue(
            !(array_search('bleah', $prop->getMetadata(), true) === false),
            '!(array_search(\'bleah\', $prop->getMetadata()) === FALSE)',
        );

        self::assertNotNull($prop2, '$prop2');
        self::assertNotNull($prop2->getETag(), '$prop2->getETag()');
        self::assertNotNull(
            $prop2->getLastModified(),
            '$prop2->getLastModified()',
        );
        self::assertNotNull($prop2->getMetadata(), '$prop2->getMetadata()');
        self::assertCount(
            2,
            $prop2->getMetadata(),
            'count($prop2->getMetadata())',
        );
        self::assertTrue(
            Utilities::arrayKeyExistsInsensitive(
                'test',
                $prop2->getMetadata(),
            ),
            'Utilities::arrayKeyExistsInsensitive(\'test\',
            $prop2->getMetadata())',
        );
        self::assertTrue(
            !(array_search('bar', $prop2->getMetadata(), true) === false),
            '!(array_search(\'bar\', $prop2->getMetadata()) === FALSE)',
        );
        self::assertTrue(
            Utilities::arrayKeyExistsInsensitive('blah', $prop2->getMetadata()),
            'Utilities::arrayKeyExistsInsensitive(\'blah\', $prop2->getMetadata())',
        );
        self::assertTrue(
            !(array_search('bleah', $prop2->getMetadata(), true) === false),
            '!(array_search(\'bleah\', $prop2->getMetadata()) === FALSE)',
        );

        self::assertNotNull($results2, '$results2');
        self::assertCount(
            1,
            $results2->getContainers(),
            'count($results2->getContainers())',
        );
        $container0 = $results2->getContainers();
        $container0 = $container0[0];
        // The capitalizaion gets changed.
        self::assertTrue(
            Utilities::arrayKeyExistsInsensitive(
                'test',
                $container0->getMetadata(),
            ),
            'Utilities::arrayKeyExistsInsensitive(\'test\', $container0->getMetadata())',
        );
        self::assertTrue(
            !(array_search('bar', $container0->getMetadata(), true) === false),
            '!(array_search(\'bar\', $container0->getMetadata()) === FALSE)',
        );
        self::assertTrue(
            Utilities::arrayKeyExistsInsensitive(
                'blah',
                $container0->getMetadata(),
            ),
            'Utilities::arrayKeyExistsInsensitive(\'blah\', $container0->getMetadata())',
        );
        self::assertTrue(
            !(array_search('bleah', $container0->getMetadata(), true) === false),
            '!(array_search(\'bleah\', $container0->getMetadata()) === FALSE)',
        );

        self::assertNotNull($acl, '$acl');
    }

    public function testSetContainerMetadataWorks()
    {
        // Act
        $this->restProxy->createContainer(self::$_creatable_container_3);

        $metadata = [
            'test' => 'bar',
            'blah' => 'bleah'];
        $this->restProxy->setContainerMetadata(self::$_creatable_container_3, $metadata);
        $prop = $this->restProxy->getContainerMetadata(self::$_creatable_container_3);

        // Assert
        self::assertNotNull($prop, '$prop');
        self::assertNotNull($prop->getETag(), '$prop->getETag()');
        self::assertNotNull($prop->getLastModified(), '$prop->getLastModified()');
        self::assertNotNull($prop->getMetadata(), '$prop->getMetadata()');
        self::assertCount(2, $prop->getMetadata(), 'count($prop->getMetadata())');
        self::assertTrue(
            Utilities::arrayKeyExistsInsensitive(
                'test',
                $prop->getMetadata(),
            ),
            'Utilities::arrayKeyExistsInsensitive(\'test\', $prop->getMetadata())',
        );
        self::assertTrue(
            !(array_search('bar', $prop->getMetadata(), true) === false),
            '!(array_search(\'bar\', $prop->getMetadata()) === FALSE)',
        );
        self::assertTrue(
            Utilities::arrayKeyExistsInsensitive('blah', $prop->getMetadata()),
            'Utilities::arrayKeyExistsInsensitive(\'blah\', $prop->getMetadata())',
        );
        self::assertTrue(
            !(array_search('bleah', $prop->getMetadata(), true) === false),
            '!(array_search(\'bleah\', $prop->getMetadata()) === FALSE)',
        );
    }

    public function testSetContainerACLWorks()
    {
        // Arrange
        $container = self::$_creatable_container_4;

        $expiryStartDate = new \DateTime();
        $expiryStartDate->setDate(2010, 1, 1);
        $expiryEndDate = new \DateTime();
        $expiryEndDate->setDate(2020, 1, 1);

        // Act
        $this->restProxy->createContainer($container);
        $acl = new ContainerACL();
        $acl->setPublicAccess(PublicAccessType::BLOBS_ONLY);

        $acl->addSignedIdentifier('test', $expiryStartDate, $expiryEndDate, 'rwd');
        $this->restProxy->setContainerACL($container, $acl);

        $res = $this->restProxy->getContainerACL($container);
        $acl2 = $res->getContainerACL();
        $this->restProxy->deleteContainer($container);

        // Assert
        self::assertNotNull($acl2, '$acl2');
        self::assertNotNull($res->getETag(), '$res->getETag()');
        self::assertNotNull($res->getLastModified(), '$res->getLastModified()');
        self::assertNotNull($acl2->getPublicAccess(), '$acl2->getPublicAccess()');
        self::assertEquals(
            PublicAccessType::BLOBS_ONLY,
            $acl2->getPublicAccess(),
            '$acl2->getPublicAccess()',
        );
        self::assertCount(1, $acl2->getSignedIdentifiers(), 'count($acl2->getSignedIdentifiers())');
        $signedids = $acl2->getSignedIdentifiers();
        self::assertEquals('test', $signedids[0]->getId(), '$signedids[0]->getId()');
        $expiryStartDate = $expiryStartDate->setTimezone(new \DateTimeZone('UTC'));
        $expiryEndDate = $expiryEndDate->setTimezone(new \DateTimeZone('UTC'));
        self::assertEquals(
            Utilities::convertToDateTime($expiryStartDate),
            Utilities::convertToDateTime(
                $signedids[0]->getAccessPolicy()->getStart(),
            ),
            '$signedids[0]->getAccessPolicy()->getStart()',
        );
        self::assertEquals(
            Utilities::convertToDateTime($expiryEndDate),
            Utilities::convertToDateTime(
                $signedids[0]->getAccessPolicy()->getExpiry(),
            ),
            '$signedids[0]->getAccessPolicy()->getExpiry()',
        );
        self::assertEquals(
            'rwd',
            $signedids[0]->getAccessPolicy()->getPermission(),
            '$signedids[0]->getAccessPolicy()->getPermission()',
        );
    }

    public function testListContainersWorks()
    {
        // Act
        $results = $this->restProxy->listContainers();

        // Assert
        self::assertNotNull($results, '$results');
        self::assertTrue(
            count(self::$_testContainers) <= count($results->getContainers()),
            'count(self::$_testContainers) <= count($results->getContainers())',
        );
        $container0 = $results->getContainers();
        $container0 = $container0[0];
        self::assertNotNull($container0->getName(), '$container0->getName()');
        self::assertNotNull($container0->getMetadata(), '$container0->getMetadata()');
        self::assertNotNull($container0->getProperties(), '$container0->getProperties()');
        self::assertNotNull($container0->getProperties()->getETag(), '$container0->getProperties()->getETag()');
        self::assertNotNull(
            $container0->getProperties()->getLastModified(),
            '$container0->getProperties()->getLastModified()',
        );
        self::assertNotNull($container0->getUrl(), '$container0->getUrl()');
    }

    public function testListContainersWithPaginationWorks()
    {
        // Act
        $opts = new ListContainersOptions();
        $opts->setMaxResults(3);
        $results = $this->restProxy->listContainers($opts);
        $opts2 = new ListContainersOptions();
        $opts2->setMarker($results ->getNextMarker());
        $results2 = $this->restProxy->listContainers($opts2);

        // Assert
        self::assertNotNull($results, '$results');
        self::assertCount(3, $results->getContainers(), 'count($results->getContainers())');
        self::assertNotNull($results->getNextMarker(), '$results->getNextMarker()');
        self::assertEquals(3, $results->getMaxResults(), '$results->getMaxResults()');

        self::assertNotNull($results2, '$results2');
        self::assertTrue(
            count(self::$_testContainers) - 3 <= count($results2->getContainers()),
            'count(self::$_testContainers) - 3 <= count($results2->getContainers())',
        );
        self::assertEquals('', $results2->getNextMarker(), '$results2->getNextMarker()');
        self::assertEquals(0, $results2->getMaxResults(), '$results2->getMaxResults()');
    }

    public function testListContainersWithPrefixWorks()
    {
        // Act
        $opts = new ListContainersOptions();
        $opts->setPrefix(self::$_testContainersPrefix);
        $opts->setMaxResults(3);
        $results = $this->restProxy->listContainers($opts);
        // Assert
        self::assertNotNull($results, '$results');
        self::assertCount(3, $results->getContainers(), 'count($results->getContainers())');
        self::assertNotNull($results->getNextMarker(), '$results->getNextMarker()');
        self::assertEquals(3, $results->getMaxResults(), '$results->getMaxResults()');

        // Act
        $opts = new ListContainersOptions();
        $opts->setPrefix(self::$_testContainersPrefix);
        $opts->setMarker($results->getNextMarker());
        $results2 = $this->restProxy->listContainers($opts);

        // Assert
        self::assertNotNull($results2, '$results2');
        self::assertNull($results2->getNextMarker(), '$results2->getNextMarker()');
        self::assertEquals(0, $results2->getMaxResults(), '$results2->getMaxResults()');

        // Act
        $opts = new ListContainersOptions();
        $opts->setPrefix(self::$_testContainersPrefix);
        $results3 = $this->restProxy->listContainers($opts);

        // Assert
        self::assertEquals(
            count($results->getContainers()) + count($results2->getContainers()),
            count($results3->getContainers()),
            'count($results3->getContainers())',
        );
    }

    public function testWorkingWithRootContainersWorks()
    {
        // Ensure root container exists
        $this->createContainerWithRetry('$root', new CreateContainerOptions());

        // Work with root container explicitly ('$root')

        // Act
        $this->restProxy->createPageBlob('$root', self::$_blob_for_root_container, 512);
        $list = $this->restProxy->listBlobs('$root');
        $properties = $this->restProxy->getBlobProperties('$root', self::$_blob_for_root_container);
        $metadata = $this->restProxy->getBlobMetadata('$root', self::$_blob_for_root_container);

        // Assert
        self::assertNotNull($list, '$list');
        self::assertTrue(1 <= count($list->getBlobs()), '1 <= count($list->getBlobs())');
        self::assertNotNull($properties, '$properties');
        self::assertNotNull($metadata, '$metadata');

        // Act
        $this->restProxy->deleteBlob('$root', self::$_blob_for_root_container);

        // Work with root container implicitly ('')

        // Act
        $this->restProxy->createPageBlob('', self::$_blob_for_root_container, 512);
        // '$root' must be explicit when listing blobs in the root container
        $list = $this->restProxy->listBlobs('$root');
        $properties = $this->restProxy->getBlobProperties('', self::$_blob_for_root_container);
        $metadata = $this->restProxy->getBlobMetadata('', self::$_blob_for_root_container);

        // Assert
        self::assertNotNull($list, '$list');
        self::assertTrue(1 <= count($list->getBlobs()), '1 <= count($list->getBlobs())');
        self::assertNotNull($properties, '$properties');
        self::assertNotNull($metadata, '$metadata');

        // Act
        $this->restProxy->deleteBlob('', self::$_blob_for_root_container);

        // Cleanup.
        $this->restProxy->deleteContainer('$root');
    }

    public function testListBlobsWorks()
    {
        // Arrange
        $blobNames = ['myblob1', 'myblob2', 'other-blob1', 'other-blob2'];
        foreach ($blobNames as $blob) {
            $this->restProxy->createPageBlob(self::$_test_container_for_listing, $blob, 512);
        }

        // Act
        $results = $this->restProxy->listBlobs(self::$_test_container_for_listing);

        foreach ($blobNames as $blob) {
            $this->restProxy->deleteBlob(self::$_test_container_for_listing, $blob);
        }

        // Assert
        self::assertNotNull($results, '$results');
        self::assertCount(4, $results->getBlobs(), 'count($results->getBlobs())');
    }

    public function testListBlobsWithPrefixWorks()
    {
        // Arrange
        $blobNames = ['myblob1', 'myblob2', 'otherblob1', 'otherblob2'];
        foreach ($blobNames as $blob) {
            $this->restProxy->createPageBlob(self::$_test_container_for_listing, $blob, 512);
        }

        // Act
        $opts = new ListBlobsOptions();
        $opts->setPrefix('myblob');
        $results = $this->restProxy->listBlobs(self::$_test_container_for_listing, $opts);
        $opts = new ListBlobsOptions();
        $opts->setPrefix('o');
        $results2 = $this->restProxy->listBlobs(self::$_test_container_for_listing, $opts);

        foreach ($blobNames as $blob) {
            $this->restProxy->deleteBlob(self::$_test_container_for_listing, $blob);
        }

        // Assert
        self::assertNotNull($results, '$results');
        self::assertCount(2, $results->getBlobs(), 'count($results->getBlobs())');
        $blobs = $results->getBlobs();
        self::assertEquals('myblob1', $blobs[0]->getName(), '$blobs[0]->getName()');
        self::assertEquals('myblob2', $blobs[1]->getName(), '$blobs[1]->getName()');

        self::assertNotNull($results2, '$results2');
        self::assertCount(2, $results2->getBlobs(), 'count($results2->getBlobs())');
        $blobs = $results2->getBlobs();
        self::assertEquals('otherblob1', $blobs[0]->getName(), '$blobs[0]->getName()');
        self::assertEquals('otherblob2', $blobs[1]->getName(), '$blobs[1]->getName()');
    }

    public function testListBlobsWithOptionsWorks()
    {
        // Arrange
        $blobNames = ['myblob1', 'myblob2', 'otherblob1', 'otherblob2'];
        foreach ($blobNames as $blob) {
            $this->restProxy->createPageBlob(self::$_test_container_for_listing, $blob, 512);
        }

        // Act
        $opts = new ListBlobsOptions();
        $opts->setIncludeMetadata(true);
        $opts->setIncludeSnapshots(true);
        $results = $this->restProxy->listBlobs(self::$_test_container_for_listing, $opts);

        foreach ($blobNames as $blob) {
            $this->restProxy->deleteBlob(self::$_test_container_for_listing, $blob);
        }

        // Assert
        self::assertNotNull($results, '$results');
        self::assertCount(4, $results->getBlobs(), 'count($results->getBlobs())');
    }

    public function testListBlobsWithDelimiterWorks()
    {
        // Arrange
        $blobNames = ['myblob1', 'myblob2', 'dir1-blob1', 'dir1-blob2', 'dir2-dir21-blob3', 'dir2-dir22-blob3'];
        foreach ($blobNames as $blob) {
            $this->restProxy->createPageBlob(self::$_test_container_for_listing, $blob, 512);
        }

        // Act
        $opts = new ListBlobsOptions();
        $opts->setDelimiter('-');
        $results = $this->restProxy->listBlobs(self::$_test_container_for_listing, $opts);
        $opts->setPrefix('dir1-');
        $results2 = $this->restProxy->listBlobs(self::$_test_container_for_listing, $opts);
        $opts->setPrefix('dir2-');
        $results3 = $this->restProxy->listBlobs(self::$_test_container_for_listing, $opts);
        $opts->setPrefix('dir2-dir21-');
        $results4 = $this->restProxy->listBlobs(self::$_test_container_for_listing, $opts);
        $opts->setPrefix('dir2-dir22-');
        $results5 = $this->restProxy->listBlobs(self::$_test_container_for_listing, $opts);
        $opts->setPrefix('dir2-dir44-');
        $results6 = $this->restProxy->listBlobs(self::$_test_container_for_listing, $opts);

        foreach ($blobNames as $blob) {
            $this->restProxy->deleteBlob(self::$_test_container_for_listing, $blob);
        }

        // Assert
        self::assertNotNull($results, '$results');
        self::assertCount(2, $results->getBlobs(), 'count($results->getBlobs())');
        self::assertCount(2, $results->getBlobPrefixes(), 'count($results->getBlobPrefixes())');

        self::assertCount(2, $results2->getBlobs(), 'count($results2->getBlobs())');
        self::assertCount(0, $results2->getBlobPrefixes(), 'count($results2->getBlobPrefixes())');

        self::assertCount(0, $results3->getBlobs(), 'count($results3->getBlobs())');
        self::assertCount(2, $results3->getBlobPrefixes(), 'count($results3->getBlobPrefixes())');

        self::assertCount(1, $results4->getBlobs(), 'count($results4->getBlobs())');
        self::assertCount(0, $results4->getBlobPrefixes(), 'count($results4->getBlobPrefixes())');

        self::assertCount(1, $results5->getBlobs(), 'count($results5->getBlobs())');
        self::assertCount(0, $results5->getBlobPrefixes(), 'count($results5->getBlobPrefixes())');

        self::assertCount(0, $results6->getBlobs(), 'count($results6->getBlobs())');
        self::assertCount(0, $results6->getBlobPrefixes(), 'count($results6->getBlobPrefixes())');
    }

    public function testCreatePageBlobWorks()
    {
        // Act
        $this->restProxy->createPageBlob(self::$_test_container_for_blobs, 'test', 512);

        // Assert
        self::assertTrue(true, 'success');
    }

    public function testCreatePageBlobWithOptionsWorks()
    {
        // Act
        $opts = new CreatePageBlobOptions();
        $opts->setContentLanguage('en-us');
        // opts->setContentMD5('1234');
        $opts->setContentType('text/plain');
        $opts->setCacheControl('test');
        $opts->setContentDisposition('test');
        $opts->setContentEncoding('UTF-8');
        $this->restProxy->createPageBlob(self::$_test_container_for_blobs, 'test', 512, $opts);

        $result = $this->restProxy->getBlobProperties(self::$_test_container_for_blobs, 'test');

        // Assert
        self::assertNotNull($result, '$result');

        self::assertNotNull($result->getMetadata(), '$result->getMetadata()');
        self::assertCount(0, $result->getMetadata(), 'count($result->getMetadata())');

        $props = $result->getProperties();
        self::assertNotNull($props, '$props');
        self::assertEquals('test', $props->getCacheControl(), '$props->getCacheControl()');
        self::assertEquals('test', $props->getContentDisposition(), '$props->getContentDisposition()');
        self::assertEquals('UTF-8', $props->getContentEncoding(), '$props->getContentEncoding()');
        self::assertEquals('en-us', $props->getContentLanguage(), '$props->getContentLanguage()');
        self::assertEquals('text/plain', $props->getContentType(), '$props->getContentType()');
        self::assertEquals(512, $props->getContentLength(), '$props->getContentLength()');
        self::assertNotNull($props->getETag(), '$props->getETag()');
        self::assertNull($props->getContentMD5(), '$props->getContentMD5()');
        self::assertNotNull($props->getLastModified(), '$props->getLastModified()');
        self::assertEquals('PageBlob', $props->getBlobType(), '$props->getBlobType()');
        self::assertEquals('unlocked', $props->getLeaseStatus(), '$props->getLeaseStatus()');
        self::assertEquals(0, $props->getSequenceNumber(), '$props->getSequenceNumber()');
    }

    public function testClearBlobPagesWorks()
    {
        // Act
        $container = self::$_test_container_for_blobs;
        $blob = 'test';
        $this->restProxy->createPageBlob($container, $blob, 512);

        $result = $this->restProxy->clearBlobPages($container, $blob, new Range(0, 511));

        // Assert
        self::assertNotNull($result, '$result');
        self::assertNull($result->getContentMD5(), '$result->getContentMD5()');
        self::assertNotNull($result->getLastModified(), '$result->getLastModified()');
        self::assertNotNull($result->getETag(), '$result->getETag()');
        self::assertEquals(0, $result->getSequenceNumber(), '$result->getSequenceNumber()');
    }

    public function testCreateBlobPagesWorks()
    {
        // Act
        $container = self::$_test_container_for_blobs;
        $blob = 'test';
        $content = str_pad('', 512);
        $this->restProxy->createPageBlob($container, $blob, 512);

        $result = $this->restProxy->createBlobPages($container, $blob, new Range(0, 511), $content);

        // Assert
        self::assertNotNull($result, '$result');
        self::assertNotNull($result->getContentMD5(), '$result->getContentMD5()');
        self::assertNotNull($result->getLastModified(), '$result->getLastModified()');
        self::assertNotNull($result->getETag(), '$result->getETag()');
        self::assertEquals(0, $result->getSequenceNumber(), '$result->getSequenceNumber()');
    }

    public function testListBlobRegionsWorks()
    {
        // Act
        $container = self::$_test_container_for_blobs;
        $blob = 'test';
        $content = str_pad('', 512);
        $this->restProxy->createPageBlob($container, $blob, 16384 + 512);

        $this->restProxy->createBlobPages($container, $blob, new Range(0, 511), $content);
        $this->restProxy->createBlobPages($container, $blob, new Range(1024, 1024 + 511), $content);
        $this->restProxy->createBlobPages($container, $blob, new Range(8192, 8192 + 511), $content);
        $this->restProxy->createBlobPages($container, $blob, new Range(16384, 16384 + 511), $content);

        //        $result = $this->restProxy->listBlobRegions($container, $blob);
        $result = $this->restProxy->listPageBlobRanges($container, $blob);

        // Assert
        self::assertNotNull($result, '$result');
        self::assertNotNull($result->getLastModified(), '$result->getLastModified()');
        self::assertNotNull($result->getETag(), '$result->getETag()');
        self::assertEquals(16384 + 512, $result->getContentLength(), '$result->getContentLength()');
        self::assertNotNull($result->getRanges(), '$result->getRanges()');
        self::assertCount(4, $result->getRanges(), 'count($result->getRanges())');
        $ranges = $result->getRanges();
        self::assertEquals(0, $ranges[0]->getStart(), '$ranges[0]->getStart()');
        self::assertEquals(511, $ranges[0]->getEnd(), '$ranges[0]->getEnd()');
        self::assertEquals(1024, $ranges[1]->getStart(), '$ranges[1]->getStart()');
        self::assertEquals(1024 + 511, $ranges[1]->getEnd(), '$ranges[1]->getEnd()');
        self::assertEquals(8192, $ranges[2]->getStart(), '$ranges[2]->getStart()');
        self::assertEquals(8192 + 511, $ranges[2]->getEnd(), '$ranges[2]->getEnd()');
        self::assertEquals(16384, $ranges[3]->getStart(), '$ranges[3]->getStart()');
        self::assertEquals(16384 + 511, $ranges[3]->getEnd(), '$ranges[3]->getEnd()');
    }

    public function testListBlobBlocksOnEmptyBlobWorks()
    {
        // Act
        $container = self::$_test_container_for_blobs;
        $blob = 'test13';
        $content = str_pad('', 512);
        $this->restProxy->createBlockBlob($container, $blob, $content);

        $result = $this->restProxy->listBlobBlocks($container, $blob);

        // Assert
        self::assertNotNull($result, '$result');
        self::assertNotNull($result->getLastModified(), '$result->getLastModified()');
        self::assertNotNull($result->getETag(), '$result->getETag()');
        self::assertEquals(512, $result->getContentLength(), '$result->getContentLength()');
        self::assertNotNull($result->getCommittedBlocks(), '$result->getCommittedBlocks()');
        self::assertCount(0, $result->getCommittedBlocks(), 'count($result->getCommittedBlocks())');
        self::assertNotNull($result->getUncommittedBlocks(), '$result->getUncommittedBlocks()');
        self::assertCount(0, $result->getUncommittedBlocks(), 'count($result->getUncommittedBlocks())');
    }

    public function testListBlobBlocksWorks()
    {
        // Act
        $container = self::$_test_container_for_blobs;
        $blob = 'test14';
        $this->restProxy->createBlockBlob($container, $blob, '');
        $this->restProxy->createBlobBlock($container, $blob, base64_encode('123'), str_pad('', 256));
        $this->restProxy->createBlobBlock($container, $blob, base64_encode('124'), str_pad('', 512));
        $this->restProxy->createBlobBlock($container, $blob, base64_encode('125'), str_pad('', 195));

        $opts = new ListBlobBlocksOptions();
        $opts->setIncludeCommittedBlobs(true);
        $opts->setIncludeUncommittedBlobs(true);
        $result = $this->restProxy->listBlobBlocks($container, $blob, $opts);

        // Assert
        self::assertNotNull($result, '$result');
        self::assertNotNull($result->getLastModified(), '$result->getLastModified()');
        self::assertNotNull($result->getETag(), '$result->getETag()');
        self::assertEquals(0, $result->getContentLength(), '$result->getContentLength()');
        self::assertNotNull($result->getCommittedBlocks(), '$result->getCommittedBlocks()');
        self::assertCount(0, $result->getCommittedBlocks(), 'count($result->getCommittedBlocks())');
        self::assertNotNull($result->getUncommittedBlocks(), '$result->getUncommittedBlocks()');
        self::assertCount(3, $result->getUncommittedBlocks(), 'count($result->getUncommittedBlocks())');
        $uncom = $result->getUncommittedBlocks();
        $keys = array_keys($uncom);
        self::assertEquals(base64_encode('123'), $keys[0], '$keys[0]');
        self::assertEquals(256, $uncom[$keys[0]], '$uncom[$keys[0]]');
        self::assertEquals(base64_encode('124'), $keys[1], '$keys[1]');
        self::assertEquals(512, $uncom[$keys[1]], '$uncom[$keys[1]]');
        self::assertEquals(base64_encode('125'), $keys[2], '$keys[2]');
        self::assertEquals(195, $uncom[$keys[2]], '$uncom[$keys[2]]');
    }

    public function testListBlobBlocksWithOptionsWorks()
    {
        // Act
        $container = self::$_test_container_for_blobs;
        $blob = 'test14';
        $this->restProxy->createBlockBlob($container, $blob, '');
        $this->restProxy->createBlobBlock($container, $blob, base64_encode('123'), str_pad('', 256));

        $blockList = new BlockList();
        $blockList->addUncommittedEntry(base64_encode('123'));
        $this->restProxy->commitBlobBlocks($container, $blob, $blockList);

        $this->restProxy->createBlobBlock($container, $blob, base64_encode('124'), str_pad('', 512));
        $this->restProxy->createBlobBlock($container, $blob, base64_encode('125'), str_pad('', 195));

        $opts = new ListBlobBlocksOptions();
        $opts->setIncludeCommittedBlobs(true);
        $opts->setIncludeUncommittedBlobs(true);
        $result1 = $this->restProxy->listBlobBlocks($container, $blob, $opts);
        $opts = new ListBlobBlocksOptions();
        $opts->setIncludeCommittedBlobs(true);
        $result2 = $this->restProxy->listBlobBlocks($container, $blob, $opts);
        $opts = new ListBlobBlocksOptions();
        $opts->setIncludeUncommittedBlobs(true);
        $result3 = $this->restProxy->listBlobBlocks($container, $blob, $opts);

        // Assert
        self::assertCount(1, $result1->getCommittedBlocks(), 'count($result1->getCommittedBlocks())');
        self::assertCount(2, $result1->getUncommittedBlocks(), 'count($result1->getUncommittedBlocks())');

        self::assertCount(1, $result2->getCommittedBlocks(), 'count($result2->getCommittedBlocks())');
        self::assertCount(0, $result2->getUncommittedBlocks(), 'count($result2->getUncommittedBlocks())');

        self::assertCount(0, $result3->getCommittedBlocks(), 'count($result3->getCommittedBlocks())');
        self::assertCount(2, $result3->getUncommittedBlocks(), 'count($result3->getUncommittedBlocks())');
    }

    public function testCommitBlobBlocksWorks()
    {
        // Act
        $container = self::$_test_container_for_blobs;
        $blob = 'test14';
        $blockId1 = base64_encode('1fedcba');
        $blockId2 = base64_encode('2abcdef');
        $blockId3 = base64_encode('3zzzzzz');
        $this->restProxy->createBlockBlob($container, $blob, '');
        $this->restProxy->createBlobBlock($container, $blob, $blockId1, str_pad('', 256));
        $this->restProxy->createBlobBlock($container, $blob, $blockId2, str_pad('', 512));
        $this->restProxy->createBlobBlock($container, $blob, $blockId3, str_pad('', 195));

        $blockList = new BlockList();
        $blockList->addUncommittedEntry($blockId1);
        $blockList->addLatestEntry($blockId3);

        $this->restProxy->commitBlobBlocks($container, $blob, $blockList);

        $opts = new ListBlobBlocksOptions();
        $opts->setIncludeCommittedBlobs(true);
        $opts->setIncludeUncommittedBlobs(true);
        $result = $this->restProxy->listBlobBlocks($container, $blob, $opts);

        // Assert
        self::assertNotNull($result, '$result');
        self::assertNotNull($result->getLastModified(), '$result->getLastModified()');
        self::assertNotNull($result->getETag(), '$result->getETag()');
        self::assertEquals(256 + 195, $result->getContentLength(), '$result->getContentLength()');

        self::assertNotNull($result->getCommittedBlocks(), '$result->getCommittedBlocks()');
        self::assertCount(2, $result->getCommittedBlocks(), 'count($result->getCommittedBlocks())');
        $comblk = $result->getCommittedBlocks();
        $keys = array_keys($comblk);
        self::assertEquals($blockId1, $keys[0], '$keys[0]');
        self::assertEquals(256, $comblk[$keys[0]], '$comblk[$keys[0]]');
        self::assertEquals($blockId3, $keys[1], '$keys[1]');
        self::assertEquals(195, $comblk[$keys[1]], '$comblk[$keys[1]]');

        self::assertNotNull($result->getUncommittedBlocks(), '$result->getUncommittedBlocks()');
        self::assertCount(0, $result->getUncommittedBlocks(), 'count($result->getUncommittedBlocks())');
    }

    public function testCommitBlobBlocksWithArrayWorks()
    {
        // Act
        $container = self::$_test_container_for_blobs;
        $blob = 'test14a';
        $blockId1 = base64_encode('1fedcba');
        $blockId2 = base64_encode('2abcdef');
        $blockId3 = base64_encode('3zzzzzz');
        $this->restProxy->createBlockBlob($container, $blob, '');
        $this->restProxy->createBlobBlock($container, $blob, $blockId1, str_pad('', 256));
        $this->restProxy->createBlobBlock($container, $blob, $blockId2, str_pad('', 512));
        $this->restProxy->createBlobBlock($container, $blob, $blockId3, str_pad('', 195));

        $block1 = new Block();
        $block1->setBlockId($blockId1);
        $block1->setType(BlobBlockType::UNCOMMITTED_TYPE);
        $block3 = new Block();
        $block3->setBlockId($blockId3);
        $block3->setType(BlobBlockType::LATEST_TYPE);
        $blockList = [$block1, $block3];

        $this->restProxy->commitBlobBlocks($container, $blob, $blockList);

        $opts = new ListBlobBlocksOptions();
        $opts->setIncludeCommittedBlobs(true);
        $opts->setIncludeUncommittedBlobs(true);
        $result = $this->restProxy->listBlobBlocks($container, $blob, $opts);

        // Assert
        self::assertNotNull($result, '$result');
        self::assertNotNull($result->getLastModified(), '$result->getLastModified()');
        self::assertNotNull($result->getETag(), '$result->getETag()');
        self::assertEquals(256 + 195, $result->getContentLength(), '$result->getContentLength()');

        self::assertNotNull($result->getCommittedBlocks(), '$result->getCommittedBlocks()');
        self::assertCount(2, $result->getCommittedBlocks(), 'count($result->getCommittedBlocks())');
        $comblk = $result->getCommittedBlocks();
        $keys = array_keys($comblk);
        self::assertEquals($blockId1, $keys[0], '$keys[0]');
        self::assertEquals(256, $comblk[$keys[0]], '$comblk[$keys[0]]');
        self::assertEquals($blockId3, $keys[1], '$keys[1]');
        self::assertEquals(195, $comblk[$keys[1]], '$comblk[$keys[1]]');

        self::assertNotNull($result->getUncommittedBlocks(), '$result->getUncommittedBlocks()');
        self::assertCount(0, $result->getUncommittedBlocks(), 'count($result->getUncommittedBlocks())');
    }

    public function testCreateBlobBlockWorks()
    {
        // Act
        $container = self::$_test_container_for_blobs;
        $blob = 'test13';
        $content = str_pad('', 512);
        $this->restProxy->createBlockBlob($container, $blob, $content);
        $this->restProxy->createBlobBlock($container, $blob, base64_encode('123'), $content);
        $this->restProxy->createBlobBlock($container, $blob, base64_encode('124'), $content);

        // Assert
        self::assertTrue(true, 'success');
    }

    public function testCreateBlockBlobWorks()
    {
        // Act
        $this->restProxy->createBlockBlob(self::$_test_container_for_blobs, 'test2', 'some content');

        // Assert
        self::assertTrue(true, 'success');
    }

    public function testCreateBlockBlobWithOptionsWorks()
    {
        // Act
        $content = 'some $content';
        $opts = new CreateBlockBlobOptions();
        $opts->setContentEncoding('UTF-8');
        $opts->setContentLanguage('en-us');
        // $opts->setContentMD5('1234');
        $opts->setContentType('text/plain');
        $opts->setCacheControl('test');
        $opts->setContentDisposition('test');
        $opts->setUseTransactionalMD5(true);
        $this->restProxy->createBlockBlob(self::$_test_container_for_blobs, 'test2', $content, $opts);

        $result = $this->restProxy->getBlobProperties(self::$_test_container_for_blobs, 'test2');

        // Assert
        $expectedMD5 = base64_encode(md5($content, true));

        self::assertNotNull($result, '$result');

        self::assertNotNull($result->getMetadata(), '$result->getMetadata()');
        self::assertCount(0, $result->getMetadata(), 'count($result->getMetadata())');

        $props = $result->getProperties();
        self::assertNotNull($props, '$props');
        self::assertEquals('test', $props->getCacheControl(), '$props->getCacheControl()');
        self::assertEquals('test', $props->getContentDisposition(), '$props->getContentDisposition()');
        self::assertEquals('UTF-8', $props->getContentEncoding(), '$props->getContentEncoding()');
        self::assertEquals('en-us', $props->getContentLanguage(), '$props->getContentLanguage()');
        self::assertEquals('text/plain', $props->getContentType(), '$props->getContentType()');
        self::assertEquals(strlen($content), $props->getContentLength(), '$props->getContentLength()');
        self::assertNotNull($props->getETag(), '$props->getETag()');
        self::assertEquals($expectedMD5, $props->getContentMD5(), '$props->getContentMD5()');
        self::assertNotNull($props->getLastModified(), '$props->getLastModified()');
        self::assertEquals('BlockBlob', $props->getBlobType(), '$props->getBlobType()');
        self::assertEquals('unlocked', $props->getLeaseStatus(), '$props->getLeaseStatus()');
        self::assertEquals(0, $props->getSequenceNumber(), '$props->getSequenceNumber()');
    }

    public function testCreateBlobSnapshotWorks()
    {
        // Act
        $container = self::$_test_container_for_blobs;
        $blob = 'test3';
        $this->restProxy->createBlockBlob($container, $blob, 'some content');
        $snapshot = $this->restProxy->createBlobSnapshot($container, $blob);

        // Assert
        self::assertNotNull($snapshot, '$snapshot');
        self::assertNotNull($snapshot->getETag(), '$snapshot->getETag()');
        self::assertNotNull($snapshot->getLastModified(), '$snapshot->getLastModified()');
        self::assertNotNull($snapshot->getSnapshot(), '$snapshot->getSnapshot()');
    }

    public function testCreateBlobSnapshotWithOptionsWorks()
    {
        // Act
        $container = self::$_test_container_for_blobs;
        $blob = 'test3';
        $this->restProxy->createBlockBlob($container, $blob, 'some content');
        $opts = new CreateBlobSnapshotOptions();
        $metadata = [
            'test' => 'bar',
            'blah' => 'bleah'];
        $opts->setMetadata($metadata);
        $snapshot = $this->restProxy->createBlobSnapshot($container, $blob, $opts);

        $opts = new GetBlobPropertiesOptions();
        $opts->setSnapshot($snapshot->getSnapshot());
        $result = $this->restProxy->getBlobProperties($container, $blob, $opts);

        // Assert
        self::assertNotNull($result, '$result');
        self::assertEquals(
            $snapshot->getETag(),
            $result->getProperties()->getETag(),
            '$result->getProperties()->getETag()',
        );
        self::assertEquals(
            $snapshot->getLastModified(),
            $result->getProperties()->getLastModified(),
            '$result->getProperties()->getLastModified()',
        );
        // The capitalizaion gets changed.
        self::assertTrue(
            Utilities::arrayKeyExistsInsensitive('test', $result->getMetadata()),
            'Utilities::arrayKeyExistsInsensitive(\'test\', $result->getMetadata())',
        );
        self::assertTrue(
            !(array_search('bar', $result->getMetadata(), true) === false),
            '!(array_search(\'bar\', $result->getMetadata()) === FALSE)',
        );
        self::assertTrue(
            Utilities::arrayKeyExistsInsensitive(
                'blah',
                $result->getMetadata(),
            ),
            'Utilities::arrayKeyExistsInsensitive(\'blah\', $result->getMetadata())',
        );
        self::assertTrue(
            !(array_search('bleah', $result->getMetadata(), true) === false),
            '!(array_search(\'bleah\', $result->getMetadata()) === FALSE)',
        );
    }

    public function testGetBlockBlobWorks()
    {
        // Act
        $content = 'some $content';
        $opts = new CreateBlockBlobOptions();
        $opts->setCacheControl('test');
        $opts->setContentDisposition('test');
        $opts->setContentEncoding('UTF-8');
        $opts->setContentLanguage('en-us');
        // $opts->setContentMD5('1234');
        $opts->setContentType('text/plain');
        $this->restProxy->createBlockBlob(self::$_test_container_for_blobs, 'test2', $content, $opts);

        $result = $this->restProxy->getBlob(self::$_test_container_for_blobs, 'test2');

        // Assert
        $expectedMD5 = base64_encode(md5($content, true));

        self::assertNotNull($result, '$result');

        self::assertNotNull($result->getMetadata(), '$result->getMetadata()');
        self::assertCount(0, $result->getMetadata(), 'count($result->getMetadata())');

        $props = $result->getProperties();
        self::assertNotNull($props, '$props');
        self::assertEquals('test', $props->getCacheControl(), '$props->getCacheControl()');
        self::assertEquals('test', $props->getContentDisposition(), '$props->getContentDisposition()');
        self::assertEquals('UTF-8', $props->getContentEncoding(), '$props->getContentEncoding()');
        self::assertEquals('en-us', $props->getContentLanguage(), '$props->getContentLanguage()');
        self::assertEquals('text/plain', $props->getContentType(), '$props->getContentType()');
        self::assertEquals(strlen($content), $props->getContentLength(), '$props->getContentLength()');
        self::assertNotNull($props->getETag(), '$props->getETag()');
        self::assertEquals($expectedMD5, $props->getContentMD5(), '$props->getContentMD5()');
        self::assertNotNull($props->getLastModified(), '$props->getLastModified()');
        self::assertEquals('BlockBlob', $props->getBlobType(), '$props->getBlobType()');
        self::assertEquals('unlocked', $props->getLeaseStatus(), '$props->getLeaseStatus()');
        self::assertEquals(0, $props->getSequenceNumber(), '$props->getSequenceNumber()');
        self::assertEquals($content, stream_get_contents($result->getContentStream()), '$result->getContentStream()');
    }

    public function testGetPageBlobWorks()
    {
        // Act
        $opts = new CreatePageBlobOptions();
        $opts->setCacheControl('test');
        $opts->setContentDisposition('test');
        $opts->setContentEncoding('UTF-8');
        $opts->setContentLanguage('en-us');
        // $opts->setContentMD5('1234');
        $opts->setContentType('text/plain');
        $this->restProxy->createPageBlob(self::$_test_container_for_blobs, 'test', 4096, $opts);

        $result = $this->restProxy->getBlob(self::$_test_container_for_blobs, 'test');

        // Assert
        self::assertNotNull($result, '$result');

        self::assertNotNull($result->getMetadata(), '$result->getMetadata()');
        self::assertCount(0, $result->getMetadata(), 'count($result->getMetadata())');

        $props = $result->getProperties();
        self::assertEquals('test', $props->getCacheControl(), '$props->getCacheControl()');
        self::assertEquals('test', $props->getContentDisposition(), '$props->getContentDisposition()');
        self::assertEquals('UTF-8', $props->getContentEncoding(), '$props->getContentEncoding()');
        self::assertEquals('en-us', $props->getContentLanguage(), '$props->getContentLanguage()');
        self::assertEquals('text/plain', $props->getContentType(), '$props->getContentType()');
        self::assertEquals(4096, $props->getContentLength(), '$props->getContentLength()');
        self::assertNotNull($props->getETag(), '$props->getETag()');
        self::assertNull($props->getContentMD5(), '$props->getContentMD5()');
        self::assertNotNull($props->getLastModified(), '$props->getLastModified()');
        self::assertEquals('PageBlob', $props->getBlobType(), '$props->getBlobType()');
        self::assertEquals('unlocked', $props->getLeaseStatus(), '$props->getLeaseStatus()');
        self::assertEquals(0, $props->getSequenceNumber(), '$props->getSequenceNumber()');
        self::assertEquals(
            4096,
            strlen(stream_get_contents($result->getContentStream())),
            'strlen($result->getContentStream())',
        );
    }

    public function testGetBlobWithIfMatchETagAccessConditionWorks()
    {
        // Act
        $this->restProxy->createPageBlob(self::$_test_container_for_blobs, 'test', 4096);
        try {
            $opts = new GetBlobOptions();
            $opts->setAccessConditions(AccessCondition::ifMatch('123'));
            $this->restProxy->getBlob(self::$_test_container_for_blobs, 'test', $opts);
            self::fail('getBlob should throw an exception');
        } catch (ServiceException $e) {
            self::assertEquals(TestResources::STATUS_PRECONDITION_FAILED, $e->getCode(), 'got the expected exception');
        }
    }

    public function testGetBlobWithIfNoneMatchETagAccessConditionWorks()
    {
        // Act
        $this->restProxy->createPageBlob(self::$_test_container_for_blobs, 'test', 4096);
        $props = $this->restProxy->getBlobProperties(self::$_test_container_for_blobs, 'test');
        try {
            $opts = new GetBlobOptions();
            $opts->setAccessConditions(AccessCondition::ifNoneMatch($props->getProperties()->getETag()));
            $this->restProxy->getBlob(self::$_test_container_for_blobs, 'test', $opts);
            self::fail('getBlob should throw an exception');
        } catch (ServiceException $e) {
            if (!$this->hasSecureEndpoint() && $e->getCode() == TestResources::STATUS_FORBIDDEN) {
                // Proxies can eat the access condition headers of
                // unsecured (http) requests, which causes the authentication
                // to fail, with a 403:Forbidden. There is nothing much that
                // can be done about this, other than ignore it.
                self::markTestSkipped('Appears that a proxy ate your access condition');
            } else {
                self::assertEquals(TestResources::STATUS_NOT_MODIFIED, $e->getCode(), 'got the expected exception');
            }
        }
    }

    public function testGetBlobWithIfModifiedSinceAccessConditionWorks()
    {
        // Act
        $this->restProxy->createPageBlob(self::$_test_container_for_blobs, 'test', 4096);
        $props = $this->restProxy->getBlobProperties(self::$_test_container_for_blobs, 'test');
        try {
            $opts = new GetBlobOptions();
            $lastMod = $props->getProperties()->getLastModified();
            $opts->setAccessConditions(AccessCondition::ifModifiedSince($lastMod));
            $this->restProxy->getBlob(self::$_test_container_for_blobs, 'test', $opts);
            self::fail('getBlob should throw an exception');
        } catch (ServiceException $e) {
            if (!$this->hasSecureEndpoint() && $e->getCode() == TestResources::STATUS_FORBIDDEN) {
                // Proxies can eat the access condition headers of
                // unsecured (http) requests, which causes the authentication
                // to fail, with a 403:Forbidden. There is nothing much that
                // can be done about this, other than ignore it.
                self::markTestSkipped('Appears that a proxy ate your access condition');
            } else {
                self::assertEquals(TestResources::STATUS_NOT_MODIFIED, $e->getCode(), 'got the expected exception');
            }
        }
    }

    public function testGetBlobWithIfNotModifiedSinceAccessConditionWorks()
    {
        // Act
        $container = self::$_test_container_for_blobs;
        $blob = 'test';
        $this->restProxy->createPageBlob($container, $blob, 4096);
        $props = $this->restProxy->getBlobProperties($container, $blob);

        // To test for "IfNotModifiedSince", we need to make updates to the blob
        // until at least 1 second has passed since the blob creation
        $lastModifiedBase = $props->getProperties()->getLastModified();

        // +1 second
        $lastModifiedNext = clone $lastModifiedBase;
        $lastModifiedNext = $lastModifiedNext->modify('+1 sec');

        while (true) {
            $metadata = ['test' => 'test1'];
            $result = $this->restProxy->setBlobMetadata($container, $blob, $metadata);
            if ($result->getLastModified() >= $lastModifiedNext) {
                break;
            }
        }
        try {
            $opts = new GetBlobOptions();
            $opts->setAccessConditions(AccessCondition::ifNotModifiedSince($lastModifiedBase));
            $this->restProxy->getBlob($container, $blob, $opts);
            self::fail('getBlob should throw an exception');
        } catch (ServiceException $e) {
            self::assertEquals(TestResources::STATUS_PRECONDITION_FAILED, $e->getCode(), 'got the expected exception');
        }
    }

    public function testGetBlobPropertiesWorks()
    {
        // Act
        $container = self::$_test_container_for_blobs;
        $blob = 'test';
        $this->restProxy->createPageBlob($container, $blob, 4096);
        $result = $this->restProxy->getBlobProperties($container, $blob);

        // Assert
        self::assertNotNull($result, '$result');

        self::assertNotNull($result->getMetadata(), '$result->getMetadata()');
        self::assertCount(0, $result->getMetadata(), 'count($result->getMetadata())');

        $props = $result->getProperties();
        self::assertNotNull($props, '$props');
        self::assertNull($props->getCacheControl(), '$props->getCacheControl()');
        self::assertNull($props->getContentEncoding(), '$props->getContentEncoding()');
        self::assertNull($props->getContentLanguage(), '$props->getContentLanguage()');
        self::assertEquals('application/octet-stream', $props->getContentType(), '$props->getContentType()');
        self::assertEquals(4096, $props->getContentLength(), '$props->getContentLength()');
        self::assertNotNull($props->getETag(), '$props->getETag()');
        self::assertNull($props->getContentMD5(), '$props->getContentMD5()');
        self::assertNotNull($props->getLastModified(), '$props->getLastModified()');
        self::assertEquals('PageBlob', $props->getBlobType(), '$props->getBlobType()');
        self::assertEquals('unlocked', $props->getLeaseStatus(), '$props->getLeaseStatus()');
        self::assertEquals(0, $props->getSequenceNumber(), '$props->getSequenceNumber()');
    }

    public function testGetBlobMetadataWorks()
    {
        // Act
        $container = self::$_test_container_for_blobs;
        $blob = 'test';
        $opts = new CreatePageBlobOptions();
        $metadata = $opts->getMetadata();
        $metadata['test'] = 'bar';
        $metadata['blah'] = 'bleah';
        $opts->setMetadata($metadata);
        $this->restProxy->createPageBlob($container, $blob, 4096, $opts);
        $props = $this->restProxy->getBlobMetadata($container, $blob);

        // Assert
        self::assertNotNull($props, '$props');
        self::assertNotNull($props->getETag(), '$props->getETag()');
        self::assertNotNull($props->getMetadata(), '$props->getMetadata()');
        self::assertCount(2, $props->getMetadata(), 'count($props->getMetadata())');
        self::assertTrue(
            Utilities::arrayKeyExistsInsensitive(
                'test',
                $props->getMetadata(),
            ),
            'Utilities::arrayKeyExistsInsensitive(\'test\', $props->getMetadata())',
        );
        self::assertTrue(
            !(array_search('bar', $props->getMetadata(), true) === false),
            '!(array_search(\'bar\', $props->getMetadata()) === FALSE)',
        );
        self::assertTrue(
            Utilities::arrayKeyExistsInsensitive('blah', $props->getMetadata()),
            'Utilities::arrayKeyExistsInsensitive(\'blah\', $props->getMetadata())',
        );
        self::assertTrue(
            !(array_search('bleah', $props->getMetadata(), true) === false),
            '!(array_search(\'bleah\', $props->getMetadata()) === FALSE)',
        );
        self::assertNotNull($props->getLastModified(), '$props->getLastModified()');
    }

    public function testSetBlobPropertiesWorks()
    {
        // Act
        $container = self::$_test_container_for_blobs;
        $blob = 'test10';
        $this->restProxy->createPageBlob($container, $blob, 4096);
        $opts = new SetBlobPropertiesOptions();
        $opts->setCacheControl('test');
        $opts->setContentDisposition('test');
        $opts->setContentEncoding('UTF-8');
        $opts->setContentLanguage('en-us');
        $opts->setContentLength(512);
        $opts->setContentMD5(null);
        $opts->setContentType('text/plain');
        $opts->setSequenceNumberAction('increment');
        $result = $this->restProxy->setBlobProperties($container, $blob, $opts);

        $getResult = $this->restProxy->getBlobProperties($container, $blob);

        // Assert
        self::assertNotNull($result, '$result');
        self::assertNotNull($result->getETag(), '$result->getETag()');
        self::assertNotNull($result->getLastModified(), '$result->getLastModified()');
        self::assertNotNull($result->getSequenceNumber(), '$result->getSequenceNumber()');
        self::assertEquals(1, $result->getSequenceNumber(), '$result->getSequenceNumber()');

        self::assertNotNull($getResult, '$getResult');

        self::assertNotNull($getResult->getMetadata(), '$getResult->getMetadata()');
        self::assertCount(0, $getResult->getMetadata(), 'count($getResult->getMetadata())');

        $props = $getResult->getProperties();
        self::assertNotNull($props, '$props');
        self::assertEquals('test', $props->getCacheControl(), '$props->getCacheControl()');
        self::assertEquals('test', $props->getContentDisposition(), '$props->getContentDisposition()');
        self::assertEquals('UTF-8', $props->getContentEncoding(), '$props->getContentEncoding()');
        self::assertEquals('en-us', $props->getContentLanguage(), '$props->getContentLanguage()');
        self::assertEquals('text/plain', $props->getContentType(), '$props->getContentType()');
        self::assertEquals(512, $props->getContentLength(), '$props->getContentLength()');
        self::assertNull($props->getContentMD5(), '$props->getContentMD5()');
        self::assertNotNull($props->getLastModified(), '$props->getLastModified()');
        self::assertEquals('PageBlob', $props->getBlobType(), '$props->getBlobType()');
        self::assertEquals('unlocked', $props->getLeaseStatus(), '$props->getLeaseStatus()');
        self::assertEquals(1, $props->getSequenceNumber(), '$props->getSequenceNumber()');
    }

    public function testSetBlobMetadataWorks()
    {
        // Act
        $container = self::$_test_container_for_blobs;
        $blob = 'test11';
        $metadata = [
            'test' => 'bar',
            'blah' => 'bleah'];

        $this->restProxy->createPageBlob($container, $blob, 4096);
        $result = $this->restProxy->setBlobMetadata($container, $blob, $metadata);
        $props = $this->restProxy->getBlobProperties($container, $blob);

        // Assert
        self::assertNotNull($result, '$result');
        self::assertNotNull($result->getETag(), '$result->getETag()');
        self::assertNotNull($result->getLastModified(), '$result->getLastModified()');

        self::assertNotNull($props, '$props');
        self::assertNotNull($props->getMetadata(), '$props->getMetadata()');
        self::assertCount(2, $props->getMetadata(), 'count($props->getMetadata())');
        self::assertTrue(
            Utilities::arrayKeyExistsInsensitive('test', $props->getMetadata()),
            'Utilities::arrayKeyExistsInsensitive(\'test\', $props->getMetadata())',
        );
        self::assertTrue(
            !(array_search('bar', $props->getMetadata(), true) === false),
            '!(array_search(\'bar\', $props->getMetadata()) === FALSE)',
        );
        self::assertTrue(
            Utilities::arrayKeyExistsInsensitive('blah', $props->getMetadata()),
            'Utilities::arrayKeyExistsInsensitive(\'blah\', $props->getMetadata())',
        );
        self::assertTrue(
            !(array_search('bleah', $props->getMetadata(), true) === false),
            '!(array_search(\'bleah\', $props->getMetadata()) === FALSE)',
        );
    }

    public function testDeleteBlobWorks()
    {
        // Act
        $content = 'some $content';
        $this->restProxy->createBlockBlob(self::$_test_container_for_blobs, 'test2', $content);

        $this->restProxy->deleteBlob(self::$_test_container_for_blobs, 'test2');

        // Assert
        self::assertTrue(true, 'success');
    }

    public function testCopyBlobWorks()
    {
        // Act
        $content = 'some content2';
        $this->restProxy->createBlockBlob(self::$_test_container_for_blobs, 'test6', $content);
        $this->restProxy->copyBlob(
            self::$_test_container_for_blobs_2,
            'test5',
            self::$_test_container_for_blobs,
            'test6',
        );

        $result = $this->restProxy->getBlob(self::$_test_container_for_blobs_2, 'test5');

        // Assert
        $expectedMD5 = base64_encode(md5($content, true));

        self::assertNotNull($result, '$result');

        self::assertNotNull($result->getMetadata(), '$result->getMetadata()');
        self::assertCount(0, $result->getMetadata(), 'count($result->getMetadata())');

        $props = $result->getProperties();
        self::assertNotNull($props, '$props');
        self::assertEquals(strlen($content), $props->getContentLength(), '$props->getContentLength()');
        self::assertNotNull($props->getETag(), '$props->getETag()');
        self::assertEquals($expectedMD5, $props->getContentMD5(), '$props->getContentMD5()');
        self::assertNotNull($props->getLastModified(), '$props->getLastModified()');
        self::assertEquals('BlockBlob', $props->getBlobType(), '$props->getBlobType()');
        self::assertEquals('unlocked', $props->getLeaseStatus(), '$props->getLeaseStatus()');
        self::assertEquals(0, $props->getSequenceNumber(), '$props->getSequenceNumber()');
        self::assertEquals($content, stream_get_contents($result->getContentStream()), '$result->getContentStream()');
    }

    public function testAcquireLeaseWorks()
    {
        // Act
        $content = 'some content2';
        $this->restProxy->createBlockBlob(self::$_test_container_for_blobs, 'test6', $content);
        $leaseId = $this->restProxy->acquireLease(self::$_test_container_for_blobs, 'test6')->getLeaseId();
        $this->restProxy->releaseLease(self::$_test_container_for_blobs, 'test6', $leaseId);

        // Assert
        self::assertNotNull($leaseId, '$leaseId');
    }

    public function testRenewLeaseWorks()
    {
        // Act
        $content = 'some content2';
        $this->restProxy->createBlockBlob(self::$_test_container_for_blobs, 'test6', $content);
        $leaseId = $this->restProxy->acquireLease(self::$_test_container_for_blobs, 'test6')->getLeaseId();
        $leaseId2 = $this->restProxy->renewLease(self::$_test_container_for_blobs, 'test6', $leaseId)->getLeaseId();
        $this->restProxy->releaseLease(self::$_test_container_for_blobs, 'test6', $leaseId);

        // Assert
        self::assertNotNull($leaseId, '$leaseId');
        self::assertNotNull($leaseId2, '$leaseId2');
    }

    public function testBreakLeaseWorks()
    {
        // Act
        $content = 'some content2';
        $this->restProxy->createBlockBlob(self::$_test_container_for_blobs, 'test6', $content);
        $leaseId = $this->restProxy->acquireLease(self::$_test_container_for_blobs, 'test6')->getLeaseId();
        $this->restProxy->breakLease(self::$_test_container_for_blobs, 'test6');
        $this->restProxy->releaseLease(self::$_test_container_for_blobs, 'test6', $leaseId);

        // Assert
        self::assertNotNull($leaseId, '$leaseId');
    }
}

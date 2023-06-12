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

namespace MicrosoftAzure\Storage\Tests\Functional\Blob;

use MicrosoftAzure\Storage\Blob\BlobRestProxy;
use MicrosoftAzure\Storage\Blob\Models\SetBlobTierOptions;
use MicrosoftAzure\Storage\Tests\Framework\TestResources;

/**
 * Tests for a blob storage account, such as block blob tier.
 *
 * @see      https://github.com/azure/azure-storage-php
 */
class BlobStorageAccountFunctionalTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var BlobRestProxy
     */
    private static $blobRestProxy;
    private static $accountName;
    private $containerName;

    protected function setUp()
    {
        parent::setUp();

        try {
            $connectionString = TestResources::getWindowsAzureStorageServicesBlobAccountConnectionString();
        } catch (\Exception $e) {
            self::markTestSkipped('Environment string AZURE_STORAGE_CONNECTION_STRING_BLOB_ACCOUNT is not provided.\
                                    Skip blob account required test cases.');
        }

        self::$blobRestProxy = BlobRestProxy::createBlobService($connectionString);
        self::$accountName = self::$blobRestProxy->getAccountName();
        $this->containerName = TestResources::getInterestingName('con');
        self::$blobRestProxy->createContainer($this->containerName);
    }

    protected function tearDown()
    {
        if (self::$blobRestProxy) {
            self::$blobRestProxy->deleteContainer($this->containerName);
        }
        parent::tearDown();
    }

    public function testSetBlobTier()
    {
        $blob = TestResources::getInterestingName('b');
        self::$blobRestProxy->createblockblob($this->containerName, $blob, "");

        $properties = self::$blobRestProxy->getBlobProperties($this->containerName, $blob);
        self::assertNotNull($properties->getProperties()->getAccessTier());
        self::assertTrue($properties->getProperties()->getAccessTierInferred());
        self::assertNull($properties->getProperties()->getArchiveStatus());
        self::assertNull($properties->getProperties()->getAccessTierChangeTime());

        $options = new SetBlobTierOptions();
        $options->setAccessTier('Cool');
        self::$blobRestProxy->setBlobTier($this->containerName, $blob, $options);

        $properties = self::$blobRestProxy->getBlobProperties($this->containerName, $blob);
        self::assertEquals($options->getAccessTier(), $properties->getProperties()->getAccessTier());
        self::assertNull($properties->getProperties()->getAccessTierInferred());
        self::assertNull($properties->getProperties()->getArchiveStatus());
        self::assertNotNull($properties->getProperties()->getAccessTierChangeTime());

        $blobs = self::$blobRestProxy->listblobs($this->containerName);
        self::assertEquals($options->getAccessTier(), $blobs->getBlobs()[0]->getProperties()->getAccessTier());
        self::assertNull($blobs->getBlobs()[0]->getProperties()->getAccessTierInferred());
        self::assertNull($blobs->getBlobs()[0]->getProperties()->getArchiveStatus());
        self::assertNotNull($blobs->getBlobs()[0]->getProperties()->getAccessTierChangeTime());

        $options = new SetBlobTierOptions();
        $options->setAccessTier('Hot');
        self::$blobRestProxy->setBlobTier($this->containerName, $blob, $options);

        $properties = self::$blobRestProxy->getBlobProperties($this->containerName, $blob);
        self::assertEquals($options->getAccessTier(), $properties->getProperties()->getAccessTier());
        self::assertNull($properties->getProperties()->getAccessTierInferred());
        self::assertNull($properties->getProperties()->getArchiveStatus());
        self::assertNotNull($properties->getProperties()->getAccessTierChangeTime());

        $blobs = self::$blobRestProxy->listblobs($this->containerName);
        self::assertEquals($options->getAccessTier(), $blobs->getBlobs()[0]->getProperties()->getAccessTier());
        self::assertNull($blobs->getBlobs()[0]->getProperties()->getAccessTierInferred());
        self::assertNull($blobs->getBlobs()[0]->getProperties()->getArchiveStatus());
        self::assertNotNull($blobs->getBlobs()[0]->getProperties()->getAccessTierChangeTime());

        $options = new SetBlobTierOptions();
        $options->setAccessTier('Archive');
        self::$blobRestProxy->setBlobTier($this->containerName, $blob, $options);

        $properties = self::$blobRestProxy->getBlobProperties($this->containerName, $blob);
        self::assertEquals($options->getAccessTier(), $properties->getProperties()->getAccessTier());
        self::assertNull($properties->getProperties()->getAccessTierInferred());
        self::assertNull($properties->getProperties()->getArchiveStatus());
        self::assertNotNull($properties->getProperties()->getAccessTierChangeTime());

        $blobs = self::$blobRestProxy->listblobs($this->containerName);
        self::assertEquals($options->getAccessTier(), $blobs->getBlobs()[0]->getProperties()->getAccessTier());
        self::assertNull($blobs->getBlobs()[0]->getProperties()->getAccessTierInferred());
        self::assertNull($blobs->getBlobs()[0]->getProperties()->getArchiveStatus());
        self::assertNotNull($blobs->getBlobs()[0]->getProperties()->getAccessTierChangeTime());

        $options = new SetBlobTierOptions();
        $options->setAccessTier('Hot');
        self::$blobRestProxy->setBlobTier($this->containerName, $blob, $options);

        $properties = self::$blobRestProxy->getBlobProperties($this->containerName, $blob);
        self::assertNotEquals($options->getAccessTier(), $properties->getProperties()->getAccessTier());
        self::assertNull($properties->getProperties()->getAccessTierInferred());
        self::assertEquals('rehydrate-pending-to-hot', $properties->getProperties()->getArchiveStatus());
        self::assertNotNull($properties->getProperties()->getAccessTierChangeTime());

        $blobs = self::$blobRestProxy->listblobs($this->containerName);
        self::assertNotNull($options->getAccessTier(), $blobs->getBlobs()[0]->getProperties()->getAccessTier());
        self::assertNull($blobs->getBlobs()[0]->getProperties()->getAccessTierInferred());
        self::assertEquals('rehydrate-pending-to-hot', $blobs->getBlobs()[0]->getProperties()->getArchiveStatus());
        self::assertNotNull($blobs->getBlobs()[0]->getProperties()->getAccessTierChangeTime());
    }
}

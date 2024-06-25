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

use AzureOSS\Storage\Blob\BlobRestProxy;
use AzureOSS\Storage\Blob\Models\PublicAccessType;
use AzureOSS\Storage\Common\Internal\Resources;
use AzureOSS\Storage\Tests\Framework\TestResources;

/**
 * Tests for account SAS proxy tests.
 *
 * @see      https://github.com/azure/azure-storage-php
 */
class AnonymousAccessFunctionalTest extends \PHPUnit\Framework\TestCase
{
    private $containerName;
    private static $blobRestProxy;
    private static $accountName;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        $connectionString = TestResources::getWindowsAzureStorageServicesConnectionString();
        self::$blobRestProxy = BlobRestProxy::createBlobService($connectionString);
        self::$accountName = self::$blobRestProxy->getAccountName();
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->containerName = TestResources::getInterestingName('con');
        self::$blobRestProxy->createContainer($this->containerName);
    }

    protected function tearDown(): void
    {
        self::$blobRestProxy->deleteContainer($this->containerName);
        parent::tearDown();
    }

    public function testPublicAccessContainerAndBlob()
    {
        $acl = self::$blobRestProxy->getContainerAcl($this->containerName)->getContainerAcl();
        $acl->setPublicAccess(PublicAccessType::CONTAINER_AND_BLOBS);
        self::$blobRestProxy->setContainerAcl($this->containerName, $acl);

        $pEndpoint = sprintf(
            '%s://%s.%s',
            Resources::HTTPS_SCHEME,
            self::$accountName,
            Resources::BLOB_BASE_DNS_NAME,
        );

        $proxy = BlobRestProxy::createContainerAnonymousAccess(
            $pEndpoint,
        );

        $result = $proxy->listBlobs($this->containerName);

        self::assertCount(0, $result->getBlobs());

        $blob = TestResources::getInterestingName('b');
        self::$blobRestProxy->createPageBlob($this->containerName, $blob, 512);
        $result = $proxy->listBlobs($this->containerName);
        self::assertCount(1, $result->getBlobs());
        self::$blobRestProxy->deleteBlob($this->containerName, $blob);
        $result = $proxy->listBlobs($this->containerName);
        self::assertCount(0, $result->getBlobs());
    }

    public function testPublicAccessBlobOnly()
    {
        $this->expectException(\AzureOSS\Storage\Common\Exceptions\ServiceException::class);
        $this->expectExceptionMessage('404');

        $acl = self::$blobRestProxy->getContainerAcl($this->containerName)->getContainerAcl();
        $acl->setPublicAccess(PublicAccessType::BLOBS_ONLY);
        self::$blobRestProxy->setContainerAcl($this->containerName, $acl);

        $pHost = self::$accountName . '.' . Resources::BLOB_BASE_DNS_NAME;
        $sHost = self::$accountName . '-secondary' . '.' . Resources::BLOB_BASE_DNS_NAME;
        $scheme = Resources::HTTPS_SCHEME;

        $pEndpoint = sprintf(
            '%s://%s.%s',
            Resources::HTTPS_SCHEME,
            self::$accountName,
            Resources::BLOB_BASE_DNS_NAME,
        );

        $proxy = BlobRestProxy::createContainerAnonymousAccess(
            $pEndpoint,
        );

        $result = self::$blobRestProxy->listBlobs($this->containerName);
        self::assertCount(0, $result->getBlobs());
        $blob = TestResources::getInterestingName('b');
        self::$blobRestProxy->createBlockBlob($this->containerName, $blob, 'test content');
        $result = self::$blobRestProxy->listBlobs($this->containerName);
        self::assertCount(1, $result->getBlobs());
        $content = stream_get_contents($proxy->getBlob($this->containerName, $blob)->getContentStream());
        self::assertEquals('test content', $content);
        self::$blobRestProxy->deleteBlob($this->containerName, $blob);
        $result = self::$blobRestProxy->listBlobs($this->containerName);
        self::assertCount(0, $result->getBlobs());
        //The following line will generate ServiceException with 404.
        $result = $proxy->listBlobs($this->containerName);
    }
}

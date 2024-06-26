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

namespace AzureOSS\Storage\Tests\Unit\File;

use AzureOSS\Storage\Common\Internal\Resources;
use AzureOSS\Storage\Common\Models\Range;
use AzureOSS\Storage\Common\Models\ServiceProperties;
use AzureOSS\Storage\File\FileRestProxy;
use AzureOSS\Storage\File\Internal\IFile;
use AzureOSS\Storage\File\Models\CreateDirectoryOptions;
use AzureOSS\Storage\File\Models\CreateFileFromContentOptions;
use AzureOSS\Storage\File\Models\ListDirectoriesAndFilesOptions;
use AzureOSS\Storage\File\Models\ShareACL;
use AzureOSS\Storage\Tests\Framework\FileServiceRestProxyTestBase;
use AzureOSS\Storage\Tests\Framework\TestResources;

/**
 * Unit tests for class FileRestProxy
 *
 * @see      https://github.com/azure/azure-storage-php
 */
class FileRestProxyTest extends FileServiceRestProxyTestBase
{
    private function createSuffix()
    {
        return sprintf('-%04x', mt_rand(0, 65535));
    }

    public function testBuildForFile()
    {
        // Test
        $fileRestProxy = FileRestProxy::createFileService(TestResources::getWindowsAzureStorageServicesConnectionString());

        // Assert
        self::assertInstanceOf(IFile::class, $fileRestProxy);
    }

    public function testSetServiceProperties()
    {
        $this->skipIfEmulated();

        // Setup
        $expected = ServiceProperties::create(TestResources::setFileServicePropertiesSample());

        // Test
        $this->setServiceProperties($expected);
        //Add 30s interval to wait for setting to take effect.
        \sleep(30);
        $actual = $this->restProxy->getServiceProperties();

        // Assert
        self::assertEquals($expected->toXml($this->xmlSerializer), $actual->getValue()->toXml($this->xmlSerializer));
    }

    public function testCreateListShare()
    {
        $share1 = 'mysharessimple1' . $this->createSuffix();
        $share2 = 'mysharessimple2' . $this->createSuffix();
        $share3 = 'mysharessimple3' . $this->createSuffix();

        $this->createShare($share1);
        $this->createShare($share2);
        $this->createShare($share3);

        $result = $this->restProxy->listShares();

        //Assert
        $shares = $result->getShares();
        $shareNames = [];
        foreach ($shares as $share) {
            $shareNames[] = $share->getName();
        }
        self::assertTrue(\in_array($share1, $shareNames, true));
        self::assertTrue(\in_array($share2, $shareNames, true));
        self::assertTrue(\in_array($share3, $shareNames, true));
    }

    public function testGetSetShareMetadataAndProperties()
    {
        $this->expectException(\AzureOSS\Storage\Common\Exceptions\ServiceException::class);
        $this->expectExceptionMessage('400');

        $share1 = 'metaproperties1' . $this->createSuffix();
        $share2 = 'metaproperties2' . $this->createSuffix();
        $share3 = 'metaproperties3' . $this->createSuffix();

        $this->createShare($share1);
        $this->createShare($share2);
        $this->createShare($share3);

        $expected1 = ['name1' => 'MyName1', 'mymetaname' => '12345'];
        $expected2 = 5120;
        $expected3 = 5121;

        $this->restProxy->setShareMetadata($share1, $expected1);
        $this->restProxy->setShareProperties($share2, $expected2);

        $result1 = $this->restProxy->getShareMetadata($share1);
        $result2 = $this->restProxy->getShareProperties($share2);

        self::assertEquals($expected1, $result1->getMetadata());
        self::assertEquals(5120, $result2->getQuota());

        $this->restProxy->setShareProperties($share3, $expected3);
    }

    public function testGetSetShareAcl()
    {
        $share = 'shareacl' . $this->createSuffix();
        $this->createShare($share);
        $sample = TestResources::getShareAclMultipleEntriesSample();
        $expectedETag = '0x8CAFB82EFF70C46';
        $expectedLastModified = new \DateTime('Sun, 25 Sep 2011 19:42:18 GMT');
        $acl = ShareACL::create($sample['SignedIdentifiers']);

        // Test
        $this->restProxy->setShareAcl($share, $acl);

        // Assert
        $actual = $this->restProxy->getShareAcl($share);
        self::assertEquals($acl->getSignedIdentifiers(), $actual->getShareAcl()->getSignedIdentifiers());
    }

    public function testGetShareStats()
    {
        $share = 'sharestats' . $this->createSuffix();
        $this->createShare($share);

        $result = $this->restProxy->getShareStats($share);

        self::assertEquals(0, $result->getShareUsage());
    }

    public function testListDirectoriesAndFilesWithNull()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('can\'t be NULL.');

        $this->restProxy->listDirectoriesAndFiles(null);
    }

    public function testListDirectoriesAndFiles()
    {
        $share = 'listdirectoriesandfiles' . $this->createSuffix();
        $this->createShare($share);

        $testdirectory0 = 'testdirectory0';
        $testdirectory1 = $testdirectory0 . '/' . 'testdirectory1';
        $testdirectory2 = $testdirectory0 . '/' . 'testdirectory2';
        $testfile0 = 'testfile0';
        $testfile1 = $testdirectory0 . '/' . 'testfile1';
        $testfile2 = $testdirectory1 . '/' . 'testfile2';
        $testfile3 = $testdirectory1 . '/' . 'testfile3';
        $testfile4 = $testdirectory1 . '/' . 'testfile4';
        $testfile5 = $testdirectory1 . '/' . 'testfile5';
        $testfile6 = $testdirectory1 . '/' . 'testfile6';
        $testfile7 = $testdirectory1 . '/' . 'testfile7';

        $this->restProxy->createDirectory($share, $testdirectory0);
        $this->restProxy->createDirectory($share, $testdirectory1);
        $this->restProxy->createDirectory($share, $testdirectory2);

        $this->restProxy->createFile(
            $share,
            $testfile0,
            Resources::MB_IN_BYTES_4
        );
        $this->restProxy->createFile(
            $share,
            $testfile1,
            Resources::MB_IN_BYTES_4
        );
        $this->restProxy->createFile(
            $share,
            $testfile2,
            Resources::MB_IN_BYTES_4
        );
        $this->restProxy->createFile(
            $share,
            $testfile3,
            Resources::MB_IN_BYTES_4
        );
        $this->restProxy->createFile(
            $share,
            $testfile4,
            Resources::MB_IN_BYTES_4
        );
        $this->restProxy->createFile(
            $share,
            $testfile5,
            Resources::MB_IN_BYTES_4
        );
        $this->restProxy->createFile(
            $share,
            $testfile6,
            Resources::MB_IN_BYTES_4
        );
        $this->restProxy->createFile(
            $share,
            $testfile7,
            Resources::MB_IN_BYTES_4
        );

        $result = $this->restProxy->listDirectoriesAndFiles($share);
        $result0 = $this->restProxy->listDirectoriesAndFiles($share, $testdirectory0);
        $result1 = $this->restProxy->listDirectoriesAndFiles($share, $testdirectory1);
        $result2 = $this->restProxy->listDirectoriesAndFiles($share, $testdirectory2);

        $validator = static function ($resources, $target) {
            $result = false;
            foreach ($resources as $resource) {
                if ($resource->getName() == $target) {
                    $result = true;
                    break;
                }
            }
            return $result;
        };

        self::assertTrue($validator($result->getDirectories(), 'testdirectory0'));
        self::assertTrue($validator($result->getFiles(), 'testfile0'));
        self::assertTrue($validator($result0->getDirectories(), 'testdirectory1'));
        self::assertTrue($validator($result0->getDirectories(), 'testdirectory2'));
        self::assertTrue($validator($result0->getFiles(), 'testfile1'));
        self::assertTrue($validator($result1->getFiles(), 'testfile2'));
        self::assertTrue($validator($result1->getFiles(), 'testfile3'));
        self::assertTrue($validator($result1->getFiles(), 'testfile4'));
        self::assertTrue($validator($result1->getFiles(), 'testfile5'));
        self::assertTrue($validator($result1->getFiles(), 'testfile6'));
        self::assertTrue($validator($result1->getFiles(), 'testfile7'));
    }

    public function testListDirectoriesAndFilesWithPrefix()
    {
        $share = 'listdirectoriesandfileswithprefix' . $this->createSuffix();
        $this->createShare($share);

        /*
         * share
         * share/dir_0
         * share/dir_1
         * share/dir_1/file_10
         * share/dir_1/file_11
         * share/dir_1/dir_10
         * share/dir_2
         * share/folder_3
         * share/file_0
         * share/file_1
         * share/doc_2
         */
        $dir0 = 'dir_0';
        $dir1 = 'dir_1';
        $file10 = "$dir1/file_10";
        $file11 = "$dir1/file_11";
        $dir10 = "$dir1/dir_10";
        $dir2 = 'dir_2';
        $folder3 = 'folder_3';
        $file0 = 'file_0';
        $file1 = 'file_1';
        $doc2 = 'doc_2';

        $this->restProxy->createDirectory($share, $dir0);
        $this->restProxy->createDirectory($share, $dir1);
        $this->restProxy->createDirectory($share, $dir2);
        $this->restProxy->createDirectory($share, $folder3);
        $this->restProxy->createDirectory($share, $dir10);

        $this->restProxy->createFile(
            $share,
            $file0,
            Resources::MB_IN_BYTES_4
        );
        $this->restProxy->createFile(
            $share,
            $file1,
            Resources::MB_IN_BYTES_4
        );
        $this->restProxy->createFile(
            $share,
            $doc2,
            Resources::MB_IN_BYTES_4
        );
        $this->restProxy->createFile(
            $share,
            $file10,
            Resources::MB_IN_BYTES_4
        );
        $this->restProxy->createFile(
            $share,
            $file11,
            Resources::MB_IN_BYTES_4
        );

        $optionsDirPrefix = new ListDirectoriesAndFilesOptions();
        $optionsDirPrefix->setPrefix('dir');

        $optionsFilePrefix = new ListDirectoriesAndFilesOptions();
        $optionsFilePrefix->setPrefix('file');

        $resultRootDir = $this->restProxy->listDirectoriesAndFiles($share, '', $optionsDirPrefix);
        $resultRootFile = $this->restProxy->listDirectoriesAndFiles($share, '', $optionsFilePrefix);
        $resultDir = $this->restProxy->listDirectoriesAndFiles($share, $dir1, $optionsDirPrefix);
        $resultFile = $this->restProxy->listDirectoriesAndFiles($share, $dir1, $optionsFilePrefix);

        $validator = static function ($resources, $target) {
            $result = false;
            foreach ($resources as $resource) {
                if ($resource->getName() == $target) {
                    $result = true;
                    break;
                }
            }
            return $result;
        };

        self::assertCount(3, $resultRootDir->getDirectories());
        self::assertCount(2, $resultRootFile->getFiles());
        self::assertCount(1, $resultDir->getDirectories());
        self::assertCount(2, $resultFile->getFiles());

        self::assertTrue($validator($resultRootDir->getDirectories(), $dir0));
        self::assertTrue($validator($resultRootDir->getDirectories(), $dir1));
        self::assertTrue($validator($resultRootDir->getDirectories(), $dir2));
        self::assertTrue($validator($resultDir->getDirectories(), 'dir_10'));

        self::assertTrue($validator($resultRootFile->getFiles(), $file0));
        self::assertTrue($validator($resultRootFile->getFiles(), $file1));
        self::assertTrue($validator($resultFile->getFiles(), 'file_10'));
        self::assertTrue($validator($resultFile->getFiles(), 'file_11'));
    }

    public function testCreateDeleteDirectory()
    {
        $share = 'createdeletedirectory' . $this->createSuffix();
        $this->createShare($share);

        $this->createDirectory($share, 'testdirectory0');
        $this->createDirectory($share, 'testdirectory0/testdirectory00');
        $this->createDirectory($share, 'testdirectory0/testdirectory01');
        $this->createDirectory($share, 'testdirectory1');
        $this->createDirectory($share, 'testdirectory1/testdirectory10');
        $this->createDirectory($share, 'testdirectory0/testdirectory00/testdirectory000');

        $result = $this->restProxy->listDirectoriesAndFiles($share);

        $validator = static function ($directories, $target) {
            $result = false;
            foreach ($directories as $directory) {
                if ($directory->getName() == $target) {
                    $result = true;
                    break;
                }
            }
            return $result;
        };

        self::assertTrue($validator($result->getDirectories(), 'testdirectory1'));
        self::assertTrue($validator($result->getDirectories(), 'testdirectory0'));
        $result = $this->restProxy->listDirectoriesAndFiles(
            $share,
            'testdirectory0'
        );
        self::assertTrue($validator($result->getDirectories(), 'testdirectory01'));
        self::assertTrue($validator($result->getDirectories(), 'testdirectory00'));
        $result = $this->restProxy->listDirectoriesAndFiles(
            $share,
            'testdirectory1'
        );
        self::assertTrue($validator($result->getDirectories(), 'testdirectory10'));
        $result = $this->restProxy->listDirectoriesAndFiles(
            $share,
            'testdirectory0/testdirectory00'
        );
        self::assertTrue($validator($result->getDirectories(), 'testdirectory000'));
    }

    public function testGetDirectoryProperties()
    {
        $share = 'getdirectoryproperties' . $this->createSuffix();
        $this->createShare($share);

        $metadata = [
            'testmeta1' => 'testmetacontent1',
            'testmeta2' => 'testmetacontent2',
            'testmeta3' => 'testmetacontent3',
            'testmeta4' => 'testmetacontent4',
            'testmeta5' => 'testmetacontent5',
            'testmeta6' => 'testmetacontent6',
        ];

        $options = new CreateDirectoryOptions();
        $options->setMetadata($metadata);

        $this->createDirectory($share, 'testdirectory', $options);

        $result = $this->restProxy->getDirectoryProperties($share, 'testdirectory');

        $actual = $result->getMetadata();

        foreach ($metadata as $key => $value) {
            self::assertArrayHasKey($key, $actual);
            self::assertEquals($value, $actual[$key]);
        }
    }

    public function testGetSetDirectoryMetadata()
    {
        $share = 'getdirectorymetadata' . $this->createSuffix();
        $this->createShare($share);

        $metadata = [
            'testmeta1' => 'testmetacontent1',
            'testmeta2' => 'testmetacontent2',
            'testmeta3' => 'testmetacontent3',
            'testmeta4' => 'testmetacontent4',
            'testmeta5' => 'testmetacontent5',
            'testmeta6' => 'testmetacontent6',
        ];

        $options = new CreateDirectoryOptions();
        $options->setMetadata($metadata);

        $this->createDirectory($share, 'testdirectory', $options);

        $result = $this->restProxy->getDirectoryMetadata($share, 'testdirectory');

        $actual = $result->getMetadata();

        foreach ($metadata as $key => $value) {
            self::assertArrayHasKey($key, $actual);
            self::assertEquals($value, $actual[$key]);
        }

        $metadata = [
            'testmeta11' => 'testmetacontent11',
            'testmeta22' => 'testmetacontent22',
            'testmeta33' => 'testmetacontent33',
            'testmeta44' => 'testmetacontent44',
            'testmeta55' => 'testmetacontent55',
            'testmeta66' => 'testmetacontent66',
        ];

        $result = $this->restProxy->setDirectoryMetadata(
            $share,
            'testdirectory',
            $metadata
        );

        $result = $this->restProxy->getDirectoryMetadata($share, 'testdirectory');

        $actual = $result->getMetadata();

        foreach ($metadata as $key => $value) {
            self::assertArrayHasKey($key, $actual);
            self::assertEquals($value, $actual[$key]);
        }
    }

    public function testCreateDeleteFile()
    {
        $share = 'createdeletefile' . $this->createSuffix();
        $this->createShare($share);

        $fileName = 'testfile';

        $this->restProxy->createFile($share, $fileName, Resources::GB_IN_BYTES);
        $result = $this->restProxy->listDirectoriesAndFiles($share, '');

        $actualFiles = $result->getFiles();

        $found = false;

        foreach ($actualFiles as $file) {
            if ($file->getName() == $fileName) {
                $found = true;
                break;
            }
        }
        self::assertTrue($found);

        $this->restProxy->deleteFile($share, $fileName);

        $result = $this->restProxy->listDirectoriesAndFiles($share, '');

        $actualFiles = $result->getFiles();

        $found = false;

        foreach ($actualFiles as $file) {
            if ($file->getName() == $fileName) {
                $found = true;
                break;
            }
        }

        self::assertTrue(!$found);
    }

    public function testGetSetFileProperties()
    {
        $share = 'getsetfileproperties' . $this->createSuffix();
        $this->createShare($share);
        $fileName = 'testfile';
        $this->restProxy->createFile($share, $fileName, Resources::GB_IN_BYTES);

        $properties = $this->restProxy->getFileProperties($share, $fileName);

        self::assertEquals(Resources::GB_IN_BYTES, $properties->getContentLength());

        $properties->setCacheControl('no-cache');
        $properties->setContentType('pdf');
        $md5 = \md5('testString');
        $properties->setContentMD5($md5);
        $properties->setContentEncoding('gzip');
        $properties->setContentLanguage('en');
        $properties->setContentDisposition('attachment');
        $properties->setContentLength(Resources::MB_IN_BYTES_1);

        $this->restProxy->setFileProperties($share, $fileName, $properties);

        $newProperties = $this->restProxy->getFileProperties($share, $fileName);

        self::assertEquals(
            $properties->getCacheControl(),
            $newProperties->getCacheControl()
        );
        self::assertEquals(
            $properties->getContentType(),
            $newProperties->getContentType()
        );
        self::assertEquals(
            $properties->getContentMD5(),
            $newProperties->getContentMD5()
        );
        self::assertEquals(
            $properties->getContentEncoding(),
            $newProperties->getContentEncoding()
        );
        self::assertEquals(
            $properties->getContentLanguage(),
            $newProperties->getContentLanguage()
        );
        self::assertEquals(
            $properties->getContentDisposition(),
            $newProperties->getContentDisposition()
        );
        self::assertEquals(
            $properties->getContentLength(),
            $newProperties->getContentLength()
        );
    }

    public function testGetSetFileMetadata()
    {
        $share = 'getsetfilemetadata' . $this->createSuffix();
        $this->createShare($share);
        $fileName = 'testfile';
        $this->restProxy->createFile($share, $fileName, Resources::GB_IN_BYTES);

        $metadata = [
            'testmeta11' => 'testmetacontent11',
            'testmeta22' => 'testmetacontent22',
            'testmeta33' => 'testmetacontent33',
            'testmeta44' => 'testmetacontent44',
            'testmeta55' => 'testmetacontent55',
            'testmeta66' => 'testmetacontent66',
        ];

        $this->restProxy->setFileMetadata($share, $fileName, $metadata);

        $result = $this->restProxy->getFileMetadata($share, $fileName);

        $actual = $result->getMetadata();

        foreach ($metadata as $key => $value) {
            self::assertArrayHasKey($key, $actual);
            self::assertEquals($value, $actual[$key]);
        }
    }

    public function testPutFileRange()
    {
        $share = 'putfilerange' . $this->createSuffix();
        $this->createShare($share);
        $fileName = 'testfile';
        $this->restProxy->createFile($share, $fileName, Resources::MB_IN_BYTES_4);
        $content = openssl_random_pseudo_bytes(Resources::MB_IN_BYTES_4);
        $range = new Range(0, Resources::MB_IN_BYTES_4 - 1);

        $this->restProxy->putFileRange($share, $fileName, $content, $range);

        $result = $this->restProxy->getFile($share, $fileName);

        $actual = \stream_get_contents($result->getContentStream());

        self::assertTrue($content == $actual);
    }

    public function testClearFileRange()
    {
        $share = 'clearfilerange' . $this->createSuffix();
        $this->createShare($share);
        $fileName = 'testfile';
        $this->restProxy->createFile($share, $fileName, Resources::MB_IN_BYTES_4);
        $content = openssl_random_pseudo_bytes(Resources::MB_IN_BYTES_4);
        $range = new Range(0, Resources::MB_IN_BYTES_4 - 1);

        $this->restProxy->putFileRange($share, $fileName, $content, $range);

        $result = $this->restProxy->getFile($share, $fileName);

        $actual = \stream_get_contents($result->getContentStream());

        self::assertEquals($content, $actual);

        $this->restProxy->clearFileRange($share, $fileName, $range);

        $result = $this->restProxy->getFile($share, $fileName);

        $actual = \stream_get_contents($result->getContentStream());

        self::assertTrue(
            str_pad('', Resources::MB_IN_BYTES_4, "\0", STR_PAD_LEFT) ==
            $actual
        );
    }

    public function testListFileRange()
    {
        $share = 'listfilerange' . $this->createSuffix();
        $this->createShare($share);
        $fileName = 'testfile';
        $this->restProxy->createFile($share, $fileName, Resources::MB_IN_BYTES_4);
        $content = openssl_random_pseudo_bytes(Resources::MB_IN_BYTES_1);
        $range0 = new Range(0, Resources::MB_IN_BYTES_1 - 1);
        $range1 = new Range(
            Resources::MB_IN_BYTES_1 * 2,
            Resources::MB_IN_BYTES_1 * 3 - 1
        );

        $this->restProxy->putFileRange($share, $fileName, $content, $range0);
        $this->restProxy->putFileRange($share, $fileName, $content, $range1);

        $result = $this->restProxy->listFileRange($share, $fileName);

        $ranges = $result->getRanges();

        self::assertEquals(0, $ranges[0]->getStart());
        self::assertEquals(Resources::MB_IN_BYTES_1 - 1, $ranges[0]->getEnd());
        self::assertEquals(Resources::MB_IN_BYTES_1 * 2, $ranges[1]->getStart());
        self::assertEquals(Resources::MB_IN_BYTES_1 * 3 - 1, $ranges[1]->getEnd());
    }

    public function testCopyFile()
    {
        $share = 'copyfile' . $this->createSuffix();
        $this->createShare($share);
        $fileName = 'testfile';
        $this->restProxy->createFile($share, $fileName, Resources::MB_IN_BYTES_4);
        $content = openssl_random_pseudo_bytes(Resources::MB_IN_BYTES_4);
        $range = new Range(0, Resources::MB_IN_BYTES_4 - 1);

        $this->restProxy->putFileRange($share, $fileName, $content, $range);

        $source = sprintf(
            '%s%s/%s',
            (string) $this->restProxy->getPsrPrimaryUri(),
            $share,
            $fileName
        );

        $destFileName = 'destfile';

        $metadata = [
            'testmeta11' => 'testmetacontent11',
            'testmeta22' => 'testmetacontent22',
            'testmeta33' => 'testmetacontent33',
            'testmeta44' => 'testmetacontent44',
            'testmeta55' => 'testmetacontent55',
            'testmeta66' => 'testmetacontent66',
        ];

        $this->restProxy->copyFile($share, $destFileName, $source, $metadata);

        \sleep(10);

        $result = $this->restProxy->getFile($share, $destFileName);

        $expectedContent = \stream_get_contents($result->getContentStream());
        $expectedMetadata = $result->getMetadata();

        foreach ($metadata as $key => $value) {
            self::assertArrayHasKey($key, $expectedMetadata);
            self::assertEquals($value, $expectedMetadata[$key]);
        }

        self::assertTrue($content == $expectedContent);
    }

    public function testAbortCopy()
    {
        $this->expectException(\AzureOSS\Storage\Common\Exceptions\ServiceException::class);
        $this->expectExceptionMessage('There is currently no pending copy operation');

        $share = 'abortcopy' . $this->createSuffix();
        $this->createShare($share);
        $fileName = 'testfile';
        $this->restProxy->createFile($share, $fileName, Resources::MB_IN_BYTES_4);

        $copyID = 'af6157e2-e79b-4353-a111-87dd8720caf5';
        $this->restProxy->abortCopy($share, $fileName, $copyID);
    }

    public function testCreateFileFromContent()
    {
        $share = 'createfilefromcontent' . $this->createSuffix();
        $this->createShare($share);
        $content0 = openssl_random_pseudo_bytes(Resources::MB_IN_BYTES_4);
        $content1 = openssl_random_pseudo_bytes(Resources::MB_IN_BYTES_4);
        $content1 = str_pad($content1, Resources::MB_IN_BYTES_4 * 2, "\0", STR_PAD_RIGHT);
        $content1 .= openssl_random_pseudo_bytes(Resources::MB_IN_BYTES_4);
        $content1 = str_pad($content1, Resources::MB_IN_BYTES_4 * 4, "\0", STR_PAD_RIGHT);
        $content2 = openssl_random_pseudo_bytes(Resources::MB_IN_BYTES_4 * 4);
        $content3 = '';

        $testfile0 = 'testfile0';
        $testfile1 = 'testfile1';
        $testfile2 = 'testfile2';
        $testfile3 = 'testfile3';

        $options = new CreateFileFromContentOptions();
        $options->setUseTransactionalMD5(true);
        $this->restProxy->createFileFromContent($share, $testfile0, $content0, $options);
        $this->restProxy->createFileFromContent($share, $testfile1, $content1, $options);
        $this->restProxy->createFileFromContent($share, $testfile2, $content2, $options);
        $this->restProxy->createFileFromContent($share, $testfile3, $content3, $options);

        $result = $this->restProxy->getFile($share, $testfile0);
        $actual0 = \stream_get_contents($result->getContentStream());
        $result = $this->restProxy->getFile($share, $testfile1);
        $actual1 = \stream_get_contents($result->getContentStream());
        $result = $this->restProxy->getFile($share, $testfile2);
        $actual2 = \stream_get_contents($result->getContentStream());
        $result = $this->restProxy->getFile($share, $testfile3);

        self::assertTrue($content0 == $actual0);
        self::assertTrue($content1 == $actual1);
        self::assertTrue($content2 == $actual2);
        self::assertTrue($result->getProperties()->getContentLength() == 0);
    }
}

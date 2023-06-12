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

namespace MicrosoftAzure\Storage\Tests\Unit\Common\Models;

use MicrosoftAzure\Storage\Blob\Models\BlobAccessPolicy;
use MicrosoftAzure\Storage\Common\Models\SignedIdentifier;

/**
 * Unit tests for class SignedIdentifier
 *
 * @link      https://github.com/azure/azure-storage-php
 */
class SignedIdentifierTest extends \PHPUnit\Framework\TestCase
{
    public function testGetId()
    {
        // Setup
        $signedIdentifier = new SignedIdentifier();
        $expected = 'MTIzNDU2Nzg5MDEyMzQ1Njc4OTAxMjM0NTY3ODkwMTI=';
        $signedIdentifier->setId($expected);

        // Test
        $actual = $signedIdentifier->getId();

        // Assert
        self::assertEquals($expected, $actual);
    }

    public function testSetId()
    {
        // Setup
        $signedIdentifier = new SignedIdentifier();
        $expected = 'MTIzNDU2Nzg5MDEyMzQ1Njc4OTAxMjM0NTY3ODkwMTI=';

        // Test
        $signedIdentifier->setId($expected);

        // Assert
        self::assertEquals($expected, $signedIdentifier->getId());
    }

    public function testGetAccessPolicy()
    {
        // Setup
        $signedIdentifier = new SignedIdentifier();
        $expected = new BlobAccessPolicy();
        $expected->setExpiry(new \DateTime('2009-09-29T08:49:37'));
        $expected->setPermission('rwd');
        $expected->setStart(new \DateTime('2009-09-28T08:49:37'));
        $signedIdentifier->setAccessPolicy($expected);

        // Test
        $actual = $signedIdentifier->getAccessPolicy();

        // Assert
        self::assertEquals($expected, $actual);
    }

    public function testSetAccessPolicy()
    {
        // Setup
        $signedIdentifier = new SignedIdentifier();
        $expected = new BlobAccessPolicy();
        $expected->setExpiry(new \DateTime('2009-09-29T08:49:37'));
        $expected->setPermission('rwd');
        $expected->setStart(new \DateTime('2009-09-28T08:49:37'));

        // Test
        $signedIdentifier->setAccessPolicy($expected);

        // Assert
        self::assertEquals($expected, $signedIdentifier->getAccessPolicy());

        return $signedIdentifier;
    }

    /**
     * @depends testSetAccessPolicy
     */
    public function testToXml($signedIdentifier)
    {
        // Setup
        $id = 'MTIzNDU2Nzg5MDEyMzQ1Njc4OTAxMjM0NTY3ODkwMTI=';
        $signedIdentifier->setId($id);

        // Test
        $array = $signedIdentifier->toArray();

        // Assert
        self::assertEquals($id, $array['SignedIdentifier']['Id']);
        self::assertArrayHasKey('AccessPolicy', $array['SignedIdentifier']);
    }
}

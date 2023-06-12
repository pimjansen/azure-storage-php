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

namespace MicrosoftAzure\Storage\Tests\Unit\File\Models;

use MicrosoftAzure\Storage\Common\Internal\Utilities;
use MicrosoftAzure\Storage\File\Models\ListSharesResult;
use MicrosoftAzure\Storage\Tests\Framework\TestResources;

/**
 * Unit tests for class ListSharesResult
 *
 * @see      https://github.com/azure/azure-storage-php
 */
class ListSharesResultTest extends \PHPUnit\Framework\TestCase
{
    public function testCreateWithEmpty()
    {
        // Setup
        $sample = TestResources::getInterestingListShareResultArray();

        // Test
        $actual = ListSharesResult::create($sample);

        // Assert
        self::assertCount(0, $actual->getShares());
    }

    public function testCreateWithOneEntry()
    {
        // Setup
        $sample = TestResources::getInterestingListShareResultArray(1);

        // Test
        $actual = ListSharesResult::create($sample);

        // Assert
        $shares = $actual->getShares();
        self::assertCount(1, $shares);
        self::assertEquals($sample['Shares']['Share']['Name'], $shares[0]->getName());
        self::assertEquals(
            Utilities::rfc1123ToDateTime(
                $sample['Shares']['Share']['Properties']['Last-Modified']
            ),
            $shares[0]->getProperties()->getLastModified()
        );
        self::assertEquals(
            $sample['Shares']['Share']['Properties']['Etag'],
            $shares[0]->getProperties()->getETag()
        );
        self::assertEquals($sample['Marker'], $actual->getMarker());
        self::assertEquals($sample['MaxResults'], $actual->getMaxResults());
        self::assertEquals($sample['NextMarker'], $actual->getNextMarker());
    }

    public function testCreateWithMultipleEntries()
    {
        // Setup
        $sample = TestResources::getInterestingListShareResultArray(5);

        // Test
        $actual = ListSharesResult::create($sample);

        // Assert
        $shares = $actual->getShares();
        self::assertCount(5, $shares);
        for ($i = 0; $i < 5; ++$i) {
            self::assertEquals($sample['Shares']['Share'][$i]['Name'], $shares[$i]->getName());
            self::assertEquals(
                Utilities::rfc1123ToDateTime($sample['Shares']['Share'][$i]['Properties']['Last-Modified']),
                $shares[$i]->getProperties()->getLastModified()
            );
            self::assertEquals(
                $sample['Shares']['Share'][$i]['Properties']['Etag'],
                $shares[$i]->getProperties()->getETag()
            );
        }
    }
}

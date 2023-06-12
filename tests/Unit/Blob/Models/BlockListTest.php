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

use MicrosoftAzure\Storage\Blob\Models\BlobBlockType;
use MicrosoftAzure\Storage\Blob\Models\Block;
use MicrosoftAzure\Storage\Blob\Models\BlockList;
use MicrosoftAzure\Storage\Common\Internal\Serialization\XmlSerializer;

/**
 * Unit tests for class BlockList
 *
 * @see      https://github.com/azure/azure-storage-php
 */
class BlockListTest extends \PHPUnit\Framework\TestCase
{
    public function testAddEntry()
    {
        // Setup
        $expectedId = '1234';
        $expectedType = BlobBlockType::COMMITTED_TYPE;
        $blockList = new BlockList();

        // Test
        $blockList->addEntry($expectedId, $expectedType);

        // Assert
        $entry = $blockList->getEntry($expectedId);
        self::assertEquals($expectedType, $entry->getType());
    }

    public function testGetEntries()
    {
        // Setup
        $expectedId = '1234';
        $expectedType = BlobBlockType::COMMITTED_TYPE;
        $blockList = new BlockList();
        $blockList->addEntry($expectedId, $expectedType);

        // Test
        $entries = $blockList->getEntries();

        // Assert
        self::assertCount(1, $entries);
    }

    public function testAddCommittedEntry()
    {
        // Setup
        $expectedId = '1234';
        $expectedType = BlobBlockType::COMMITTED_TYPE;
        $blockList = new BlockList();

        // Test
        $blockList->addCommittedEntry($expectedId, $expectedType);

        // Assert
        $entry = $blockList->getEntry($expectedId);
        self::assertEquals($expectedId, $entry->getBlockId());
        self::assertEquals($expectedType, $entry->getType());
    }

    public function testAddUncommittedEntry()
    {
        // Setup
        $expectedId = '1234';
        $expectedType = BlobBlockType::UNCOMMITTED_TYPE;
        $blockList = new BlockList();

        // Test
        $blockList->addUncommittedEntry($expectedId, $expectedType);

        // Assert
        $entry = $blockList->getEntry($expectedId);
        self::assertEquals($expectedId, $entry->getBlockId());
        self::assertEquals($expectedType, $entry->getType());
    }

    public function testAddLatestEntry()
    {
        // Setup
        $expectedId = '1234';
        $expectedType = BlobBlockType::LATEST_TYPE;
        $blockList = new BlockList();

        // Test
        $blockList->addLatestEntry($expectedId, $expectedType);

        // Assert
        $entry = $blockList->getEntry($expectedId);
        self::assertEquals($expectedId, $entry->getBlockId());
        self::assertEquals($expectedType, $entry->getType());
    }

    public function testCreate()
    {
        // Setup
        $block1 = new Block();
        $block1->setBlockId('123');
        $block1->setType(BlobBlockType::COMMITTED_TYPE);
        $block2 = new Block();
        $block2->setBlockId('223');
        $block2->setType(BlobBlockType::UNCOMMITTED_TYPE);
        $block3 = new Block();
        $block3->setBlockId('333');
        $block3->setType(BlobBlockType::LATEST_TYPE);

        // Test
        $blockList = BlockList::create([$block1, $block2, $block3]);

        // Assert
        self::assertCount(3, $blockList->getEntries());
        $b1 = $blockList->getEntry($block1->getBlockId());
        $b2 = $blockList->getEntry($block2->getBlockId());
        $b3 = $blockList->getEntry($block3->getBlockId());
        self::assertEquals($block1, $b1);
        self::assertEquals($block2, $b2);
        self::assertEquals($block3, $b3);
    }

    public function testToXml()
    {
        // Setup
        $blockList = new BlockList();
        $blockList->addLatestEntry(base64_encode('1234'));
        $blockList->addCommittedEntry(base64_encode('1239'));
        $blockList->addLatestEntry(base64_encode('1236'));
        $blockList->addCommittedEntry(base64_encode('1237'));
        $blockList->addUncommittedEntry(base64_encode('1238'));
        $blockList->addLatestEntry(base64_encode('1235'));
        $blockList->addUncommittedEntry(base64_encode('1240'));
        $expected = '<?xml version="1.0" encoding="UTF-8"?>' . "\n" .
                    '<BlockList>' . "\n" .
                    ' <Latest>MTIzNA==</Latest>' . "\n" .
                    ' <Committed>MTIzOQ==</Committed>' . "\n" .
                    ' <Latest>MTIzNg==</Latest>' . "\n" .
                    ' <Committed>MTIzNw==</Committed>' . "\n" .
                    ' <Uncommitted>MTIzOA==</Uncommitted>' . "\n" .
                    ' <Latest>MTIzNQ==</Latest>' . "\n" .
                    ' <Uncommitted>MTI0MA==</Uncommitted>' . "\n" .
                    '</BlockList>' . "\n";

        // Test
        $actual = $blockList->toXml(new XmlSerializer());

        // Assert
        self::assertEquals($expected, $actual);
    }
}

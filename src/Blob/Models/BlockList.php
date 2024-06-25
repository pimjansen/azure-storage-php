<?php

namespace AzureOSS\Storage\Blob\Models;

use AzureOSS\Storage\Blob\Internal\BlobResources as Resources;
use AzureOSS\Storage\Common\Internal\Serialization\XmlSerializer;
use AzureOSS\Storage\Common\Internal\Validate;

class BlockList
{
    private $entries;
    private static $xmlRootName = 'BlockList';

    /**
     * Creates block list from array of blocks.
     *
     * @param Block[] The blocks array.
     *
     * @return BlockList
     */
    public static function create(array $array)
    {
        $blockList = new BlockList();

        foreach ($array as $value) {
            $blockList->addEntry($value->getBlockId(), $value->getType());
        }

        return $blockList;
    }

    /**
     * Adds new entry to the block list entries.
     *
     * @param string $blockId The block id.
     * @param string $type    The entry type, you can use BlobBlockType.
     */
    public function addEntry($blockId, $type)
    {
        Validate::canCastAsString($blockId, 'blockId');
        Validate::isTrue(
            BlobBlockType::isValid($type),
            sprintf(Resources::INVALID_BTE_MSG, get_class(new BlobBlockType())),
        );
        $block = new Block();
        $block->setBlockId($blockId);
        $block->setType($type);

        $this->entries[] = $block;
    }

    /**
     * Addds committed block entry.
     *
     * @param string $blockId The block id.
     */
    public function addCommittedEntry($blockId)
    {
        $this->addEntry($blockId, BlobBlockType::COMMITTED_TYPE);
    }

    /**
     * Addds uncommitted block entry.
     *
     * @param string $blockId The block id.
     */
    public function addUncommittedEntry($blockId)
    {
        $this->addEntry($blockId, BlobBlockType::UNCOMMITTED_TYPE);
    }

    /**
     * Addds latest block entry.
     *
     * @param string $blockId The block id.
     */
    public function addLatestEntry($blockId)
    {
        $this->addEntry($blockId, BlobBlockType::LATEST_TYPE);
    }

    /**
     * Gets blob block entry.
     *
     * @param string $blockId The id of the block.
     *
     * @return Block
     */
    public function getEntry($blockId)
    {
        foreach ($this->entries as $value) {
            if ($blockId == $value->getBlockId()) {
                return $value;
            }
        }

        return null;
    }

    /**
     * Gets all blob block entries.
     *
     * @return Block[]
     */
    public function getEntries()
    {
        return $this->entries;
    }

    /**
     * Converts the  BlockList object to XML representation
     *
     * @param XmlSerializer $xmlSerializer The XML serializer.
     *
     * @internal
     *
     * @return string
     */
    public function toXml(XmlSerializer $xmlSerializer)
    {
        $properties = [XmlSerializer::ROOT_NAME => self::$xmlRootName];
        $array = [];

        foreach ($this->entries as $value) {
            $array[] = [
                $value->getType() => $value->getBlockId(),
            ];
        }

        return $xmlSerializer->serialize($array, $properties);
    }
}

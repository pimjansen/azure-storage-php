<?php

namespace AzureOSS\Storage\Blob\Models;

class Block
{
    private $_blockId;
    private $_type;

    /**
     * Constructor.
     *
     * @param string $blockId The ID of this block.
     * @param string $type    The type of the block.
     */
    public function __construct($blockId = '', $type = '')
    {
        $this->_blockId = $blockId;
        $this->_type = $type;
    }

    /**
     * Sets the blockId.
     *
     * @param string $blockId The id of the block.
     */
    public function setBlockId($blockId)
    {
        $this->_blockId = $blockId;
    }

    /**
     * Gets the blockId.
     *
     * @return string
     */
    public function getBlockId()
    {
        return $this->_blockId;
    }

    /**
     * Sets the type.
     *
     * @param string $type The type of the block.
     */
    public function setType($type)
    {
        $this->_type = $type;
    }

    /**
     * Gets the type.
     *
     * @return string
     */
    public function getType()
    {
        return $this->_type;
    }
}

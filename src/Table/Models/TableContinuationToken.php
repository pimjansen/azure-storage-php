<?php

namespace AzureOSS\Storage\Table\Models;

use AzureOSS\Storage\Common\Internal\Validate;
use AzureOSS\Storage\Common\Models\ContinuationToken;

class TableContinuationToken extends ContinuationToken
{
    private $nextPartitionKey;
    private $nextRowKey;
    private $nextTableName;

    public function __construct(
        $nextTableName = '',
        $nextPartitionKey = '',
        $nextRowKey = '',
        $location = ''
    ) {
        parent::__construct($location);
        $this->setNextTableName($nextTableName);
        $this->setNextPartitionKey($nextPartitionKey);
        $this->setNextRowKey($nextRowKey);
    }

    /**
     * Gets entity next partition key.
     *
     * @return string
     */
    public function getNextPartitionKey()
    {
        return $this->nextPartitionKey;
    }

    /**
     * Sets entity next partition key.
     *
     * @param string $nextPartitionKey The entity next partition key value.
     */
    public function setNextPartitionKey($nextPartitionKey)
    {
        Validate::canCastAsString($nextPartitionKey, 'nextPartitionKey');
        $this->nextPartitionKey = $nextPartitionKey;
    }

    /**
     * Gets entity next row key.
     *
     * @return string
     */
    public function getNextRowKey()
    {
        return $this->nextRowKey;
    }

    /**
     * Sets entity next row key.
     *
     * @param string $nextRowKey The entity next row key value.
     */
    public function setNextRowKey($nextRowKey)
    {
        Validate::canCastAsString($nextRowKey, 'nextRowKey');
        $this->nextRowKey = $nextRowKey;
    }

    /**
     * Gets nextTableName
     *
     * @return string
     */
    public function getNextTableName()
    {
        return $this->nextTableName;
    }

    /**
     * Sets nextTableName
     *
     * @param string $nextTableName value
     */
    public function setNextTableName($nextTableName)
    {
        Validate::canCastAsString($nextTableName, 'nextTableName');
        $this->nextTableName = $nextTableName;
    }
}

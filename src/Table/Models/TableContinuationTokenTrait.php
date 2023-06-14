<?php

namespace AzureOSS\Storage\Table\Models;

trait TableContinuationTokenTrait
{
    /**
     * @var TableContinuationToken
     */
    private $continuationToken;

    /**
     * Setter for continuationToken
     *
     * @param TableContinuationToken $continuationToken the continuation token to be set.
     */
    public function setContinuationToken($continuationToken)
    {
        $this->continuationToken = $continuationToken;
    }

    /**
     * Getter for continuationToken
     *
     * @return TableContinuationToken
     */
    public function getContinuationToken()
    {
        return $this->continuationToken;
    }

    /**
     * Gets for location for previous request.
     *
     * @return string|null
     */
    public function getLocation()
    {
        if ($this->continuationToken == null) {
            return null;
        }
        return $this->continuationToken->getLocation();
    }

    public function getLocationMode()
    {
        if ($this->continuationToken == null) {
            return parent::getLocationMode();
        }
        if ($this->continuationToken->getLocation() == '') {
            return parent::getLocationMode();
        }
        return $this->getLocation();
    }

    /**
     * Gets nextTableName
     *
     * @return string|null
     */
    public function getNextTableName()
    {
        if ($this->continuationToken == null) {
            return null;
        }
        return $this->continuationToken->getNextTableName();
    }

    /**
     * Gets entity next partition key.
     *
     * @return string|null
     */
    public function getNextPartitionKey()
    {
        if ($this->continuationToken == null) {
            return null;
        }
        return $this->continuationToken->getNextPartitionKey();
    }

    /**
     * Gets entity next row key.
     *
     * @return string|null
     */
    public function getNextRowKey()
    {
        if ($this->continuationToken == null) {
            return null;
        }
        return $this->continuationToken->getNextRowKey();
    }

    /**
     * Sets entity next row key.
     *
     * @param string $nextRowKey The entity next row key value.
     */
    public function setNextRowKey($nextRowKey)
    {
        if ($this->continuationToken == null) {
            $this->setContinuationToken(new TableContinuationToken());
        }
        $this->continuationToken->setNextRowKey($nextRowKey);
    }

    /**
     * Sets entity next partition key.
     *
     * @param string $nextPartitionKey The entity next partition key value.
     */
    public function setNextPartitionKey($nextPartitionKey)
    {
        if ($this->continuationToken == null) {
            $this->setContinuationToken(new TableContinuationToken());
        }
        $this->continuationToken->setNextPartitionKey($nextPartitionKey);
    }

    /**
     * Sets nextTableName
     *
     * @param string $nextTableName value
     */
    public function setNextTableName($nextTableName)
    {
        if ($this->continuationToken == null) {
            $this->setContinuationToken(new TableContinuationToken());
        }
        $this->continuationToken->setNextTableName($nextTableName);
    }
}

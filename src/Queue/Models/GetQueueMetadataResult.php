<?php

namespace AzureOSS\Storage\Queue\Models;

class GetQueueMetadataResult
{
    private $_approximateMessageCount;
    private $_metadata;

    /**
     * Constructor
     *
     * @param int   $approximateMessageCount Approximate number of queue messages.
     * @param array $metadata                user defined metadata.
     *
     * @internal
     */
    public function __construct($approximateMessageCount, array $metadata)
    {
        $this->setApproximateMessageCount($approximateMessageCount);
        $this->setMetadata(null === $metadata ? [] : $metadata);
    }

    /**
     * Gets approximate message count.
     *
     * @return int
     */
    public function getApproximateMessageCount()
    {
        return $this->_approximateMessageCount;
    }

    /**
     * Sets approximate message count.
     *
     * @param int $approximateMessageCount value to use.
     *
     * @internal
     */
    protected function setApproximateMessageCount($approximateMessageCount)
    {
        $this->_approximateMessageCount = $approximateMessageCount;
    }

    /**
     * Sets metadata.
     *
     * @return array
     */
    public function getMetadata()
    {
        return $this->_metadata;
    }

    /**
     * Sets metadata.
     *
     * @param array $metadata value to use.
     *
     * @internal
     */
    protected function setMetadata(array $metadata)
    {
        $this->_metadata = $metadata;
    }
}

<?php

namespace AzureOSS\Storage\Queue\Models;

class PeekMessagesOptions extends QueueServiceOptions
{
    private $_numberOfMessages;

    /**
     * Gets numberOfMessages field.
     *
     * @return int
     */
    public function getNumberOfMessages()
    {
        return $this->_numberOfMessages;
    }

    /**
     * Sets numberOfMessages field.
     *
     * @param int $numberOfMessages value to use.
     */
    public function setNumberOfMessages($numberOfMessages)
    {
        $this->_numberOfMessages = $numberOfMessages;
    }
}
